<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleRedirectController;
use App\Http\Controllers\PrivacyController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::get('/', LocaleRedirectController::class)->name('locale.redirect');

Route::prefix('{locale}')->middleware(SetLocale::class)->group(function (): void {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/privacy', PrivacyController::class)->name('privacy');

    Route::view('/preview/city', 'preview.city')->name('preview.city');
    Route::view('/preview/article', 'preview.article')->name('preview.article');
    Route::view('/preview/arrival', 'preview.arrival')->name('preview.arrival');
    Route::view('/preview/my', 'preview.my')->name('preview.my');
});
