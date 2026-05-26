<?php

namespace App\Livewire\Admin;

use App\Interfaces\ContactRepositoryInterface;
use Livewire\Component;

class ContactSettings extends Component
{
    protected ContactRepositoryInterface $repository;
    public $address = '';
    public $phone = '';
    public $email = '';

    protected function rules(): array
    {
        return [
            'address' => 'required|string|min:5|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'required|email|max:100',
        ];
    }
   /**
     * Livewire Lifecycle Boot Method
     * This runs before mount() on the initial load, and before every subsequent request/action.
     */
    public function boot(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function mount()
    {
        try {
            $settings = $this->repository->getSettings();

            $this->address = $settings->address;
            $this->phone = $settings->phone;
            $this->email = $settings->email;
        } catch (\Exception $exception) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Unable to retrieve settings records from the database storage server.']);
        }
    }

    public function save()
    {
        $validatedData = $this->validate();

        try {
            // Attempt to dispatch execution logic to the database layer
            $this->repository->updateSettings($validatedData);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Contact configuration variables synchronized successfully.']);
        } catch (\Exception $exception) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'An unexpected database error occurred. Transaction execution rolled back safely.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.contact-settings');
    }
}
