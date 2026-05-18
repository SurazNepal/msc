<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Interfaces\PortfolioRepositoryInterface;
use App\Enums\PortfolioStatusEnum;

class PortfolioEvents extends Component
{
    use WithPagination, WithFileUploads;

    protected PortfolioRepositoryInterface $repository;

    #[Url(history: true)]
    public $search = '';
    public int $perPage = 10;
    public $isEditMode = false;
    public $eventId = null;

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

    public function boot(PortfolioRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getEventsProperty()
    {
        return $this->repository->getPaginatedPortfolioEvent(trim($this->search), $this->perPage);
    }

    public function showEventModal()
    {
        $this->resetData();
        Flux::modal('portfolioEventModal')->show();
    }

    public function save()
    {
        $validatedData = $this->validate();
        $validatedData['tags'] = array_filter(array_map('trim', explode(',', $this->tags)));

        try {
            if ($this->isEditMode) {
                $this->repository->updateEvent($this->eventId, $validatedData);
                $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Event Updated Successfully!']);
            } else {
                $this->repository->createEvent($validatedData);
                $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Event Added Successfully!']);
            }

            $this->resetData();
            Flux::modal('portfolioEventModal')->close();

        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Operation failed. Changes rolled back.']);
        }
    }

    /**
     * FIX: Dynamic method to instantly delete existing images from disk storage collections
     */
    public function deleteExistingThumbnail()
    {
        if (!$this->eventId) return;

        try {
            $event = $this->repository->getEventById($this->eventId);
            $event->clearMediaCollection('portfolio_image');

            $this->existingThumbnail = null;
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Image deleted from disk permanently!']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to delete stored media asset.']);
        }
    }

    public function edit(int $eventId)
    {
        $this->resetData();

        try {
            $event = $this->repository->getEventById($eventId);

            $this->eventId = $event->id;
            $this->title = $event->title;
            $this->year = $event->year;
            $this->description = $event->description;
            $this->status = $event->status instanceof PortfolioStatusEnum ? $event->status->value : $event->status;
            $this->tags = is_array($event->tags) ? implode(', ', $event->tags) : '';
            $this->existingThumbnail = $event->getFirstMediaUrl('portfolio_image', 'large');

            $this->isEditMode = true;
            Flux::modal('portfolioEventModal')->show();

        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not fetch record details.']);
        }
    }

    public function destroy(int $eventId)
    {
        $this->eventId = $eventId;
        $this->dispatch('confirm_delete', ['for' => 'PortfolioEvents']);
    }

    #[On('deleteActionPortfolioEvents')]
    public function delete()
    {
        try {
            $this->repository->deleteEvent($this->eventId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Event deleted successfully!']);
            $this->resetData();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Deletion failed.']);
        }
    }
    public function removeUpload()
    {
        dd('working');
        $this->reset('thumbnail');
    }

    public function resetData()
    {
        $this->reset(['title', 'description', 'tags', 'year', 'eventId', 'thumbnail', 'existingThumbnail', 'isEditMode']);
        $this->status = PortfolioStatusEnum::DRAFT->value;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.portfolio-events', [
            'events' => $this->events
        ]);
    }
}
