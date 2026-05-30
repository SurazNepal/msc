<?php

namespace App\Livewire\Admin\Services;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Interfaces\ServiceRepositoryInterface;

class EditServices extends Component
{
    use WithFileUploads;

    protected ServiceRepositoryInterface $repository;

    public $serviceId;

    #[Validate('required|min:2|max:255')]
    public $title = '';
    #[Validate('required|min:2')]
    public $description = '';
    #[Validate('required')]
    public $status = '';
    #[Validate('nullable|image|max:2048')]
    public $icon;
    public $existingIcon;

    public function boot(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function mount(string $slug)
    {
        // Finds target records using the clean architectural interface slug mapping rule
        $service = $this->repository->getServiceBySlug($slug);

        if (!$service) {
            return $this->redirect(route('services'), navigate: true);
        }

        $this->serviceId = $service->id;
        $this->title = $service->title;
        $this->description = $service->description;
        $this->status = $service->status instanceof \App\Enums\ServiceStatusEnum ? $service->status->value : $service->status;
        $this->existingIcon = $service->getFirstMediaUrl('icon', 'thumb');
    }

    public function update()
    {
        $validatedData = $this->validate();

        if ($this->icon) {
            $validatedData['icon'] = $this->icon->getRealPath();
        } else {
            $validatedData['icon'] = null;
        }

        try {
            $this->repository->updateService($this->serviceId, $validatedData);
            session()->flash('message', 'Service Updated Successfully!');
            return $this->redirect(route('services'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Update transaction failed execution safely.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.services.edit-services')->layout('layouts.app');
    }
}
