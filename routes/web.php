<?php

declare(strict_types=1);

use App\Http\Controllers\PreferredLocaleController;
use App\Http\Middleware\SetLocale;
use App\Livewire\RequestPage;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::middleware(SetLocale::class)->group(function () {
    Route::get('/request', RequestPage::class);

    Route::get('/welcome/{user:ulid}', Welcome::class)->name('auth.welcome');

    Route::post('/preferred-locale/{locale?}', PreferredLocaleController::class)->name('preferred-locale');
});
