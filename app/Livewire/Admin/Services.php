<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Interfaces\ServiceRepositoryInterface;
use Livewire\Attributes\On;

class Services extends Component
{
    use WithPagination, WithFileUploads;

    // This property is initialized on every cycle by the boot engine
    protected ServiceRepositoryInterface $repository;

    #[Url(history: true)]
    public $search = '';
    public int $perPage = 10;

    #[Validate('nullable|image|max:2048')]
    public $icon;
    public $existingIcon;
    public $isEditable = false;
    public $isEditMode = false; // Added this since it was missing but used in save()

    #[Validate('required|min:2')]
    public $title, $description;
    public $serviceId = null;
    #[Validate('required')]
    public $status;

    /**
     * FIX 1: Use boot() instead of mount(). This forces Laravel to resolve
     * the Interface injection on every single interaction (like form submissions).
     */
    public function boot(ServiceRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Reset pagination page automatically when user types a search term
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Computed property to handle reactive search parameters and pagination loops
     */
    public function getServicesProperty()
    {
        return $this->repository->getPaginatedServices(
            trim($this->search),
            $this->perPage
        );
    }


    public function showServiceModal()
    {
        Flux::modal('serviceModal')->show();
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
            if ($this->isEditMode) {
                $this->repository->updateService($this->serviceId, $validatedData);
                $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Service Updated!']);
            } else {
                $this->repository->createService($validatedData);
                $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Service Added!']);
            }

            $this->resetData();
            Flux::modal('serviceModal')->close();

        } catch (\Exception $e) {
            $this->resetData();
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Something went wrong. Data was safely rolled back.']);
        }
    }
    public function edit(int $serviceId){
        $this->resetData(); // Clear old validation states or artifacts

        try {
            $service = $this->repository->getServiceById($serviceId);

            $this->serviceId = $service->id;
            $this->title = $service->title;
            $this->description = $service->description;
            $this->status = $service->status;

            // Capture the 'thumb' conversion URL to showcase in your view
            $this->existingIcon = $service->getFirstMediaUrl('icon', 'thumb');

            $this->isEditMode = true;

            Flux::modal('serviceModal')->show();

        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not fetch service details.']);
        }

    }
    public function update(){
        // Validate only the form fields
        $validatedData = $this->validate([
            'title'       => 'required|min:2',
            'description' => 'required|min:2',
            'icon'        => 'nullable|image|max:2048',
            'status'      => 'required',
        ]);

        // Pass the file path only if a brand new icon is being uploaded
        if ($this->icon) {
            $validatedData['icon'] = $this->icon->getRealPath();
        } else {
            $validatedData['icon'] = null;
        }
        try {
            // Run the atomic database transaction via the repository layout
            $this->repository->updateService($this->serviceId, $validatedData);

            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Service Updated Successfully!']);

            $this->resetData();
            Flux::modal('serviceModal')->close();

        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Update failed. Data was safely rolled back.']);
        }
    }
    public function destroy(int $serviceId){
        $this->serviceId = $serviceId;
        $this->dispatch('confirm_delete',['for'=>'Services']);
    }
    #[On('deleteActionServices')]
    public function delete(){
        try{
            $this->repository->deleteService($this->serviceId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Service deleted!']);
        }catch(\Exception $e){
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Something went wrong. Data was safely rolled back.']);
        }
    }

    public function render()
    {
        // Pass the computed services tracker directly to your Blade template loop
        return view('livewire.admin.services', [
            'services' => $this->getServicesProperty()
        ]);
    }

    public function resetData()
    {
        $this->reset(['title', 'description', 'serviceId', 'icon', 'existingIcon', 'isEditMode', 'isEditable','search']);
    }
}
