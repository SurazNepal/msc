<?php

use App\Livewire\Pages\AboutUsPage;
use App\Livewire\Pages\ClientelePage;
use App\Livewire\Pages\CustomPages\CustomPageView;
use App\Livewire\Pages\Events\EventsPage;
use App\Livewire\Pages\Events\SinglePage;
use App\Livewire\Pages\Services\ServiceSinglePage;
use App\Livewire\Pages\Services\ServicesPage;
use App\Livewire\Pages\TeamsPage;
use Illuminate\Support\Facades\Route;

Route::get('/about-us', AboutUsPage::class)->name('about-us');
Route::get('/our-teams', TeamsPage::class)->name('our-teams');
Route::get('/clientele', ClientelePage::class)->name('clientele');
Route::get('/our-services', ServicesPage::class)->name('our-services');
Route::get('/our-services/{service:slug}', ServiceSinglePage::class)->name('services.single');
Route::get('/events', EventsPage::class)->name('events');
Route::get('/events/{event:slug}', SinglePage::class)->name('events.single');
Route::get('/contact')->name('contact');
Route::get('/page/{slug}', CustomPageView::class)->name('pages.show');

// Route::get('/fix-service-slugs', function () {
//     \App\Models\Admin\Service::whereNull('slug')
//         ->orWhere('slug', '')
//         ->get()
//         ->each(function ($service) {
//             $slugBase = \Illuminate\Support\Str::slug($service->title);
//
//             // Check for uniqueness across existing service records
//             $count = \App\Models\Admin\Service::where('slug', 'LIKE', "{$slugBase}%")
//                 ->where('id', '!=', $service->id)
//                 ->count();
//
//             $service->slug = $count > 0 ? "{$slugBase}-{$count}" : $slugBase;
//             $service->saveQuietly();
//         });
//
//     return "Service slugs fixed successfully!";
// });
