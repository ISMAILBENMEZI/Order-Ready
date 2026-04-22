<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'showRegister'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'register'])->name('register.store');

    Route::get('/verify-email', [RegisteredUserController::class, 'showVerifyForm'])->name('verify.form');
    Route::post('/verify-email', [RegisteredUserController::class, 'verifyEmail'])->name('verify.email');
    Route::post('/resend-code', [RegisteredUserController::class, 'resendCode'])->name('resend.code');

    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');

    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.update');

    Route::get('/account/banned', function () { return view('auth.banned'); })->name('banned');
});


Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});
