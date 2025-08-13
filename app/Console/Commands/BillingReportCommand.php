<?php

namespace App\Console\Commands;

use App\Enums\FailedQuestion;
use App\Models\CompletedJob;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class BillingReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:billing-report-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send the monthly billing report for users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereNotIn('user_type_id', [2, 3, 4])
            ->get();

        $propertyInspector = User::where('user_type_id', 4)
            ->get();

        $thirdParty = User::where('user_type_id', 2)
            ->get();

        $nonCompliance = CompletedJob::whereIn('pass_fail', FailedQuestion::values())
            ->groupBy('job_id')
            ->get();

        $totalUsers = $users->count() + $propertyInspector->count() + $thirdParty->count();

        // $email = 'sheila.fineberg@indigo21.com';
        $email = 'christine.carillo@indigo21.com';
        $subject = 'AMI Charges for ' . now()->format('F Y');
        $bcc = ['james.zarsuelo@indigo21.com'];

        $data = [
            '_MONTH_' => now()->format('F'),
            '_YEAR_' => now()->format('Y'),
            '_TOTAL_USERS_' => $totalUsers,
            '_PROPERTY_INSPECTORS_' => $propertyInspector->count(),
            '_USERS_' => $users->count(),
            '_THIRD_PARTY_' => $thirdParty->count(),
            '_NON_COMPLIANCE_' => $nonCompliance->count(),
        ];

        $template = '
            <p>Hi Sheila,</p>

            <p>Please see the AMI charges for <strong> _MONTH_ _YEAR_</strong>:</p>

            <table style="width: 100%; border-collapse: collapse; margin: 10px 0 20px 0; font-family: Arial, sans-serif; font-size: 14px;">
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 8px; font-weight: bold;">Total Users</td>
                    <td style="padding: 8px;">_TOTAL_USERS_</td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Property Inspectors</td>
                    <td style="padding: 8px;">_PROPERTY_INSPECTORS_ <br><small>(Total = _PROPERTY_INSPECTORS_ excluding Gwyn Jones)</small></td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 8px; font-weight: bold;">Users</td>
                    <td style="padding: 8px;">_USERS_ <br><small>(Total = _USERS_ excluding Andy, Greg, Amy, Agility)</small></td>
                </tr>
                <tr>
                    <td style="padding: 8px; font-weight: bold;">Third Party Users</td>
                    <td style="padding: 8px;">_THIRD_PARTY_</td>
                </tr>
                <tr style="background-color: #f9f9f9;">
                    <td style="padding: 8px; font-weight: bold;">Total</td>
                    <td style="padding: 8px;">
                        Property Inspectors (_PROPERTY_INSPECTORS_) + Users (_USERS_) + Third Party (_THIRD_PARTY_) = <strong>_TOTAL_USERS_</strong>
                    </td>
                </tr>
            </table>

            <p><strong>Non-Compliance interactions</strong> – _NON_COMPLIANCE_</p>

            <p>Any questions, please let me know.</p>
        ';

        $convertedBody = str_replace(array_keys($data), array_values($data), $template);

        Mail::send([], [], function ($message) use ($convertedBody, $email, $subject, $bcc) {
            $message->to($email)
                ->subject($subject)
                ->html($convertedBody, 'text/html');

            // Add BCC if needed
            if ($bcc) {
                $message->bcc($bcc);
            }
        });

        $this->info('Sync Logs stored in the database successfully!');

    }
}
