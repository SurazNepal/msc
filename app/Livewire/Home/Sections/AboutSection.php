<?php

namespace App\Livewire\Home\Sections;

use App\Models\Admin\About\AboutSetting;
use App\Models\Admin\About\AboutHighlight;
use Livewire\Component;

class AboutSection extends Component
{
    public $setting;
    public $highlights;

    public function mount()
    {
        // Fetches the primary corporate info dataset or falls back onto inline layouts safely
        $this->setting = AboutSetting::first();

        // Pulls structured solution highlights filtering out inactive entries completely
        $this->highlights = AboutHighlight::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.home.sections.about-section');
    }
}
