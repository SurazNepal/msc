<?php

namespace App\Livewire\Home\Sections;

use App\Enums\ClientStatusEnum;
use App\Models\Admin\Service;
use App\Models\Admin\About\AboutSetting;
use App\Models\Admin\Client;
use Livewire\Component;

class ServiceSection extends Component
{
    public $services;
    public $setting;
    public $avatarClients;

    public function mount()
    {
        // Assuming your active status value is 'published' or true based on your Enums/conventions
        $this->services = Service::latest()
            ->get();

        // Used to pull network statistics dynamically (Stats count / established metrics)
        $this->setting = AboutSetting::first();
        // Fetch up to 4 published clients for the avatar stack
        $this->avatarClients = Client::where('status', ClientStatusEnum::PUBLISHED)
            ->latest()
            ->take(4)
            ->get();
    }

    public function render()
    {
        return view('livewire.home.sections.service-section');
    }
}
