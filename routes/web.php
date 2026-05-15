<?php

use App\Livewire\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
