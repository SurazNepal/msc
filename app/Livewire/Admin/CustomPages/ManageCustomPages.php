<?php

namespace App\Livewire\Admin\CustomPages;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Interfaces\CustomPageRepositoryInterface;
use Livewire\Attributes\On;

class ManageCustomPages extends Component
{
    use WithPagination;

    protected CustomPageRepositoryInterface $repository;

    #[Url(history: true)]
    public $search = '';
    public int $perPage = 10;
    public $pageId = null;

    public function boot(CustomPageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getPagesProperty()
    {
        try {
            return $this->repository->getPaginatedPages(
                trim($this->search),
                $this->perPage
            );
        } catch (\Exception $e) {
            return collect();
        }
    }

    public function destroy(int $pageId)
    {
        $this->pageId = $pageId;
        $this->dispatch('confirm_delete', ['for' => 'CustomPages']);
    }

    #[On('deleteActionCustomPages')]
    public function delete()
    {
        try {
            $this->repository->deletePage($this->pageId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Custom page deleted!']);
            $this->reset('pageId');
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Something went wrong. Data was safely rolled back.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.custom-pages.manage-custom-pages', [
            'pages' => $this->getPagesProperty()
        ]);
    }
}
