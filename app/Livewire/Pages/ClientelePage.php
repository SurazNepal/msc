<?php

namespace App\Livewire\Pages;

use App\Models\Admin\Client;
use App\Models\Review;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest.main', ['title' => 'Clientele Page', 'withFilters' => false, 'breadcrumbs' => ''])]
class ClientelePage extends Component
{
    public function render()
    {
        // 1. Fetch published clients with their logos eager loaded
        $clients = Client::published()
            ->with('media')
            ->orderBy('full_name', 'asc')
            ->get();

        // 2. Fetch approved 5-star testimonials
        $testimonials = Review::where('is_approved', true)
            ->where('rating', 5)
            ->latest()
            ->take(4) // Safeguard grid layout
            ->get();

        // 3. Centralized layout data configs to clear up the markup
        $stats = [
            ['count' => ($clients->count() > 0 ? $clients->count() : 19), 'label' => 'Partner Organisations'],
            ['count' => (date('Y') - 2011),  'label' => 'Years of Service'], // Dynamic years since 2011
            ['count' => '100', 'label' => 'Events Delivered'],
            ['count' => '5', 'label' => 'Sectors Served'],
        ];

        $sectors = [
            [
                'title' => 'Medical & Healthcare',
                'description' => 'Conferences for surgical societies, cardiology associations, and hospitals across Nepal.',
                'meta' => '8+ clients',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>',
                'highlighted' => true
            ],
            [
                'title' => 'NGO & INGO',
                'description' => 'Advocacy events, community outreach programmes, and national seminars for social sector organisations.',
                'meta' => '5+ clients',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253"/>',
                'highlighted' => false
            ],
            [
                'title' => 'Academic & Professional',
                'description' => 'National and international conferences for medical colleges, student associations, and professional bodies.',
                'meta' => '4+ clients',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342"/>',
                'highlighted' => false
            ],
            [
                'title' => 'Corporate & Hospitality',
                'description' => 'Dealers\' meets, award ceremonies, trade exhibitions, and brand launches for corporate organisations.',
                'meta' => '2+ clients',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/>',
                'highlighted' => false
            ],
        ];

        return view('livewire.pages.clientele-page', compact('clients', 'testimonials', 'stats', 'sectors'));
    }
}
