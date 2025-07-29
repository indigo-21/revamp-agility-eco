<?php

namespace App\Jobs;

use App\Services\JobService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Exception;

class JobAllocationProcess implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The maximum number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

    /**
     * The request data containing job information
     *
     * @var object
     */
    protected $requestData;

    /**
     * The operation type (store or update)
     *
     * @var string
     */
    protected $operation;

    /**
     * Optional measure data for update operations
     *
     * @var array|null
     */
    protected $measureData;

    /**
     * Create a new job instance.
     *
     * @param object $requestData The request data
     * @param string $operation The operation type (store or update)
     * @param array|null $measureData Optional measure data for update operations
     */

    /**
     * Create a new job instance.
     */
    public function __construct($requestData, string $operation = 'store', $measureData = null)
    {
        $this->requestData = $requestData;
        $this->operation = $operation;
        $this->measureData = $measureData;

        // Set queue and connection if needed
        $this->onQueue('job-allocation');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $jobService = new JobService();

            Log::info("JobAllocationProcess: Starting {$this->operation} operation", [
                'operation' => $this->operation,
                'cert_no' => $this->requestData->cert_no ?? 'N/A',
                'measures_count' => count($this->requestData->measures ?? [])
            ]);

            $result = $jobService->store($this->requestData);
            Log::info("JobAllocationProcess: Store operation completed successfully", [
                'cert_no' => $result->cert_no ?? 'N/A'
            ]);

        } catch (Exception $e) {
            Log::error("JobAllocationProcess: Operation failed", [
                'operation' => $this->operation,
                'error' => $e->getMessage(),
                'cert_no' => $this->requestData->cert_no ?? 'N/A',
                'trace' => $e->getTraceAsString()
            ]);

            // Re-throw the exception to trigger job failure and potential retry
            throw $e;
        }
    }
}
