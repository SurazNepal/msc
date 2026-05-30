<?php

use App\Livewire\Admin\AboutManager;
use App\Livewire\Admin\Clients;
use App\Livewire\Admin\ContactSettings;
use App\Livewire\Admin\CustomPages\ManageCustomPages;
use App\Livewire\Admin\CustomPages\CreateCustomPage;
use App\Livewire\Admin\CustomPages\EditCustomPage;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\FooterNavigations;
use App\Livewire\Admin\HowWeWorks;
use App\Livewire\Admin\LogoManager;
use App\Livewire\Admin\ManageReviews;
use App\Livewire\Admin\PortfolioEvents\CreateEvents;
use App\Livewire\Admin\PortfolioEvents\EditEvents;
use App\Livewire\Admin\PortfolioEvents\PortfolioEvents;
use App\Livewire\Admin\Services\CreateServices;
use App\Livewire\Admin\Services\EditServices;
use App\Livewire\Admin\Services\Services;
use App\Livewire\Admin\SocialMediaComponent;
use App\Livewire\Admin\Teams;
use Illuminate\Support\Facades\Route;


Route::get('/dashboard', Dashboard::class)->name('dashboard');
Route::get('/services', Services::class)->name('services');
Route::get('/create-service', CreateServices::class)->name('services.create');
Route::get('/{slug}/edit-service', EditServices::class)->name('services.edit');
Route::get('/portfolio-event', PortfolioEvents::class)->name('portfolio-events');
Route::get('/create-event', CreateEvents::class)->name('portfolio-events.create');
Route::get('/{slug}/edit-event', EditEvents::class)->name('portfolio-events.edit');
Route::get('/teams', Teams::class)->name('teams');
Route::get('/our-clients', Clients::class)->name('our-clients');
Route::get('/how-we-work', HowWeWorks::class)->name('work');
Route::get('/about-manager', AboutManager::class)->name('aboutManager');
Route::get('/logo-manager', LogoManager::class)->name('logoManager');
Route::get('/footer-navigation', FooterNavigations::class)->name('footer-navigation');
Route::get('/contact-setting', ContactSettings::class)->name('contact-setting');
Route::get('/social-media', SocialMediaComponent::class)->name('social-media');
Route::get('/manage-reviews', ManageReviews::class)->name('manage-reviews');
Route::Get('/manage-custom-page', ManageCustomPages::class)->name('manage-custom-pages');
Route::get('/custom-pages/create', CreateCustomPage::class)->name('custom-pages.create');
Route::get('/custom-pages/{slug}/edit', EditCustomPage::class)->name('custom-pages.edit');
