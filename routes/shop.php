<?php

use App\Http\Controllers\Shop\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
});

Route::middleware(['auth', 'role:seller,admin,customer'])->prefix('shop')->name('shop.')->group(function () {
    Route::post('/products/{product}/review', [ProductController::class, 'storeReview'])->name('products.review');
});
