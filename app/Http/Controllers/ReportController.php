<?php

namespace App\Http\Controllers;

use App\Enums\FailedQuestion;
use App\Enums\PassedQuestion;
use App\Models\CompletedJob;
use App\Models\Job;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $jobNC = Job::where('job_status_id', 16)
            ->where('job_remediation_type', 'NC')
            ->get();
        $jobCat1 = Job::where('job_status_id', 1)
            ->where('job_remediation_type', 'CAT1')
            ->get();
        $jobUnbooked = Job::where('job_status_id', 25)
            ->get();
        $jobBooked = Job::where('job_status_id', 1)
            ->get();
        $jobPassedRemedial = Job::whereIn('job_status_id', [30, 31])
            ->get();
        $jobCompleted = Job::whereIn('job_status_id', [1, 3, 16, 30, 31])
            ->get();
        $failedQuestions = CompletedJob::whereIn('pass_fail', FailedQuestion::values())
            ->orWhereIn('pass_fail', PassedQuestion::values())
            ->with(['job', 'job.jobMeasure', 'job.propertyInspector.user'])
            ->get();

        return view('pages.reports.index')
            ->with('jobNC', $jobNC)
            ->with('jobCat1', $jobCat1)
            ->with('jobUnbooked', $jobUnbooked)
            ->with('jobBooked', $jobBooked)
            ->with('jobPassedRemedial', $jobPassedRemedial)
            ->with('jobCompleted', $jobCompleted)
            ->with('failedQuestions', $failedQuestions);
    }
}
