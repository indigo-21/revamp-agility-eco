<?php

namespace App\Console\Commands;

use App\Services\JobDispatcherService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestJobQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:test-queue 
                            {--measures=5 : Number of test measures to create}
                            {--cert=TEST : Certificate number prefix}
                            {--sync : Force synchronous processing}
                            {--async : Force asynchronous processing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the job queue processing system with sample data';

    /**
     * Execute the console command.
     */
    public function handle(JobDispatcherService $jobDispatcherService)
    {
        $measureCount = (int) $this->option('measures');
        $certPrefix = $this->option('cert');
        $forceSync = $this->option('sync');
        $forceAsync = $this->option('async');

        $this->info("Testing job queue with {$measureCount} measures...");

        // Create sample request data
        $requestData = $this->createSampleRequest($measureCount, $certPrefix);

        try {
            if ($forceSync) {
                $this->info('Forcing synchronous processing...');
                $jobService = new \App\Services\JobService();
                $result = $jobService->store($requestData);
                $this->info('✅ Synchronous processing completed successfully');
                
            } elseif ($forceAsync) {
                $this->info('Forcing asynchronous processing...');
                $batchIds = $jobDispatcherService->dispatchJobSmart($requestData, 1); // Force batching
                
                if ($batchIds) {
                    $this->info("✅ Batch processing dispatched with " . count($batchIds) . " batches");
                    $this->table(['Batch ID'], array_map(fn($id) => [$id], $batchIds));
                } else {
                    $this->info('✅ Single job dispatched for asynchronous processing');
                }
                
            } else {
                $this->info('Using smart dispatch (automatic strategy selection)...');
                $estimate = $jobDispatcherService->getProcessingEstimate($requestData);
                
                $this->table(
                    ['Metric', 'Value'],
                    [
                        ['Measure Count', $estimate['measure_count']],
                        ['Estimated Time (seconds)', $estimate['estimated_time_seconds']],
                        ['Estimated Time (minutes)', $estimate['estimated_time_minutes']],
                        ['Recommended Batching', $estimate['recommended_batching'] ? 'Yes' : 'No'],
                        ['Recommended Batch Size', $estimate['recommended_batch_size']]
                    ]
                );

                $batchIds = $jobDispatcherService->dispatchJobSmart($requestData);
                
                if ($batchIds) {
                    $this->info("✅ Smart dispatch used batch processing with " . count($batchIds) . " batches");
                } else {
                    $this->info('✅ Smart dispatch used single job processing');
                }
            }

            $this->info('🎉 Test completed successfully!');
            
            if (!$forceSync) {
                $this->warn('💡 Remember to run "php artisan queue:work" to process queued jobs');
            }

        } catch (\Exception $e) {
            $this->error('❌ Test failed: ' . $e->getMessage());
            Log::error('TestJobQueue command failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 1;
        }

        return 0;
    }

    /**
     * Create sample request data for testing
     */
    private function createSampleRequest(int $measureCount, string $certPrefix): object
    {
        $measures = [];
        
        for ($i = 1; $i <= $measureCount; $i++) {
            $measures[] = [
                'job_suffix' => str_pad($i, 2, '0', STR_PAD_LEFT),
                'umr' => "UMR{$certPrefix}{$i}",
                'measure_cat' => 'TEST_MEASURE',
                'info' => "Test measure {$i} info"
            ];
        }

        return (object) [
            'cert_no' => "{$certPrefix}_" . now()->format('YmdHis'),
            'client_id' => 1,
            'job_type_id' => 1,
            'installer_id' => 1,
            'scheme_id' => 1,
            'customer_name' => 'Test Customer',
            'customer_primary_tel' => '01234567890',
            'customer_secondary_tel' => '',
            'customer_email' => 'test@example.com',
            'house_flat_prefix' => '123',
            'address1' => 'Test Street',
            'address2' => '',
            'address3' => '',
            'city' => 'Test City',
            'county' => 'Test County',
            'postcode' => 'TE5T 1NG',
            'notes' => 'Test job created by queue test command',
            'lodged_by_tmln' => 'TEST001',
            'lodged_by_name' => 'Test User',
            'sub_installer_tmln' => '',
            'csv_filename' => 'test_queue_command.csv',
            'measures' => $measures
        ];
    }
}
