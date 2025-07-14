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
        $completedJobs = Job::where('job_status_id', [16])
            ->get();
        $appUrl = env('APP_URL');

        $firstTemplateCat1 = MessageTemplate::where('data_id', 5)
            ->where('remediation_type', 'cat1')
            ->where('is_active', 1)
            ->first();

        $firstTemplateNc = MessageTemplate::where('data_id', 5)
            ->where('remediation_type', 'nc')
            ->where('is_active', 1)
            ->first();

        foreach ($completedJobs as $key => $job) {
            $jobRemediationCount = $job->remediation->count();
            $dateCreated = $job->completedJobs->first()->created_at;
            $dateCreatedPlusOneDay = $dateCreated->addDays(7);

            // Skip if job has remediations or not due today
            if ($jobRemediationCount !== 0 || !$dateCreatedPlusOneDay->isToday()) {
                continue;
            }

            // Get the appropriate template based on remediation type
            $template = null;
            if ($job->job_remediation_type === 'Cat1' && $firstTemplateCat1) {
                $template = $firstTemplateCat1;
            } elseif ($job->job_remediation_type === 'NC' && $firstTemplateNc) {
                $template = $firstTemplateNc;
            }

            // Send email if template exists
            if ($template) {
                $this->sendRemediationEmail($job, $template, $appUrl);
            }
        }

        $this->info('First notification emails sent successfully.');
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
