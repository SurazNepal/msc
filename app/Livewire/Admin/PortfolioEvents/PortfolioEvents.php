<?php

namespace App\Livewire\Admin\PortfolioEvents;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use App\Interfaces\PortfolioRepositoryInterface;

class PortfolioEvents extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';
    public int $perPage = 10;

    // UI Layout Toggles
    public bool $isCreating = false;
    public bool $isEditing = false;
    public ?int $activeId = null;
    public ?int $deleteTargetId = null;

    protected $listeners = ['close-panel' => 'closePanel'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function startCreate()
    {
        $this->isEditing = false;
        $this->activeId = null;
        $this->isCreating = true;
    }

    public function startEdit(int $id)
    {
        $this->isCreating = false;
        $this->activeId = $id;
        $this->isEditing = true;
    }

    #[On('refresh-portfolio-list')]
    public function closePanel()
    {
        $this->isCreating = false;
        $this->isEditing = false;
        $this->activeId = null;
    }

    #[On('refresh-portfolio-list')]
    public function render()
    {
        $repository = app(PortfolioRepositoryInterface::class);
        return view('livewire.admin.portfolio-events.portfolio-events', [
            'events' => $repository->getPaginatedPortfolioEvent(trim($this->search), $this->perPage)
        ]);
    }

    public function destroy(int $eventId)
    {
        $this->deleteTargetId = $eventId;
        $this->dispatch('confirm_delete', ['for' => 'PortfolioEvents']);
    }

    #[On('deleteActionPortfolioEvents')]
    public function delete()
    {
        try {
            $repository = app(PortfolioRepositoryInterface::class);
            $repository->deleteEvent($this->deleteTargetId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Deleted successfully!']);

            if ($this->deleteTargetId === $this->activeId) {
                $this->closePanel();
            }
            $this->reset('deleteTargetId');
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Deletion failed.']);
        }
    }
}

