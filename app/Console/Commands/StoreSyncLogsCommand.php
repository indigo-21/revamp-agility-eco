<?php

namespace App\Console\Commands;

use App\Models\TempSyncLogs;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
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
        $lock = null;
        try {
            $lock = Cache::lock('store-sync-logs-command', 300);
        } catch (\Throwable $e) {
            // Some cache stores do not support locks; continue without a mutex.
            $lock = null;
        }

        if ($lock && !$lock->get()) {
            $this->info('Another sync-log worker is already running.');
            return Command::SUCCESS;
        }

        try {
            $seenQueryHashes = [];
            $processed = 0;
            $deduped = 0;
            $failed = 0;

            TempSyncLogs::query()
                ->orderBy('id')
                ->chunkById(200, function ($logs) use (&$seenQueryHashes, &$processed, &$deduped, &$failed) {
                    foreach ($logs as $log) {
                        $sql = (string) $log->sql_query;
                        $hash = hash('sha256', $sql);

                        if (isset($seenQueryHashes[$hash])) {
                            TempSyncLogs::whereKey($log->id)->delete();
                            $deduped++;
                            continue;
                        }

                        $seenQueryHashes[$hash] = true;

                        try {
                            DB::statement($sql);
                            TempSyncLogs::whereKey($log->id)->delete();
                            $processed++;
                        } catch (\Throwable $e) {
                            $message = $e->getMessage();
                            $lower = strtolower($message);

                            // Treat common "already applied" errors as idempotent and remove the log
                            // so the scheduler/queue does not retry forever.
                            $isAlreadyApplied = str_contains($lower, 'duplicate entry')
                                || str_contains($lower, 'unique constraint failed')
                                || str_contains($lower, 'already exists');

                            if ($isAlreadyApplied) {
                                TempSyncLogs::whereKey($log->id)->delete();
                                $processed++;
                                continue;
                            }

                            $failed++;
                            $this->error("Failed to execute: {$sql}");
                            $this->error("Error: {$message}");
                        }
                    }
                });

            $this->info("Sync log run complete. processed={$processed} deduped={$deduped} failed={$failed}");
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('StoreSyncLogsCommand failed: ' . $e->getMessage());
            return Command::FAILURE;
        } finally {
            optional($lock)->release();
        }
    }
}
