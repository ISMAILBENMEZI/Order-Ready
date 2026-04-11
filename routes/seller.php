<?php

use App\Http\Controllers\Seller\Store\StoreController;
use App\Http\Controllers\Seller\Store\StoreSetupController;
use App\Http\Controllers\Seller\store\StoreUpdateController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'role:seller'])->prefix('seller')
    ->name('seller.')
    ->group(function () {
        Route::get('/store/setup', [StoreSetupController::class, 'create'])->name('store.setup');
        Route::post('/store/setup', [StoreSetupController::class, 'store'])->name('store.store');

        Route::get('/my-store', [StoreController::class, 'myStore'])->name('store.index');

        Route::get('/my-store/create-product', [StoreController::class, 'createProduct'])->name('store.create-product');
        Route::post('/my-store/store-product', [StoreController::class, 'storeProduct'])->name('store.store-product');

        Route::get('/my-store/{product}/edit', [StoreController::class, 'editProduct'])->name('store.edit-product');
        Route::put('/my-store/{product}/update', [StoreController::class, 'updateProduct'])->name('store.update-product');
        Route::Patch('/my-store/{product}/update-status',[StoreController::class, 'updateProductSatatus'])->name('store.product.update-status');

        Route::delete('/my-store/product/{product}', [StoreController::class, 'deleteProduct'])->name('store.delete-product');

        // Route::get('/my-store/product/{product}/edit', [StoreController::class, 'editProduct'])->name('store.edit-product');
        // Route::post('/seller/product/{id}/update', [StoreController::class, 'updateProduct'])->name('product.update');

        Route::get('/my-store/edit', [StoreUpdateController::class, 'edit'])->name('store.edit');
        Route::put('/my-store/update', [StoreUpdateController::class, 'update'])->name('store.update');

        Route::get('/my-store/{product}/show', [StoreController::class, 'showProduct'])->name('store.show-product');
    });
