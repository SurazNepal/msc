<?php

namespace App\Livewire\Components;

use App\Models\Admin\ContactSetting;
use App\Models\Admin\About\AboutSetting;
use App\Models\Admin\FooterNavigation;
use App\Models\Admin\SocialMedia;
use Livewire\Component;

class Footer extends Component
{
    public $contactSetting;
    public $aboutSetting;
    public $navigations; // Keeps a flat collection of Eloquent models securely tracked
    public $socials;

    public function mount()
    {
        // 1. Fetch dynamic navigation columns safely as normal Eloquent items
        $this->navigations = FooterNavigation::whereNotNull('type')
            ->oldest('id')
            ->get();

        // 2. Load contact parameters fallback settings row
        $this->contactSetting = ContactSetting::first() ?? new ContactSetting([
            'address' => 'Dhumbarahi Height, Dhumbarahi, Kathmandu-10, Nepal',
            'phone'   => '01-4474158',
            'email'   => 'info@mindshareconnect.com.np'
        ]);

        // 3. Load registration tax data parameters
        $this->aboutSetting = AboutSetting::first() ?? new AboutSetting([
            'registration_number' => '81657/067/68',
            'pan_vat_number'      => '304957020'
        ]);

        // 4. Load your dynamic social media profile connections
        $this->socials = SocialMedia::oldest('name')->get();
    }

    public function render()
    {
        return view('livewire.components.footer');
    }
}
