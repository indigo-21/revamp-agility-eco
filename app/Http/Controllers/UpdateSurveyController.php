<?php

namespace App\Http\Controllers;

use App\DataTables\UpdateSurveyDataTable;
use App\Models\CompletedJob;
use App\Models\Job;
use Illuminate\Http\Request;

class UpdateSurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UpdateSurveyDataTable $updateSurveyDataTable)
    {
        // $jobs = Job::whereIn('job_status_id', [3, 16, 26])
        //     ->get();

        // return view('pages.update-survey.index')
        //     ->with('jobs', $jobs);

        return $updateSurveyDataTable->render('pages.update-survey.index');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $completedJob = CompletedJob::find($id);

        return view('pages.update-survey.upload-image')
            ->with('completedJob', $completedJob);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job = Job::firmDataOnly()->findOrFail($id);

        return view('pages.update-survey.edit')
            ->with('job', $job);
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
    public function destroy(string $id)
    {
        //
    }

    /**
     * Export update survey jobs to CSV using current filters.
     */
    public function exportCsv(Request $request, UpdateSurveyDataTable $updateSurveyDataTable)
    {
        set_time_limit(0);

        $query = $updateSurveyDataTable->query(new Job())
            ->with([
                'jobMeasure.measure',
                'jobStatus',
                'propertyInspector.user',
                'installer.user',
                'property',
            ]);

        $dataTable = $updateSurveyDataTable->dataTable($query);

        if (method_exists($dataTable, 'skipPaging')) {
            $dataTable->skipPaging();
        }

        if (method_exists($dataTable, 'getFilteredQuery')) {
            $query = $dataTable->getFilteredQuery();
        }

        $filename = 'UpdateSurvey_' . now()->format('YmdHis') . '.csv';

        return response()->streamDownload(function () use ($query) {
            $handle = fopen('php://output', 'w');

            $headers = [
                'Job Number',
                'Status',
                'Measure',
                'Cert#',
                'UMR',
                'Property Inspector',
                'Inspection Date',
                'Installer',
                'Address',
                'Postcode',
            ];

            fputcsv($handle, $headers);

            $writeRows = function ($jobs) use ($handle) {
                foreach ($jobs as $job) {
                    $propertyInspector = trim(($job->propertyInspector?->user?->firstname ?? '') . ' ' . ($job->propertyInspector?->user?->lastname ?? ''));
                    $propertyInspector = $propertyInspector !== '' ? $propertyInspector : 'N/A';

                    $installer = trim(($job->installer?->user?->firstname ?? '') . ' ' . ($job->installer?->user?->lastname ?? ''));
                    $installer = $installer !== '' ? $installer : 'N/A';

                    fputcsv($handle, [
                        $job->job_number,
                        $job->jobStatus?->description ?? 'N/A',
                        $job->jobMeasure?->measure?->measure_cat ?? 'N/A',
                        $job->cert_no,
                        $job->jobMeasure?->umr ?? 'N/A',
                        $propertyInspector,
                        $job->completedJobs->first()->created_at ?? 'N/A',
                        $installer,
                        $job->property?->address1 ?? 'N/A',
                        $job->property?->postcode ?? 'N/A',
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

            $jobs = $query instanceof \Illuminate\Support\Enumerable
                ? collect($query)
                : (is_array($query) ? collect($query) : collect());

            $writeRows($jobs->sortBy('id'));
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
