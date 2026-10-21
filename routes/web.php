<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PgEnrollmentController;

Route::middleware(['auth'])->group(function () {
    
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        Route::get('/programs/{program_type}/create', [PgEnrollmentController::class, 'create'])->name('enrollments.create');
        // Route::post('/programs/{program_type}', [PgEnrollmentController::class, 'store'])->name('enrollments.store');
    });

    Route::middleware(['role:admin,supervisor'])->group(function () {
        Route::get('/programs/{program_type}', [PgEnrollmentController::class, 'index'])->name('enrollments.index');
    });

    Route::get('/enrollments/{enrollment}', [PgEnrollmentController::class, 'show'])->name('enrollments.show');

});