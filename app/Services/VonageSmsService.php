<?php

namespace App\Services;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Vonage\SMS\Message\SMS;

class VonageSmsService
{
    protected Client $vonage;

    public function __construct()
    {
        $credentials = new Basic(
            config('services.vonage.key'),
            config('services.vonage.secret')
        );

        $this->vonage = new Client($credentials);
    }

    public function sendSms(string $to, string $message): void
    {
        $sms = new SMS($to, config('services.vonage.from'), $message);
        $this->vonage->sms()->send($sms);
    }
}
