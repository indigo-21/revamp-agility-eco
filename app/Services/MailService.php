<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendEmail($subject, $template, $email, $data, $bcc = false, $file = null)
    {
        $employerEmail = env('EMPLOYER_EMAIL');
        $convertedBody = str_replace(array_keys($data), array_values($data), $template);

        Mail::send([], [], function ($message) use ($convertedBody, $email, $subject, $employerEmail, $bcc, $file) {
            // $message->to('james.zarsuelo@indigo21.com')
            $message->to($email)
                ->subject($subject)
                ->html($convertedBody, 'text/html');

            // Add BCC if needed
            if ($bcc) {
                $message->bcc($employerEmail);
                // ->bcc('james.zarsuelo@indigo21.com');
            }

            if ($file !== null) {
                // If it's an UploadedFile object, preserve the original filename
                if (method_exists($file, 'getClientOriginalName')) {
                    $message->attach($file->getRealPath(), [
                        'as' => $file->getClientOriginalName(),
                        'mime' => $file->getClientMimeType(),
                    ]);
                } else {
                    // Fallback for file paths
                    $message->attach($file);
                }
            }
        });
    }
}