<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MakeBookingController;
use App\Http\Controllers\ManageBookingController;
use App\Http\Controllers\MeasureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchemeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyInspectorController;
use App\Http\Controllers\ClientConfigurationController;
use App\Http\Controllers\SurveyQuestionSetController;
use App\Http\Controllers\InstallerConfigurationController;

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


    // Make Booking
    Route::get('make-booking', [MakeBookingController::class, 'index'])
        ->name('make-booking.index');
    Route::get('make-booking/{job_group}/book', [MakeBookingController::class, 'edit'])
        ->name('make-booking.edit');
    Route::post('make-booking/{job_group}/book', [MakeBookingController::class, 'book'])
        ->name('make-booking.book');
    Route::get('make-booking/{job_group}/editPI', [MakeBookingController::class, 'editPI'])
        ->name('make-booking.editPI');
    Route::post('make-booking/{job_group}/editPI', [MakeBookingController::class, 'editPISubmit'])
        ->name('make-booking.editPISubmit');
    Route::get('make-booking/{job_group}/show', [MakeBookingController::class, 'show'])
        ->name('make-booking.show');
    Route::post('make-booking/closeJob', [MakeBookingController::class, 'closeJob'])
        ->name('make-booking.closeJob');
    Route::post('make-booking/attemptMade', [MakeBookingController::class, 'attemptMade'])
        ->name('make-booking.attemptMade');


    // Manage Booking
    Route::get('manage-booking', [ManageBookingController::class, 'index'])
        ->name('manage-booking.index');
    Route::get('manage-booking/{job_group}/rebook', [ManageBookingController::class, 'edit'])
        ->name('manage-booking.edit');
    Route::post('manage-booking/{job_group}/rebook', [ManageBookingController::class, 'rebook'])
        ->name('manage-booking.rebook');
    Route::post('manage-booking/{job_group}/unbook', [ManageBookingController::class, 'unbook'])
        ->name('manage-booking.unbook');
    Route::get('manage-booking/{job_group}/show', [ManageBookingController::class, 'show'])
        ->name('manage-booking.show');

    Route::get('client/search-job-types', [JobController::class, 'searchClient']);
    Route::get('get-property-inspector', [PropertyInspectorController::class, 'searchPropertyInspector']);
    Route::post('/job-upload', [JobController::class, 'upload'])->name('job.upload');


});

require __DIR__ . '/auth.php';
