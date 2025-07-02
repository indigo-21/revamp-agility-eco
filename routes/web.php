<?php

use App\Http\Controllers\CompletedJobController;
use App\Http\Controllers\CompletedJobPhotoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\InstallerPortalController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MakeBookingController;
use App\Http\Controllers\ManageBookingController;
use App\Http\Controllers\MeasureController;
use App\Http\Controllers\OpenNcController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RemediationController;
use App\Http\Controllers\RemediationReinstateController;
use App\Http\Controllers\RemediationReviewController;
use App\Http\Controllers\RestoreMaxAttemptController;
use App\Http\Controllers\SchemeController;
use App\Http\Controllers\SicknessHolidayController;
use App\Http\Controllers\UpdateSurveyController;
use App\Http\Controllers\UserController;
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
use App\Http\Controllers\UserProfileConfigurationController;



// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('dashboard.index');
    });
    Route::resource('dashboard', DashboardController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // JOB
    Route::middleware('navigation.access:job')->group(function () {
        Route::resource('job', JobController::class);
        Route::patch('job/{id}/closeJob', [JobController::class, 'closeJob']);
    });

    // OPEN NC
    Route::resource('open-nc', OpenNcController::class)
        ->middleware('navigation.access:open-nc');

    // CONFIGURATIONS
    Route::resource('property-inspector', PropertyInspectorController::class)
        ->middleware('navigation.access:property-inspector');
    Route::resource('client-configuration', ClientConfigurationController::class)
        ->middleware('navigation.access:client-configuration');
    Route::resource('measure', MeasureController::class)
        ->middleware('navigation.access:measure');
    Route::resource('installer-configuration', InstallerConfigurationController::class)
        ->middleware('navigation.access:installer-configuration');
    Route::resource('survey-question-set', SurveyQuestionSetController::class)
        ->middleware('navigation.access:survey-question-set');
    Route::resource('scheme', SchemeController::class)
        ->middleware('navigation.access:scheme');
    Route::resource('user-profile-configuration', UserProfileConfigurationController::class)
        ->middleware('navigation.access:user-profile-configuration');
    

    // REMEDIATION
    Route::resource('remediation-review', RemediationReviewController::class)
        ->middleware('navigation.access:remediation-review');
    Route::resource('remediation-reinstate', RemediationReinstateController::class)
        ->middleware('navigation.access:remediation-reinstate');


    // INSTALLER PORTAL
    Route::resource('installer-portal', InstallerPortalController::class)
        ->middleware('navigation.access:installer-portal');


    // UPDATE SURVEY
    Route::middleware('navigation.access:make-booking')->group(function () {
        Route::resource('update-survey', UpdateSurveyController::class);
        Route::post('upload-survey-photo', [CompletedJobPhotoController::class, 'updateSurveyPhoto'])
            ->name('upload-survey-photo');
        Route::post('delete-survey-photo', [CompletedJobPhotoController::class, 'deleteSurveyPhoto'])
            ->name('delete-survey-photo');
        Route::patch('update-survey-comment/{id}', [CompletedJobController::class, 'updateSurveyComment'])
            ->name('update-survey-comment');
        Route::patch('update-survey-pass-fail/{id}', [CompletedJobController::class, 'updateSurveyPassFail'])
            ->name('update-survey-pass-fail');
    });

    // REMEDIATION
    Route::post('/store-remediation', [RemediationController::class, 'storeRemediation']);


    // EXECEPTIONS
    Route::resource('job-entry-exception', JobEntryExceptionController::class)
        ->middleware('navigation.access:job-entry-exception');
    Route::resource('property-inspector-exception', PropertyInspectorExceptionController::class)
        ->middleware('navigation.access:property-inspector-exception');
    Route::resource('data-validation-exception', DataValidationExceptionController::class)
        ->middleware('navigation.access:data-validation-exception');
    Route::resource('document-exception', DocumentExceptionController::class)
        ->middleware('navigation.access:document-exception');
    Route::resource('booking-exception', BookingExceptionController::class)
        ->middleware('navigation.access:booking-exception');
    Route::resource('remove-job-exception', RemoveJobExceptionController::class)
        ->middleware('navigation.access:remove-job-exception');

    Route::middleware('navigation.access:make-booking')->group(function () {
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
    });

    Route::resource('restore-max-attempts', RestoreMaxAttemptController::class)
        ->middleware('navigation.access:restore-max-attempts');

    Route::middleware('navigation.access:manage-booking')->group(function () {
        // MANAGE BOOKING
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
    });

    //  USER CONFIGURATION
    Route::resource('user-configuration', UserController::class)
        ->middleware('navigation.access:user-configuration');

    // EMAIL TEMPLATES
    Route::resource('pi-email-template', EmailTemplateController::class)
        ->middleware('navigation.access:pi-email-template');
    Route::resource('uphold-email-template', EmailTemplateController::class)
        ->middleware('navigation.access:uphold-email-template');
    Route::resource('remediation-template', EmailTemplateController::class)
        ->middleware('navigation.access:remediation-template');
    Route::resource('first-template', EmailTemplateController::class)
        ->middleware('navigation.access:first-template');
    Route::resource('second-template', EmailTemplateController::class)
        ->middleware('navigation.access:second-template');
    Route::resource('automated-email-passed', EmailTemplateController::class)
        ->middleware('navigation.access:automated-email-passed');

    Route::get('client/search-job-types', [JobController::class, 'searchClient'])->middleware('navigation.access:job');
    Route::get('get-property-inspector', [PropertyInspectorController::class, 'searchPropertyInspector'])->middleware('navigation.access:job');
    Route::get('/pi/details/{id}', [PropertyInspectorController::class, 'getPiDetails'])->middleware('navigation.access:job');
    Route::post('/job-upload', [JobController::class, 'upload'])->name('job.upload');
    Route::post('/remove-duplicates', [JobController::class, 'removeDuplicates'])->middleware('navigation.access:job');
    Route::post('client-configuration/validateEmail', [ClientConfigurationController::class, 'validateEmail'])->name('validateEmail');


    // Property Inspector Portal
    Route::get('pi-dashboard', [PropertyInspectorController::class, 'piDashboard'])
        ->name('pi-dashboard.index')
        ->middleware('navigation.access:pi-dashboard');
    Route::resource('sickness-holidays', SicknessHolidayController::class)
        ->middleware('navigation.access:sickness-holidays');

});

require __DIR__ . '/auth.php';
