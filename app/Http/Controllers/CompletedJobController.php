<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\CompletedJob;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CompletedJobController extends Controller
{
    public function updateSurveyComment(Request $request, string $id)
    {

        $completedJob = CompletedJob::find($id);

        if (!$completedJob) {
            throw ValidationException::withMessages(['completed_job_id' => 'Completed job not found.']);
        }

        $completedJob->comments = $request->input('comments');

        $completedJob->save();

        return redirect()->back()->with('success', 'Survey comment updated successfully.');
    }

    public function updateSurveyPassFail(Request $request, string $id)
    {
        $completedJob = CompletedJob::find($id);

        if (!$completedJob) {
            throw ValidationException::withMessages(['completed_job_id' => 'Completed job not found.']);
        }

        $completedJob->pass_fail = $request->input('pass_fail');

        $completedJob->save();

        $completedJobs = CompletedJob::where('job_id', $request->job_id)
            ->whereIn('pass_fail', ["Non-Compliant"])
            ->count();

        $job = Job::find($request->job_id);
        $client = Client::find($job->client_id);

        $cat1Duration = $client->clientSlaMetric->cat1_reinspect_remediation_duration_unit;
        $ncDuration = $client->clientSlaMetric->nc_reinspect_remediation_duration_unit;
        $cat1ReinspectRemediation = (int) $client->clientSlaMetric->cat1_reinspect_remediation;
        $ncReinspectRemediation = (int) $client->clientSlaMetric->nc_reinspect_remediation;

        if ($completedJobs === 0) {

            $job->job_status_id = 3;
            $job->last_update = now();
            $job->close_date = now();
            $job->rework_deadline = null;

            $job->save();
        } else {
            $job->last_update = now();
            $job->job_remediation_type = "NC";

            if ($request->pass_fail === "Non-Compliant") {
                $job->job_status_id = 16;
                $job->close_date = null;

                if (Str::lower($completedJob->surveyQuestion->nc_severity) === "cat1") {
                    $job->rework_deadline = $cat1Duration === 2
                        ? now()->addDays($cat1ReinspectRemediation)
                        : now()->addHours($cat1ReinspectRemediation);

                    $job->job_remediation_type = "Cat1";
                } else {
                    if ($job->rework_deadline == null) {
                        $job->rework_deadline = $ncDuration === 2
                            ? now()->addDays($ncReinspectRemediation)
                            : now()->addHours($ncReinspectRemediation);
                    }

                    $job->job_remediation_type = "NC";
                }

            }

            $job->save();
        }

        return redirect()->back()->with('success', 'Survey pass/fail status updated successfully.');
    }
}
