<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [RegisteredUserController::class, 'register'])->name('auth.register.store');

    Route::get('/verify-email', [RegisteredUserController::class, 'showVerifyForm'])->name('auth.verify.form');
    Route::post('/verify-email', [RegisteredUserController::class, 'verifyEmail'])->name('auth.verify.email');
    Route::post('/resend-code', [RegisteredUserController::class, 'resendCode'])->name('auth.resend.code');

    Route::get('/login', [LoginController::class, 'create'])->name('auth.login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::post('/logout', [LoginController::class, 'destroy'])->name('auth.logout');

    Route::get('/forgot-password',[ForgotPasswordController::class , 'create'])->name('auth.password.request');
    Route::post('/forgot-password',[ForgotPasswordController::class , 'store'])->name('auth.password.email');

    Route::get('/reset-password/{token}',[ResetPasswordController::class , 'create'])->name('auth.password.reset');
    Route::post('/reset-password',[ResetPasswordController::class , 'store'])->name('auth.password.update');


});
