<?php


use App\Livewire\Employee\Dashboard;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', Dashboard::class)->name('dashboard');

