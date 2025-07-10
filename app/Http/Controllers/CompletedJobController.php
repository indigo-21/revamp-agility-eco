<?php

namespace App\Http\Controllers;

use App\Enums\FailedQuestion;
use App\Models\Client;
use App\Models\CompletedJob;
use App\Models\Job;
use App\Models\MessageTemplate;
use App\Models\UpdateSurvey;
use App\Services\MailService;
use App\Services\UpdateSurveyService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CompletedJobController extends Controller
{
    public function updateSurveyComment(Request $request, string $id)
    {

        $completedJob = CompletedJob::find($id);
        $job = Job::find($completedJob->job_id);

        (new UpdateSurveyService)->store(
            $job->id,
            $completedJob->id,
            "Comment changed. <br> From: {$completedJob->comments}<br> To: {$request->comments}<br>"
        );

        if (!$completedJob) {
            throw ValidationException::withMessages(['completed_job_id' => 'Completed job not found.']);
        }

        $completedJob->comments = $request->comments;

        $completedJob->save();

        return redirect()->back()->with('success', 'Survey comment updated successfully.');
    }

    public function updateSurveyPassFail(Request $request, string $id)
    {
        $completedJob = CompletedJob::find($id);
        $job = Job::find($request->job_id);
        $client = Client::find($job->client_id);

        (new UpdateSurveyService)->store(
            $job->id,
            $completedJob->id,
            "Status changed. <br> From: {$completedJob->pass_fail}<br> To: {$request->pass_fail}<br>"
        );

        if (!$completedJob) {
            throw ValidationException::withMessages(['completed_job_id' => 'Completed job not found.']);
        }

        $completedJob->pass_fail = $request->pass_fail;

        $completedJob->save();

        $completedJobs = CompletedJob::where('job_id', $request->job_id)
            ->whereIn('pass_fail', FailedQuestion::values())
            ->count();

        $cat1Duration = $client->clientSlaMetric->cat1_remediate_complete_duration_unit;
        $ncDuration = $client->clientSlaMetric->nc_remediate_complete_duration_unit;
        $cat1ReinspectRemediation = (int) $client->clientSlaMetric->cat1_remediate_complete;
        $ncReinspectRemediation = (int) $client->clientSlaMetric->nc_remediate_complete;

        if ($completedJobs === 0) {

            $job->job_status_id = 3;
            $job->last_update = now();
            $job->close_date = now();
            $job->rework_deadline = null;

            $job->save();

            $emailTemplates = MessageTemplate::where('data_id', 6)
                ->where('is_active', 1)
                ->where('type', 'email')
                ->first();

            // $email = env('EMPLOYER_EMAIL');
            $email = $job->installer->user->email;
            $subject = $emailTemplates->subject;
            $appUrl = env('APP_URL');

            $data = [
                '_INSTALLER_NAME_' => $job->installer->user->firstname . ' ' . $job->installer->user->lastname,
                '_CERT_NO_' => $job->cert_no,
                '_CLIENT_' => $job->client->user->firstname . ' ' . $job->client->user->lastname,
                '_UMR_' => $job->jobMeasure->umr,
                '_INSPECTION_DATE_' => $job->schedule_date,
                '_NC_TYPE_' => $job->job_remediation_type,
                '_REMEDIATION_DEADLINE_' => $job->rework_deadline,
                '_HOUSENAME_NUMBER_' => $job->property->house_flat_prefix,
                '_ADDRESS_LINE_1_' => $job->property->address1,
                '_POSTCODE_' => $job->property->postcode,
                '_LINK_' => $appUrl,
            ];

            $template = $emailTemplates->content;

            (new MailService)->sendEmail($subject, $template, $email, $data, true);

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
