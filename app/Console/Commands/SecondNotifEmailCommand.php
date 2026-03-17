<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Job;
use App\Models\MessageTemplate;
use App\Services\MailService;

class SecondNotifEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:second-notif-email-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send second notification email for jobs that are due today and have no remediations';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Only consider jobs that are in the "completed" status (id 16)
        $completedJobs = Job::where('job_status_id', 16)->get();
        $appUrl = env('APP_URL');

        $firstTemplateCat1 = MessageTemplate::where('data_id', 5)
            ->where('remediation_type', 'cat1')
            ->where('is_active', 1)
            ->first();

        $firstTemplateNc = MessageTemplate::where('data_id', 5)
            ->where('remediation_type', 'nc')
            ->where('is_active', 1)
            ->first();

        foreach ($completedJobs as $job) {
            // If any remedial work has been logged, skip this job
            $jobRemediationCount = $job->remediation->count();
            if ($jobRemediationCount !== 0) {
                continue;
            }

            // Use the earliest completion record for the job
            $completionRecord = $job->completedJobs()->orderBy('created_at', 'asc')->first();
            if (!$completionRecord) {
                continue;
            }

            $completedAt = $completionRecord->created_at->copy();

            // Determine when the second notification should be sent
            // Cat1: 7 days after completion
            // NC:   30 days after completion
            $template = null;
            $dueDate = null;

            if ($job->job_remediation_type === 'Cat1' && $firstTemplateCat1) {
                $template = $firstTemplateCat1;
                $dueDate = $completedAt->copy()->addDays(7);
            } elseif ($job->job_remediation_type === 'NC' && $firstTemplateNc) {
                $template = $firstTemplateNc;
                $dueDate = $completedAt->copy()->addDays(30);
            }

            // If we don't have a matching template or due date, skip
            if (!$template || !$dueDate) {
                continue;
            }

            // Only send on the exact due date (command is expected to run daily)
            if (!$dueDate->isToday()) {
                continue;
            }

            $this->sendRemediationEmail($job, $template, $appUrl);
        }

        $this->info('Second notification emails sent successfully.');
    }

    private function sendRemediationEmail($job, $template, $appUrl)
    {
        $email = $job->installer->user->email;
        $subject = $template->subject;

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

        (new MailService)->sendEmail($subject, $template->content, $email, $data, true);
    }
}
