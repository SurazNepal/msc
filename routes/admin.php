<?php

use App\Livewire\Admin\AboutManager;
use App\Livewire\Admin\Clients;
use App\Livewire\Admin\ContactSettings;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\FooterNavigations;
use App\Livewire\Admin\HowWeWorks;
use App\Livewire\Admin\LogoManager;
use App\Livewire\Admin\ManageReviews;
use App\Livewire\Admin\PortfolioEvents;
use App\Livewire\Admin\Services;
use App\Livewire\Admin\SocialMediaComponent;
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
Route::get('/footer-navigation', FooterNavigations::class)->name('footer-navigation');
Route::get('/contact-setting', ContactSettings::class)->name('contact-setting');
Route::get('/social-media', SocialMediaComponent::class)->name('social-media');
Route::get('/manage-reviews', ManageReviews::class)->name('manage-reviews');
