<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DuplicateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\MergeLogController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Accessible by Admin, Reviewer, Viewer
    Route::middleware('role:admin,reviewer,viewer')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/price-lists', [PriceListController::class, 'index'])->name('price_lists.index');
        Route::get('/duplicates', [DuplicateController::class, 'index'])->name('duplicates.index');
        Route::get('/duplicates/{id}', [DuplicateController::class, 'show'])->name('duplicates.show');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/download/{type}', [ReportController::class, 'download'])->name('reports.download');
    });
    
    // Accessible by Admin, Reviewer
    Route::middleware('role:admin,reviewer')->group(function () {
        Route::get('/upload', [UploadController::class, 'create'])->name('upload.create');
        Route::post('/upload', [UploadController::class, 'store'])->name('upload.store');
        Route::post('/duplicates/{id}/merge', [DuplicateController::class, 'merge'])->name('duplicates.merge');
        Route::post('/duplicates/{id}/reject', [DuplicateController::class, 'reject'])->name('duplicates.reject');
    });
    
    // Accessible by Admin only
    Route::middleware('role:admin')->group(function () {
        Route::get('/merge-logs', [MergeLogController::class, 'index'])->name('merge_logs.index');
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit_logs.index');
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'store'])->name('settings.store');
    });
});
