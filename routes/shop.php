<?php

use App\Http\Controllers\Shop\FavoriteController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\StoreController;
use App\Http\Controllers\Shop\ProductActionController;
use Illuminate\Support\Facades\Route;


Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/stores/{store:slug}', [StoreController::class, 'show'])->name('stores.show');
});

Route::middleware(['auth', 'role:seller,admin,customer'])->group(function () {
    Route::post('/products/{product}/review', [ProductActionController::class, 'storeReview'])->name('products.review');
    Route::post('/store/{store:slug}/follow', [StoreController::class, 'toggleFollow'])->name('stores.follow');
    Route::post('/products/{product}/report', [ProductActionController::class, 'report'])->name('product.reports');
    Route::post('/products/{product}/favorite', [ProductActionController::class, 'toggleFavorite'])->name('products.favorite');
    Route::get('/favorite',[FavoriteController::class , 'index'])->name('products.favorites.index');
});
