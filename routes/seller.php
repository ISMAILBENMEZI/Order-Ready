<?php

use App\Http\Controllers\Seller\StoreSetupController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth','role:seller'])->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/store/setup', [StoreSetupController::class, 'create'])->name('store.setup');
        Route::post('/store/setup',[StoreSetupController::class, 'store'])->name('store.store');
});
