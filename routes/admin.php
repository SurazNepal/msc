<?php


use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\PortfolioEvents;
use App\Livewire\Admin\Services;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/services', Services::class)->name('services');
Route::get('/portfolio-event', PortfolioEvents::class)->name('portfolio-event');

