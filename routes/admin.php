<?php

use App\Livewire\Admin\AboutManager;
use App\Livewire\Admin\Clients;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\HowWeWorks;
use App\Livewire\Admin\LogoManager;
use App\Livewire\Admin\PortfolioEvents;
use App\Livewire\Admin\Services;
use App\Livewire\Admin\Teams;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/services', Services::class)->name('services');
Route::get('/portfolio-event', PortfolioEvents::class)->name('portfolio-event');
Route::get('/teams', Teams::class)->name('teams');
Route::get('/our-clients', Clients::class)->name('our-clients');
Route::get('/how-we-work', HowWeWorks::class)->name('work');
Route::get('/about-manager', AboutManager::class)->name('aboutManager');
Route::get('/logo-manager', LogoManager::class)->name('logoManager');
