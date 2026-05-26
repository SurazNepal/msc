<?php

namespace App\Livewire\Home\Sections;

use App\Models\Admin\Service;
use Livewire\Component;

class FAQSection extends Component
{
    public $services;

    public function mount()
    {
        // Fetches active/published services
        $this->services = Service::where('status', 'published')
            ->oldest() // Maintains custom insertion order sequence
            ->get();
    }

    public function render()
    {
        return view('livewire.home.sections.f-a-q-section');
    }
}
