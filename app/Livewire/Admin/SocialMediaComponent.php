<?php

namespace App\Livewire\Admin;

use App\Interfaces\SocialMediaRepositoryInterface;
use Flux\Flux;
use Livewire\Attributes\On;
use Livewire\Component;

class SocialMediaComponent extends Component
{
    protected SocialMediaRepositoryInterface $repository;

    public $name = '';
    public $url = '';
    public $selectedId = null;
    public $isEditMode = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'url'  => 'required|url|max:255',
        ];
    }

    public function boot(SocialMediaRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function openCreateModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'url', 'selectedId', 'isEditMode']);
        Flux::modal('social-media-modal')->show();
    }

    public function save()
    {
        $validatedData = $this->validate();

        try {
            if ($this->isEditMode) {
                $this->repository->update($this->selectedId, $validatedData);
                $message = 'Social Media Link Updated Successfully!';
            } else {
                $this->repository->store($validatedData);
                $message = 'Social Media Link Added Successfully!';
            }
            Flux::modal('social-media-modal')->close();
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => $message]);
            $this->reset(['name', 'url', 'selectedId', 'isEditMode']);
        } catch (\Exception $exception) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Something went wrong! Operational execution halted.']);
        }
    }

    public function edit($id)
    {
        $this->resetValidation();
        try {
            $social = $this->repository->find($id);
            if ($social) {
                $this->selectedId = $social->id;
                $this->name = $social->name;
                $this->url = $social->url;
                $this->isEditMode = true;
                Flux::modal('social-media-modal')->show();
            }
        } catch (\Exception $exception) {
            Flux::modal('social-media-modal')->close();
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Unable to load structural record data.']);
        }
    }
    public function delete($id){
        $this->selectedId = $id ;
        $this->dispatch('confirm_delete',['for' => 'SocialMedia']);
    }

    #[On('deleteActionSocialMedia')]
    public function destroy()
    {
        try {
            $this->repository->delete($this->selectedId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Social Media Link Deleted Successfully!']);
        } catch (\Exception $exception) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to drop link from repository record mapping.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.social-media-component', [
            'socials' => $this->repository->all()
        ]);
    }
}
