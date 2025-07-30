<?php

/*
|--------------------------------------------------------------------------
| Additional Job Processing Routes
|--------------------------------------------------------------------------
|
| These routes provide queue-based job processing functionality.
| Add these routes to your existing web.php or api.php file.
|
*/

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// API routes for frontend integration
Route::prefix('api/jobs')->name('api.jobs.')->group(function () {
    Route::post('store', [JobController::class, 'store'])->name('store');
    Route::post('store-sync', [JobController::class, 'storeSynchronous'])->name('store.sync');
    Route::post('store-async', [JobController::class, 'storeAsynchronous'])->name('store.async');
    Route::post('estimate', [JobController::class, 'getProcessingEstimate'])->name('estimate');
    Route::post('upload', [JobController::class, 'upload'])->name('upload');
    
    // Queue status API endpoints
    Route::get('queue-status', [JobController::class, 'getQueueStatus'])->name('queue-status');
    Route::post('queue-count', [JobController::class, 'setInitialQueueCount'])->name('queue-count');
    Route::delete('queue-progress', [JobController::class, 'resetQueueProgress'])->name('queue-reset');
});