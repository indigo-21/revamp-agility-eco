<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendEmail($subject, $template, $email, $data, $bcc = false)
    {
        $employerEmail = env('EMPLOYER_EMAIL');
        $convertedBody = str_replace(array_keys($data), array_values($data), $template);

        Mail::send([], [], function ($message) use ($convertedBody, $email, $subject, $employerEmail, $bcc) {
            // $message->to('james.zarsuelo@indigo21.com')
            $message->to($email)
                ->subject($subject)
                ->html($convertedBody, 'text/html');
            
            // Add BCC if needed
            if ($bcc) {
                $message->bcc($employerEmail);
                // ->bcc('james.zarsuelo@indigo21.com');
            }
        });
    }
}