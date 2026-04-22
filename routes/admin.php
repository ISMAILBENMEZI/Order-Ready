<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReportActionController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/reports', [ReportActionController::class, 'reports'])->name('reports');
        Route::post('/reports/update-action', [ReportActionController::class, 'updateReportAction'])->name('reports.update');
        Route::get('/reports/choose', [ReportActionController::class, 'index'])->name('reports.index');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::post('/users/{user}/toggle-status',[UserController::class, 'toggleStatus'])->name('users.toggleStatus');

        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/categories/{category}/status', [CategoryController::class, 'toggleStatus'])->name('categories.toggle');
    });
