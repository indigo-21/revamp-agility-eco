<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:store-sync-logs-command')->everyThirtySeconds();
Schedule::command('app:send-queued-sms-command')->everyThirtySeconds();
Schedule::command('app:first-notif-email-command')->dailyAt('00:00');
Schedule::command('app:second-notif-email-command')->dailyAt('00:00');
// Schedule::command('app:first-notif-email-command')->everyTenSeconds();