<?php

namespace App\Console\Commands;

use App\Models\TempSyncLogs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StoreSyncLogsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:store-sync-logs-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Storing temporary logs for sync process from the API app.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tempSyncLogs = TempSyncLogs::all();

        $tempSyncLogs->each(function ($log) {
            try {
                DB::statement($log->sql_query);
                $deleteLog = TempSyncLogs::find($log->id);
                $deleteLog->delete();
            } catch (\Exception $e) {
                $this->error("Failed to execute: {$log->sql_query}");
                $this->error("Error: " . $e->getMessage());
            }
        });

        $this->info('Sync Logs stored in the database successfully!');
    }
}
