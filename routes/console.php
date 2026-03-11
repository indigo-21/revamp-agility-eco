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
Schedule::command('app:billing-report-command')->monthlyOn('1', '08:00');

// Optional: Monitor queue health every 5 minutes
// Schedule::command('queue:monitor job-allocation,job-allocation-batch,default --max=100')->everyFiveMinutes();

// Optional: Restart queue workers daily to prevent memory leaks
// Schedule::command('queue:restart')->daily();