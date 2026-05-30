<?php

namespace App\Livewire\Admin\Services;

use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use App\Interfaces\ServiceRepositoryInterface;
use Livewire\Attributes\On;

class Services extends Component
{
    use WithPagination;

    protected ServiceRepositoryInterface $repository;

    #[Url(history: true)]
    public $search = '';
    public int $perPage = 10;
    public $serviceId = null;

    public function boot(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getServicesProperty()
    {
        return $this->repository->getPaginatedServices(
            trim($this->search),
            $this->perPage
        );
    }

    public function destroy(int $serviceId)
    {
        $this->serviceId = $serviceId;
        $this->dispatch('confirm_delete', ['for' => 'Services']);
    }

    #[On('deleteActionServices')]
    public function delete()
    {
        try {
            $this->repository->deleteService($this->serviceId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Service deleted!']);
            $this->reset('serviceId');
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Something went wrong. Data was safely rolled back.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.services.services', [
            'services' => $this->getServicesProperty()
        ]);
    }
}
