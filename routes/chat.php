<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Chat\ChatController;

Route::middleware(['auth'])->prefix('chat')->name('chat.')->group(function () {
    Route::get('/inbox', [ChatController::class, 'inbox'])->name('inbox');
    Route::get('/u/{user}', [ChatController::class, 'index'])->name('index');
    Route::post('/messages/{user}', [ChatController::class, 'store'])->name('store');
    Route::get('/messages/{user}', [ChatController::class, 'fetchMessages'])->name('fetch');
});
