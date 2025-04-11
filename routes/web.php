<?php

use App\Http\Controllers\ProfileController;
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

    Route::resource('property-inspector', PropertyInspectorController::class);
    Route::resource('client-configuration', ClientConfigurationController::class);
    Route::resource('measure-configuration', MeasureController::class);
	Route::resource('installer-configuration', InstallerConfigurationController::class);
    Route::resource('survey-question-set', SurveyQuestionSetController::class);

    

});

require __DIR__.'/auth.php';
