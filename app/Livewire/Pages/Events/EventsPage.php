<?php

namespace App\Livewire\Pages\Events;

use App\Models\Admin\PortfolioEvent;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest.main', ['title' => 'Portfolio Event Page', 'withFilters' => false, 'breadcrumbs' => ''])]

class EventsPage extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $events = PortfolioEvent::published()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest('year')
            ->paginate(9);

        return view('livewire.pages.events.events-page', [
            'events' => $events
        ]);
    }
}
