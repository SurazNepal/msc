<?php

namespace App\Livewire\Home\Sections;

use App\Models\Admin\Client;
use Livewire\Component;

class ClienteleSection extends Component
{
    public $clients;

    public function mount()
    {
        // Utilizes your defined query scope to grab only published brands
        $this->clients = Client::published()
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.home.sections.clientele-section');
    }
}
