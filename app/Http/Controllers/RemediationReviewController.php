<?php

namespace App\Http\Controllers;

use App\DataTables\RemediationsDataTable;
use App\Enums\FailedQuestion;
use App\Models\CompletedJob;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\Remediation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RemediationReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RemediationsDataTable $remediationsDataTable)
    {
        // // Get jobs with job_status_id = 16 and for this installer
        // $jobs = Job::whereIn('job_status_id', [16, 26])
        //     ->whereHas('completedJobs', function ($q) {
        //         $q->whereIn('pass_fail', FailedQuestion::values())
        //             ->where(function ($subQ) {
        //                 // Case 1: No remediations at all
        //                 $subQ->whereHas('remediations', function ($q2) {
        //                     $q2->where(function ($query) {
        //                         $query->where('role', 'Installer')
        //                             ->orWhereNull('role');
        //                     })
        //                         ->whereRaw('id = (SELECT id FROM remediations WHERE completed_job_id = completed_jobs.id ORDER BY created_at DESC LIMIT 1)');
        //                 });
        //             });
        //     })
        //     ->get();

        // return view('pages.remediation-review.index')
        //     ->with('jobs', $jobs);

        return $remediationsDataTable->render('pages.remediation-review.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Export remediation review jobs to CSV using current filters.
     */
    public function exportCsv(Request $request, RemediationsDataTable $remediationsDataTable)
    {
        set_time_limit(0);

        $query = $remediationsDataTable->query(new Job())
            ->with([
                'jobMeasure.measure',
                'jobStatus',
                'installer.user',
                'property',
                'remediation',
            ]);

        $dataTable = $remediationsDataTable->dataTable($query);

        if (method_exists($dataTable, 'skipPaging')) {
            $dataTable->skipPaging();
        }

        if (method_exists($dataTable, 'getFilteredQuery')) {
            $query = $dataTable->getFilteredQuery();
        }

        $filename = 'Remediations_' . now()->format('YmdHis') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            $headers = [
                'Job Number',
                'Status',
                'Cert#',
                'UMR',
                'Installer',
                'Measure',
                'Address',
                'Postcode',
                'Non-Compliance Type',
                'Inspection Date',
                'Evidence Submission Date',
                'Rework Deadline',
                'Reinspect Deadline',
            ];

            fputcsv($handle, $headers);

            $writeRows = function ($jobs) use ($handle) {
                foreach ($jobs as $job) {
                    $installer = trim(($job->installer?->user?->firstname ?? '') . ' ' . ($job->installer?->user?->lastname ?? ''));
                    $installer = $installer !== '' ? $installer : 'N/A';

                    $address = trim(($job->property?->house_flat_prefix ?? '') . ' ' . ($job->property?->address1 ?? ''));
                    $address = $address !== '' ? $address : 'N/A';

                    $remediationDate = $job->remediation->last()?->created_at;
                    $reinspectDeadline = $remediationDate
                        ? Carbon::parse($remediationDate)->addDays(21)->format('Y-m-d H:i:s')
                        : 'N/A';

                    fputcsv($handle, [
                        $job->job_number,
                        $job->jobStatus?->description ?? 'N/A',
                        $job->cert_no,
                        $job->jobMeasure?->umr ?? 'N/A',
                        $installer,
                        $job->jobMeasure?->measure?->measure_cat ?? 'N/A',
                        $address,
                        $job->property?->postcode ?? 'N/A',
                        $job->job_remediation_type ?? 'N/A',
                        $job->first_visit_by ?? 'N/A',
                        $remediationDate ?? 'N/A',
                        $job->rework_deadline ?? 'N/A',
                        $reinspectDeadline,
                    ]);
                }
            };

            if ($query instanceof \Illuminate\Support\Enumerable) {
                $writeRows(collect($query)->sortBy('id'));
                fclose($handle);
                return;
            }

            if ($query instanceof \Illuminate\Database\Eloquent\Builder || $query instanceof \Illuminate\Database\Query\Builder) {
                $query->orderBy('id')->chunk(1000, function ($jobs) use ($writeRows) {
                    $writeRows($jobs);
                });
                fclose($handle);
                return;
            }

            $writeRows(collect($query)->sortBy('id'));
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = Job::findOrFail($id);
        $completedJobs = CompletedJob::where('job_id', $job->id)
            ->whereIn('pass_fail', FailedQuestion::values())
            ->get();


        return view('pages.remediation-review.show')
            ->with('job', $job)
            ->with('completedJobs', $completedJobs);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $completedJob = CompletedJob::findOrFail($id);
        $remediations = Remediation::where('completed_job_id', $completedJob->id)
            ->get();

        return view('pages.remediation-review.edit')
            ->with('completedJob', $completedJob)
            ->with('remediations', $remediations);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $jobStatus = JobStatus::findOrFail($request->job_status_id);
        $job = Job::findOrFail($id);
        $completedJobs = CompletedJob::where('job_id', $job->id)
            ->whereIn('pass_fail', FailedQuestion::values())
            ->get();

        foreach ($completedJobs as $completedJob) {
            $remediation = new Remediation;

            $remediation->job_id = $job->id;
            $remediation->completed_job_id = $completedJob->id;
            $remediation->comment = $request->notes;
            $remediation->role = 'Agent';
            $remediation->user_id = auth()->user()->id;

            $remediation->save();

        }

        $job->job_status_id = $jobStatus->id;
        $job->close_date = now();
        $job->last_update = now();
        // $job->notes = $request->notes ?? '';

        $job->save();

        return redirect()
            ->route('remediation-review.index');
    }
}
