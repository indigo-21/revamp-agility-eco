<?php

use App\Http\Controllers\api\DataSyncController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompletedJobPhotoController;
use App\Http\Controllers\SMSSendController;
use App\Http\Controllers\TempSyncLogsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login-api', [AuthController::class, 'login']);
Route::post('/send-sms', [SMSSendController::class, 'sendSms']);
Route::post('/verify-otp', [SMSSendController::class, 'verifyOtp']);
Route::post('/logout-api', [AuthController::class, 'logout']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/fetch-data', [DataSyncController::class, 'fetchData']);
    Route::post('/store-query', [TempSyncLogsController::class, 'storeQuery']);
    Route::post('/upload-completed-job-photo', [CompletedJobPhotoController::class, 'uploadCompletedJobPhoto']);

});


Route::get('/db-check', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['status' => 'connected', 'message' => 'Database connection successful']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Database connection failed: ' . $e->getMessage()], 500);
    }
});

Route::get('/migrate', function () {
    try {
        Artisan::call('migrate');
        return response()->json(['status' => 'success', 'message' => 'Database migration completed successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Migration failed: ' . $e->getMessage()], 500);
    }
});

Route::get('/seed', function () {
    try {
        Artisan::call('db:seed');
        return response()->json(['status' => 'success', 'message' => 'Database seeding completed successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Seeding failed: ' . $e->getMessage()], 500);
    }
});


Route::get('/cache-clear', function () {
    try {
        Artisan::call('cache:clear');
        return response()->json(['status' => 'success', 'message' => 'Cache cleared successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Cache clear failed: ' . $e->getMessage()], 500);
    }
});

Route::get('/cache-table', function () {
    try {
        Artisan::call('cache:table');
        return response()->json(['status' => 'success', 'message' => 'Cache table created successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Cache table creation failed: ' . $e->getMessage()], 500);
    }
});

Route::get('/migrate-reset', function () {
    try {
        Artisan::call('migrate:reset');
        return response()->json(['status' => 'success', 'message' => 'Database migration reset completed successfully']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Migration reset failed: ' . $e->getMessage()], 500);
    }
});

Route::get('/migrate-fresh', function () {
    try {
        Artisan::call('migrate:fresh');
        return response()->json(['status' => 'success', 'message' => 'Fresh migration completed']);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Migration fresh failed: ' . $e->getMessage()], 500);
    }
});

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

