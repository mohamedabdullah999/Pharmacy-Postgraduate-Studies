<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PgEnrollmentController;
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\PgExtensionController;
use App\Http\Controllers\PgSuspensionController;
use App\Http\Controllers\PgFeeController;

Route::get('/activate', [ActivationController::class, 'showForm'])->name('activate.form');
Route::post('/activate', [ActivationController::class, 'activate'])->middleware('throttle:5,1')->name('activate.perform');

Route::middleware(['auth'])->group(function () {
    
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/programs/{program_type}/create', [PgEnrollmentController::class, 'create'])->name('enrollments.create');
        Route::post('/programs/{program_type}', [PgEnrollmentController::class, 'store'])->name('enrollments.store');

        Route::post('/enrollments/{enrollment}/extensions', [PgExtensionController::class, 'store'])->name('extensions.store');
        Route::post('/enrollments/{enrollment}/suspensions', [PgSuspensionController::class, 'store'])->name('suspensions.store');
        Route::post('/enrollments/{enrollment}/fees', [PgFeeController::class, 'store'])->name('fees.store');
    });

    Route::middleware(['role:admin,supervisor'])->group(function () {
        Route::get('/programs/{program_type}', [PgEnrollmentController::class, 'index'])->name('enrollments.index');
    });

    Route::get('/enrollments/{enrollment}', [PgEnrollmentController::class, 'show'])->name('enrollments.show');

});