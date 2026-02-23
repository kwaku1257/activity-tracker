<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// public routes - only accessible when not logged in
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// protected routes - require authentication
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // daily view route must come before resource to avoid conflicts
    Route::get('/activities/daily', [ActivityController::class, 'daily'])->name('activities.daily');
    Route::post('/activities/{activity}/update-status', [ActivityController::class, 'updateStatus'])->name('activities.update-status');
    Route::resource('activities', ActivityController::class)->except(['daily']);
    
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports/query', [ReportController::class, 'query'])->name('reports.query');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});
