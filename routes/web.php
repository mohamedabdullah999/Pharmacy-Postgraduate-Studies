<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AcademicRecordController;
use App\Http\Controllers\Admin\SupervisorController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/activate', [ActivationController::class, 'showActivationForm'])->name('activate');
    Route::post('/activate', [ActivationController::class, 'activate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/records/create', [AcademicRecordController::class, 'create'])->name('records.create');
        Route::post('/records/store', [AcademicRecordController::class, 'store'])->name('records.store');
    
        Route::get('/supervisors', [SupervisorController::class, 'index'])->name('supervisors.index');
        Route::get('/supervisors/create', [SupervisorController::class, 'create'])->name('supervisors.create');
        Route::post('/supervisors', [SupervisorController::class, 'store'])->name('supervisors.store');
        Route::get('/supervisors/{supervisor}/assign', [SupervisorController::class, 'assignForm'])->name('supervisors.assign.form');
        Route::post('/supervisors/{supervisor}/assign', [SupervisorController::class, 'assignStudent'])->name('supervisors.assign');
    });

    Route::middleware('role:student')->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', function () { return 'Student Dashboard'; })->name('dashboard');
    });

    Route::middleware('role:supervisor')->prefix('supervisor')->name('supervisor.')->group(function () {
        Route::get('/dashboard', function () { return 'Supervisor Dashboard'; })->name('dashboard');
    });
});