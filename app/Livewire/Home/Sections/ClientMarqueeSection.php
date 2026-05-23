<?php

namespace App\Livewire\Home\Sections;

use App\Models\Admin\Client;
use Livewire\Component;

class ClientMarqueeSection extends Component
{
    public $clients ;
    public function mount(){
        $this->clients = Client::published()
        ->with('media')
        ->latest()
        ->get();
    }
    public function render()
    {
        return view('livewire.home.sections.client-marquee-section');
    }
}
