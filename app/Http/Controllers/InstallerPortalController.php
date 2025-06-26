<?php

namespace App\Http\Controllers;

use App\Enums\FailedQuestion;
use App\Models\CompletedJob;
use App\Models\Installer;
use App\Models\Job;
use App\Models\Remediation;
use Illuminate\Http\Request;

class InstallerPortalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $installer = Installer::where('user_id', auth()->user()->id)->first();

        // Get jobs with job_status_id = 16 and for this installer
        $jobs = Job::where('job_status_id', 16)
            ->where('installer_id', $installer->id)
            ->whereHas('completedJobs', function ($q) {
                $q->whereIn('pass_fail', FailedQuestion::values())
                    ->where(function ($subQ) {
                        // Case 1: No remediations at all
                        $subQ->whereDoesntHave('remediations')
                            // Case 2: Latest remediation is Agent or null
                            ->orWhereHas('remediations', function ($q2) {
                            $q2->where(function ($query) {
                                $query->where('role', 'Agent')
                                    ->orWhereNull('role');
                            })
                                ->whereRaw('id = (SELECT id FROM remediations WHERE completed_job_id = completed_jobs.id ORDER BY created_at DESC LIMIT 1)');
                        });
                    });
            })
            ->get();

        return view('pages.installer-portal.index')
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

        $job = Job::findOrFail($id);
        $completedJobs = CompletedJob::where('job_id', $job->id)
            ->whereIn('pass_fail', FailedQuestion::values())
            ->get();

        $installerFirstAccess = CompletedJob::where('job_id', $job->id)
            ->get();

        $installerFirstAccess->each(function ($completedJob) {
            if ($completedJob->installer_first_access === null) {
                $completedJob->installer_first_access = now();
                $completedJob->save();
            }
        });

        return view('pages.installer-portal.show')
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

        if ($completedJob->installer_first_access_completed_job === null) {
            $completedJob->installer_first_access_completed_job = now();
            $completedJob->save();
        }

        return view('pages.installer-portal.edit')
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
    public function destroy(string $id)
    {
        //
    }
}
