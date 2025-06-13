<?php

namespace App\Services;

use App\Models\CompletedJob;
use App\Models\Job;
use App\Models\Remediation;
use App\Models\RemediationFile;
use Illuminate\Support\Str;

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
                            'Cat1 Resubmit Remediation' :
                            'NC Resubmit Remediation';
                        $message = "Agent updated the survey question as Reject Remediation. Please resubmit the remediation for review.";
                    }

                    $completedJob->remediation += 1;

                    $completedJob->save();
                    // update job status

                    // send email
                    break;
                // case 'rejectAppeal':
                //     # code...
                //     break;

                // default:
                //     # code...
                //     break;
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