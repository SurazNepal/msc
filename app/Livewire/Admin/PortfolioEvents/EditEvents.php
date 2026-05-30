<?php

namespace App\Livewire\Admin\PortfolioEvents;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Interfaces\PortfolioRepositoryInterface;
use App\Enums\PortfolioStatusEnum;

class EditEvents extends Component
{
    use WithFileUploads;

    public $eventSlug;
    public $eventId;

    #[Validate('required|min:3|max:255')]
    public $title = '';
    #[Validate('required|string')]
    public $tags = '';
    #[Validate('required|string')]
    public $status = 'draft';
    #[Validate('nullable|string|max:50')]
    public $year = '';
    #[Validate('nullable|string')]
    public $description = '';
    #[Validate('nullable|image|max:2048')]
    public $thumbnail;
    public $existingThumbnail;

    public function mount($slug) // Captured from URL parameter rule directly
    {
        $this->eventSlug = $slug;
        $repository = app(PortfolioRepositoryInterface::class);
        $event = $repository->getEventBySlug($this->eventSlug);
        $this->eventId = $event->id;

        if (!$event) {
            return $this->redirect(route('admin.portfolio-events'), navigate: true);
        }

        $this->title = $event->title;
        $this->year = $event->year;
        $this->description = $event->description;
        $this->status = $event->status instanceof PortfolioStatusEnum ? $event->status->value : $event->status;
        $this->tags = is_array($event->tags) ? implode(', ', $event->tags) : '';
        $this->existingThumbnail = $event->getFirstMediaUrl('portfolio_image', 'large');
    }

    public function save()
    {
        $validatedData = $this->validate();
        $validatedData['tags'] = array_filter(array_map('trim', explode(',', $this->tags)));

        try {
            $repository = app(PortfolioRepositoryInterface::class);
            $repository->updateEvent($this->eventId, $validatedData);

            session()->flash('message', 'Event Updated Successfully!');
            return $this->redirect(route('admin.portfolio-events'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Update failed.']);
        }
    }

    public function deleteExistingThumbnail()
    {
        try {
            $repository = app(PortfolioRepositoryInterface::class);
            $event = $repository->getEventById($this->eventId);
            $event->clearMediaCollection('portfolio_image');

            $this->existingThumbnail = null;
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Image removed permanently!']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to drop asset.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.portfolio-events.edit-events');
    }
}
