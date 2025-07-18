<?php

namespace App\Http\Controllers;

use App\DataTables\RemediationsDataTable;
use App\Enums\FailedQuestion;
use App\Models\CompletedJob;
use App\Models\Job;
use App\Models\JobStatus;
use App\Models\Remediation;
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
