<?php

use App\Http\Controllers\Shop\Action\ReviewController;
use App\Http\Controllers\Shop\Action\FavoriteController;
use App\Http\Controllers\Shop\Action\InterestController;
use App\Http\Controllers\Shop\ProductController;
use App\Http\Controllers\Shop\StoreController;
use App\Http\Controllers\Shop\Action\ReportController;
use Illuminate\Support\Facades\Route;


Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/stores/{store:slug}', [StoreController::class, 'show'])->name('stores.show');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/review', [ReviewController::class, 'storeReview'])->name('products.review');
    Route::post('/store/{store:slug}/follow', [StoreController::class, 'toggleFollow'])->name('stores.follow');
    Route::post('/products/{product}/report', [ReportController::class, 'report'])->name('product.reports');
    Route::post('/products/{product}/favorite', [FavoriteController::class, 'toggleFavorite'])->name('products.favorite');
    Route::get('/favorite',[FavoriteController::class , 'index'])->name('products.favorites.index');
    Route::post('/interest/{product}',[InterestController::class, 'interest'])->name('product.interest');
});
