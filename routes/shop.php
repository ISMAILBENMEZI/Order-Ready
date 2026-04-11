<?php

use App\Http\Controllers\Shop\ProductController;
use Illuminate\Support\Facades\Route;


Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
});
