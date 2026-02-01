<?php

namespace App\Services;

use App\Enums\FailedQuestion;
use App\Enums\PassedQuestion;
use App\Models\CompletedJob;
use App\Models\Job;
use App\Models\MessageTemplate;
use App\Models\Remediation;
use App\Models\RemediationFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RemediationService
{
    public function store($request)
    {
        $remediation = $this->create($request);

        return $remediation;

    }

    public function create($request)
    {
        $remediation = new Remediation;
        $completedJob = CompletedJob::find($request->input('completedJobId'));
        $job = Job::find($request->input('jobId'));
        $maximumRemediation = $job->client->clientSlaMetric->maximum_remediation_attempts;
        $maximumAppeals = $job->client->clientSlaMetric->maximum_number_appeals;
        $message = '';

        // return response()->json([
        //     'maximumRemediation' => (int) $maximumRemediation,
        //     'completedJob' => $completedJob->remediation,
        // ]);

        if ($request->remediationType) {
            switch ($request->remediationType) {
                case 'rejectRemediation':

                    if ((int) $maximumRemediation <= (int) $completedJob->remediation + 1) {
                        $completedJob->pass_fail = "Fail NC Remediation";
                        $message = "Agent updated the survey question as Reject Remediation. This Question will be marked as Fail NC Remediation. Maximum remediation attempts reached.";
                    } else {
                        $completedJob->pass_fail = Str::lower($completedJob->surveyQuestion->nc_severity) === "cat1" ?
                            FailedQuestion::Cat1ResubmitRemediation->value :
                            FailedQuestion::NCResubmitRemediation->value;
                        $message = "Agent updated the survey question as Reject Remediation. Please resubmit the remediation for review.";
                    }

                    $completedJob->remediation += 1;

                    $completedJob->save();

                    // send email

                    $emailTemplates = MessageTemplate::where('data_id', 2)
                        // ->where('is_active', 1)
                        ->where('type', 'email')
                        ->where('uphold_type', 'remediation')
                        ->where('is_active', 1)
                        ->first();

                    break;
                case 'rejectAppeal':

                    if ((int) $maximumAppeals <= (int) $completedJob->appeal + 1) {
                        $completedJob->pass_fail = "Fail NC Appeal";
                        $message = "Agent updated the survey question as Reject Appeal. This Question will be marked as Fail NC Appeal. Maximum appeal attempts reached.";
                    } else {
                        $completedJob->pass_fail = Str::lower($completedJob->surveyQuestion->nc_severity) === "cat1" ?
                            FailedQuestion::Cat1ResubmitAppeal->value :
                            FailedQuestion::NCResubmitAppeal->value;
                        $message = "Agent updated the survey question as Reject Appeal. Please resubmit the appeal for review.";
                    }

                    $completedJob->appeal += 1;

                    $completedJob->save();

                    // send email

                    $emailTemplates = MessageTemplate::where('data_id', 2)
                        // ->where('is_active', 1)
                        ->where('type', 'email')
                        ->where('uphold_type', 'appeal')
                        ->where('is_active', 1)
                        ->first();

                    break;
                case 'passRemediation':

                    $completedJob->pass_fail = PassedQuestion::PassRemediation->value;
                    $message = "Agent updated the survey question as Pass Remediation. This Question will be marked as Pass Remediation Overturned.";
                    $completedJob->remediation += 1;
                    $completedJob->save();

                    $this->checkFailedJobs($job, 30);

                    break;
                case 'passAppeal':

                    $completedJob->pass_fail = PassedQuestion::PassAppeal->value;
                    $message = "Agent updated the survey question as Pass Appeal. This Question will be marked as Pass Appeal Overturned.";
                    $completedJob->appeal += 1;
                    $completedJob->save();

                    $this->checkFailedJobs($job, 31);

                    break;
                case 'revisitRemediation':

                    if ((int) $maximumRemediation <= (int) $completedJob->remediation + 1) {
                        $completedJob->pass_fail = "Fail NC Remediation";
                        $message = "Agent updated the survey question as Revisit Remediation. This Question will be marked as Fail NC Appeal. Maximum appeal attempts reached.";
                    } else {
                        $completedJob->pass_fail = Str::lower($completedJob->surveyQuestion->nc_severity) === "cat1" ?
                            PassedQuestion::Cat1ReinspectRemediation->value :
                            PassedQuestion::NCReinspectRemediation->value;
                        $message = "Agent updated the survey question as Revisit Remediation. Please resubmit the remediation for review.";
                    }

                    $completedJob->remediation += 1;
                    $completedJob->save();

                    $job->job_status_id = 26; // Job Revisit Remediation
                    $job->last_update = now();
                    $job->save();

                    break;
                case 'revisitAppeal':

                    if ((int) $maximumAppeals <= (int) $completedJob->appeal + 1) {
                        $completedJob->pass_fail = "Fail NC Appeal";
                        $message = "Agent updated the survey question as Revisit Appeal. This Question will be marked as Fail NC Appeal. Maximum appeal attempts reached.";
                    } else {
                        $completedJob->pass_fail = Str::lower($completedJob->surveyQuestion->nc_severity) === "cat1" ?
                            PassedQuestion::Cat1ReinspectAppeal->value :
                            PassedQuestion::NCReinspectAppeal;
                        $message = "Agent updated the survey question as Revisit Appeal. Please resubmit the appeal for review.";
                    }

                    $completedJob->appeal += 1;
                    $completedJob->save();

                    $job->job_status_id = 26; // Job Revisit Remediation
                    $job->last_update = now();
                    $job->save();

                    break;
            }
        }

        $remediation->job_id = $job->id;
        $remediation->completed_job_id = $completedJob->id;
        $remediation->comment = $message ?: $request->input('comment');
        $remediation->role = $request->input('user');
        $remediation->user_id = auth()->user()->id;

        $remediation->save();

        $this->upload($request, $remediation);

        if ($request->remediationType === 'rejectRemediation' || $request->remediationType === 'rejectAppeal') {
            $this->sendEmailRemediation($job, $emailTemplates);
        }

        return $remediation;
    }

    public function checkFailedJobs($job, $status)
    {
        $failedValues = array_merge(
            FailedQuestion::values(),
            ['Cat1 Reinspect Remediation', 'NC Reinspect Remediation']
        );

        $countFailedJobs = CompletedJob::where('job_id', $job->id)
            ->whereIn(
                'pass_fail',
                $failedValues
            )
            ->count();

        if ($countFailedJobs === 0) {
            $job->job_status_id = $status;
            $job->close_date = now();
            $job->last_update = now();
            $job->invoice_status_id = 2;
            $job->save();

            // Send email to installer
        }

    }

    public function upload($request, $remediation)
    {
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {

                $filename = $file->getClientOriginalName();
                $file->storeAs('remediation_files', $filename, 'public');

                $remediationFile = new RemediationFile();

                $remediationFile->remediation_id = $remediation->id;
                $remediationFile->filename = $filename;

                $remediationFile->save();

            }
        }
    }

    public function sendEmailRemediation($job, $emailTemplates)
    {
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
    }
}