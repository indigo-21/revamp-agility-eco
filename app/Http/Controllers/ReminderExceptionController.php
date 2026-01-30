<?php

namespace App\Http\Controllers;

use App\DataTables\ReminderExceptionsDataTable;
use App\Enums\FailedQuestion;
use App\Models\CompletedJob;
use App\Models\Job;
use App\Models\MessageTemplate;
use App\Models\Remediation;
use App\Services\MailService;
use Illuminate\Http\Request;

class ReminderExceptionController extends Controller
{
    public function index(ReminderExceptionsDataTable $reminderExceptionsDataTable)
    {
        return $reminderExceptionsDataTable->render('pages.reminder-exception.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $job = Job::firmDataOnly()->findOrFail($request->input('job_id'));
        $job->sent_reminder = true;
        $job->save();

        $completedJobs = CompletedJob::where('job_id', $job->id)
            ->whereIn('pass_fail', FailedQuestion::values())
            ->get();

        foreach ($completedJobs as $completedJob) {
            $remediation = new Remediation;

            $remediation->job_id = $job->id;
            $remediation->completed_job_id = $completedJob->id;
            $remediation->comment = "28-Day Reminder Exception sent on " . now()->toDateString() . " by " . auth()->user()->firstname;
            $remediation->role = 'Agent';
            $remediation->user_id = auth()->user()->id;

            $remediation->save();

        }

        $appUrl = env('APP_URL');

        $firstTemplateCat1 = MessageTemplate::where('data_id', 7)
            ->where('remediation_type', 'cat1')
            ->where('is_active', 1)
            ->first();

        $firstTemplateNc = MessageTemplate::where('data_id', 7)
            ->where('remediation_type', 'nc')
            ->where('is_active', 1)
            ->first();

        $template = null;
        if ($job->job_remediation_type === 'Cat1' && $firstTemplateCat1) {
            $template = $firstTemplateCat1;
        } elseif ($job->job_remediation_type === 'NC' && $firstTemplateNc) {
            $template = $firstTemplateNc;
        }

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
            '_OUTSTANDING_SINCE_' => $request->invoices_outstanding_since,
            '_CREDIT_NOTE_CURRENCY_' => $request->currency,
            '_CREDIT_NOTE_VALUE_' => $request->credit_note_value,
        ];

        (new MailService)->sendEmail($subject, $template->content, $email, $data, true, $request->file('attachment'));

        return redirect()->route('reminder-exception.index')
            ->with('success', 'Reminder Exception sent successfully.');
    }
}
