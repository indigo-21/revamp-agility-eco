<?php

namespace App\Http\Controllers;

use App\Enums\FailedQuestion;
use App\Models\CompletedJob;
use App\Models\Job;
use App\Models\Remediation;
use Illuminate\Http\Request;

class RemediationReinstateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = Job::whereIn('job_status_id', [32, 33, 34, 35])
            ->get();

        return view('pages.remediation-reinstate.index')
            ->with('jobs', $jobs);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job = Job::findOrFail($id);
        $completedJobs = CompletedJob::where('job_id', $job->id)
            ->whereIn('pass_fail', FailedQuestion::values())
            ->get();

        $job->last_update = now();
        $job->job_status_id = 16;
        $job->close_date = null; // Clear the close date

        $job->save();

        foreach ($completedJobs as $completedJob) {
            $remediation = new Remediation();

            $remediation->job_id = $job->id;
            $remediation->completed_job_id = $completedJob->id;
            $remediation->comment = "Job reinstated for Remediation Audit following installer`s request.";
            $remediation->role = 'Agent';
            $remediation->user_id = auth()->user()->id;

            $remediation->save();

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
