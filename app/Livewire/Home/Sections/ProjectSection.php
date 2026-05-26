<?php

namespace App\Livewire\Home\Sections;

use App\Models\Admin\PortfolioEvent;
use App\Enums\PortfolioStatusEnum;
use Livewire\Component;

class ProjectSection extends Component
{
    // Tracks how many cards to render out
    public $perPage = 3;

    public function loadMore()
    {
        $this->perPage += 3;
    }

    public function render()
    {
        // Fetch active items dynamically adjusted by the current perPage count
        $portfolioEvents = PortfolioEvent::where('status', PortfolioStatusEnum::PUBLISHED)
            ->latest()
            ->take($this->perPage)
            ->get();


        return view('livewire.home.sections.project-section', [
            'portfolioEvents' => $portfolioEvents,
        ]);
    }
}
