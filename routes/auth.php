<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function(){
    Route::get('/register',[RegisteredUserController::class, 'showRegister'])->name('auth.register');
    Route::post('/register',[RegisteredUserController::class , 'register'])->name('auth.register.store');

    Route::get('/verify-email' , [RegisteredUserController::class , 'showVerifyForm'])->name('auth.verify.form');
    Route::post('/verify-email',[RegisteredUserController::class , 'verifyEmail'])->name('auth.verify.email');

    Route::post('/resend-code' , [RegisteredUserController::class , 'resendCode'])->name('auth.resend.code');
});