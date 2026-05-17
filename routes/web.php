<?php

use App\Livewire\Home\HomePage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');




require __DIR__.'/admin.php';
require __DIR__.'/employee.php';
require __DIR__.'/settings.php';
