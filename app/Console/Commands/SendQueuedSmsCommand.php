<?php

namespace App\Console\Commands;

use App\Models\MessageTemplate;
use App\Models\QueuedSms;
use App\Services\MailService;
use Illuminate\Console\Command;

class SendQueuedSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-queued-sms-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email Notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $queuedSms = QueuedSms::where('is_sent', 0)
            ->get();
        $appUrl = env('APP_URL');

        $failedJobTemplate = MessageTemplate::where('data_id', 3)
            ->where('is_active', 1)
            ->where('type', 'email')
            ->first();

        $passedJobTemplate = MessageTemplate::where('data_id', 6)
            ->where('is_active', 1)
            ->where('type', 'email')
            ->first();

        if ($queuedSms->isNotEmpty()) {
            foreach ($queuedSms as $queuedSmsItem) {
                $job = $queuedSmsItem->job;
                if ($queuedSmsItem->job->job_status_id === 16) {

                    if (!$failedJobTemplate) {
                        continue; // Skip if template not found
                    }
                    $email = $job->installer->user->email;
                    $subject = $failedJobTemplate->subject;

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

                    $template = $failedJobTemplate->content;

                    (new MailService)->sendEmail($subject, $template, $email, $data, true);

                    $queuedSmsItem->is_sent = 1;
                    $queuedSmsItem->save();


                } elseif ($queuedSmsItem->job->job_status_id === 3) {

                    if (!$passedJobTemplate) {
                        continue; // Skip if template not found
                    }
                    $email = $job->installer->user->email;
                    $subject = $passedJobTemplate->subject;

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

                    $template = $passedJobTemplate->content;

                    (new MailService)->sendEmail($subject, $template, $email, $data, true);

                    $queuedSmsItem->is_sent = 1;
                    $queuedSmsItem->save();
                }
                $this->info('Email sent for job ID: ' . $job->id);
            }
        }
    }
}
