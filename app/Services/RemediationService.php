<?php

namespace App\Services;

use App\Enums\FailedQuestion;
use App\Enums\PassedQuestion;
use App\Models\CompletedJob;
use App\Models\Job;
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
}