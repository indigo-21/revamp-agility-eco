<?php

use App\Http\Controllers\JobController;
use App\Http\Controllers\MeasureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchemeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyInspectorController;
use App\Http\Controllers\ClientConfigurationController;
use App\Http\Controllers\SurveyQuestionSetController;
use App\Http\Controllers\InstallerConfigurationController;

// EXECEPTION CONTROLLER
use App\Http\Controllers\JobEntryExceptionController;
use App\Http\Controllers\PropertyInspectorExceptionController;
use App\Http\Controllers\DataValidationExceptionController;
use App\Http\Controllers\DocumentExceptionController;
use App\Http\Controllers\BookingExceptionController;
use App\Http\Controllers\RemoveJobExceptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('job', JobController::class);
    Route::resource('property-inspector', PropertyInspectorController::class);
    Route::resource('client-configuration', ClientConfigurationController::class);
    Route::post('client-configuration/validateEmail', [ClientConfigurationController::class, 'validateEmail'])->name('validateEmail');
    Route::resource('measure', MeasureController::class);
    Route::resource('installer-configuration', InstallerConfigurationController::class);
    Route::resource('survey-question-set', SurveyQuestionSetController::class);
    Route::resource('scheme', SchemeController::class);

    Route::get('client/search-job-types', [JobController::class, 'searchClient']);

    // EXECEPTIONS
    Route::resource('job-entry-exception', JobEntryExceptionController::class);
    Route::resource('property-inspector-exception', PropertyInspectorExceptionController::class);
    Route::resource('data-validation-exception', DataValidationExceptionController::class);
    Route::resource('document-exception', DocumentExceptionController::class);
    Route::resource('booking-exception', BookingExceptionController::class);
    Route::resource('remove-job-exception', RemoveJobExceptionController::class);


});

require __DIR__ . '/auth.php';
