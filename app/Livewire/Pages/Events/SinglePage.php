<?php

namespace App\Livewire\Pages\Events;

use App\Enums\PortfolioStatusEnum;
use App\Models\Admin\PortfolioEvent;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest.main', ['title' => 'Portfolio Event Page', 'withFilters' => false, 'breadcrumbs' => ''])]
class SinglePage extends Component
{
    public PortfolioEvent $event;

    // Automatic Route Model Binding triggers validation initialization directly
    public function mount(PortfolioEvent $event)
    {
        // Enforce safety checks to ensure draft events aren't read from direct URI strings
        if ($event->status !== PortfolioStatusEnum::PUBLISHED) {
            abort(404);
        }

        $this->event = $event;
    }

    public function render()
    {
        return view('livewire.pages.events.single-page');
    }
}
