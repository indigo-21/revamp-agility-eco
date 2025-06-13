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


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

