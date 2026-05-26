<?php

namespace App\Livewire\Home\Sections;

use App\Models\Admin\HowWeWork;
use App\Enums\WorkStatusEnum;
use Livewire\Component;

class HowWeWorkSection extends Component
{
    public $steps;

    public function mount()
    {
        // Assuming WorkStatusEnum has a case for active/published items (e.g., WorkStatusEnum::PUBLISHED)
        $this->steps = HowWeWork::where('status', WorkStatusEnum::PUBLISHED)
            ->orderBy('step', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.home.sections.how-we-work-section');
    }
}
