<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Interfaces\ClientRepositoryInterface;
use App\Enums\ClientStatusEnum;

class Clients extends Component
{
    use WithPagination, WithFileUploads;

    protected ClientRepositoryInterface $repository;

    #[Url(history: true)]
    public $search = '';
    public int $perPage = 10;
    public $isEditMode = false;
    public $clientId = null;

    #[Validate('required|min:2|max:255')]
    public $full_name = '';

    #[Validate('nullable|url|max:255')]
    public $website_url = '';

    #[Validate('required|string')]
    public $status = 'published';

    #[Validate('nullable|image|max:2048')]
    public $thumbnail;
    public $existingThumbnail;

    public function boot(ClientRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getClientsProperty()
    {
        return $this->repository->getPaginatedClients(trim($this->search), $this->perPage);
    }

    public function showClientModal()
    {
        $this->resetData();
        Flux::modal('clientModal')->show();
    }

    public function save()
    {
        if ($this->isEditMode) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $validatedData = $this->validate();
        if ($this->thumbnail) {
            $validatedData['thumbnail'] = $this->thumbnail->getRealPath();
        }

        try {
            $this->repository->createClient($validatedData);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Client Added Successfully!']);
            $this->closeModalAndReset();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to add client records.']);
        }
    }

    public function update()
    {
        $validatedData = $this->validate([
            'full_name'        => 'required|min:2|max:255',
            'website_url' => 'nullable|url|max:255',
            'status'      => 'required|string',
            'thumbnail'   => 'nullable',
        ]);

        if ($this->thumbnail) {
            $validatedData['thumbnail'] = $this->thumbnail->getRealPath();
        }

        try {
            $this->repository->updateClient($this->clientId, $validatedData);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Client Details Updated!']);
            $this->closeModalAndReset();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to update client entry.']);
        }
    }

    public function deleteExistingThumbnail()
    {
        if (!$this->clientId) return;

        try {
            $client = $this->repository->getClientById($this->clientId);
            $client->clearMediaCollection('client_logo');
            $this->existingThumbnail = null;
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Logo removed cleanly!']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to clear file assets.']);
        }
    }

    public function edit(int $clientId)
    {
        $this->resetData();

        try {
            $client = $this->repository->getClientById($clientId);

            $this->clientId = $client->id;
            $this->full_name = $client->full_name;
            $this->website_url = $client->website_url;
            $this->status = $client->status instanceof ClientStatusEnum ? $client->status->value : $client->status;
            $this->existingThumbnail = $client->getFirstMediaUrl('client_logo', 'large');

            $this->isEditMode = true;
            Flux::modal('clientModal')->show();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not pull client data records.']);
        }
    }

    public function destroy(int $clientId)
    {
        $this->clientId = $clientId;
        $this->dispatch('confirm_delete', ['for' => 'Clients']);
    }

    #[On('deleteActionClients')]
    public function delete()
    {
        try {
            $this->repository->deleteClient($this->clientId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Client dropped cleanly!']);
            $this->resetData();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Deletion target failed.']);
        }
    }

    public function removeUpload()
    {
        $this->reset('thumbnail');
    }

    protected function closeModalAndReset()
    {
        $this->resetData();
        Flux::modal('clientModal')->close();
    }

    public function resetData()
    {
        $this->reset(['full_name', 'website_url', 'clientId', 'thumbnail', 'existingThumbnail', 'isEditMode']);
        $this->status = ClientStatusEnum::PUBLISHED->value;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.clients', [
            'clients' => $this->clients
        ]);
    }
}
