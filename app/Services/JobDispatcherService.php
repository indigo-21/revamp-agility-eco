<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use App\Jobs\JobAllocationProcess;

class JobDispatcherService
{
    public function dispatchJob($requestData, string $operation = 'store'): void
    {
        try {
            JobAllocationProcess::dispatch($requestData, $operation);

            Log::info("JobDispatcherService: Job dispatched successfully", [
                'operation' => $operation,
                'cert_no' => $requestData->cert_no ?? 'N/A'
            ]);
        } catch (\Exception $e) {
            Log::error("JobDispatcherService: Failed to dispatch job", [
                'operation' => $operation,
                'error' => $e->getMessage(),
                'cert_no' => $requestData->cert_no ?? 'N/A'
            ]);
            throw $e;
        }
    }
}