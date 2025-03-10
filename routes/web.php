<?php

declare(strict_types=1);

use App\Livewire\RequestPage;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/request', RequestPage::class);

Route::get('/welcome/{user:ulid}', Welcome::class)->name('auth.welcome');
