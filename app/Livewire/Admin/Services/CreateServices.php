<?php

namespace App\Livewire\Admin\Services;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Interfaces\ServiceRepositoryInterface;

class CreateServices extends Component
{
    use WithFileUploads;

    protected ServiceRepositoryInterface $repository;

    #[Validate('required|min:2|max:255')]
    public $title = '';
    #[Validate('required|min:2')]
    public $description = '';
    #[Validate('required')]
    public $status = '';
    #[Validate('nullable|image|max:2048')]
    public $icon;

    public function boot(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save()
    {
        $validatedData = $this->validate();

        if ($this->icon) {
            $validatedData['icon'] = $this->icon->getRealPath();
        } else {
            $validatedData['icon'] = null;
        }

        try {
            $this->repository->createService($validatedData);
            session()->flash('message', 'Service Added Successfully!');
            return $this->redirect(route('services'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Insertion aborted. Data structural exception occurred.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.services.create-services')->layout('layouts.app');
    }
}
