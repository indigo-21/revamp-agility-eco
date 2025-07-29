<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Job Processing Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for the job allocation
    | processing system.
    |
    */

    // Queue names for different types of job processing
    'queues' => [
        'job_allocation' => env('QUEUE_JOB_ALLOCATION', 'job-allocation'),
        'job_batch_allocation' => env('QUEUE_JOB_BATCH_ALLOCATION', 'job-allocation-batch'),
    ],

    // Thresholds for determining processing strategy
    'thresholds' => [
        'synchronous_limit' => env('JOB_SYNC_LIMIT', 10),
        'single_queue_limit' => env('JOB_SINGLE_QUEUE_LIMIT', 100),
        'batch_size' => env('JOB_BATCH_SIZE', 50),
        'large_file_batch_size' => env('JOB_LARGE_FILE_BATCH_SIZE', 25),
    ],

    // Upload processing configuration
    'upload' => [
        'synchronous_limit' => env('UPLOAD_SYNC_LIMIT', 20),
        'batch_size' => env('UPLOAD_BATCH_SIZE', 25),
        'large_batch_size' => env('UPLOAD_LARGE_BATCH_SIZE', 10),
        'large_file_threshold' => env('UPLOAD_LARGE_FILE_THRESHOLD', 100),
    ],

    // Processing time estimates (in seconds per measure)
    'estimates' => [
        'time_per_measure' => env('JOB_TIME_PER_MEASURE', 0.5),
        'overhead_per_batch' => env('JOB_BATCH_OVERHEAD', 2.0),
    ],

    // Job timeout and retry configuration
    'timeouts' => [
        'single_job' => env('JOB_SINGLE_TIMEOUT', 300), // 5 minutes
        'batch_job' => env('JOB_BATCH_TIMEOUT', 600),   // 10 minutes
        'max_retries' => env('JOB_MAX_RETRIES', 3),
    ],

    // Enable/disable features
    'features' => [
        'queue_job_updates' => env('QUEUE_JOB_UPDATES', false),
        'auto_batching' => env('JOB_AUTO_BATCHING', true),
        'smart_dispatch' => env('JOB_SMART_DISPATCH', true),
        'detailed_logging' => env('JOB_DETAILED_LOGGING', true),
    ],
];
