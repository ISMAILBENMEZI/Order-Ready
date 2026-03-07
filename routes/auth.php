<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function(){
    Route::get('/register',[RegisteredUserController::class, 'showRegister'])->name('auth.register');
    Route::post('/register',[RegisteredUserController::class , 'register'])->name('auth.register.store');

    Route::get('/verify-email' , [RegisteredUserController::class , 'showVerifyFrom'])->name('auth.verify.from');
    Route::post('/verify-email',[RegisteredUserController::class , 'verifyEmail'])->name('auth.verify.email');
});