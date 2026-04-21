<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportActionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/reports', [ReportActionController::class, 'reports'])->name('reports');
        Route::post('/reports/update-action',[ReportActionController::class, 'updateReportAction'])->name('reports.update');
    });
