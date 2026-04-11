<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Pages\PageController;
use Illuminate\Support\Facades\Route;

Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'sendContact')->name('contact.send');
});
