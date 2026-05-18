<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Interfaces\TeamRepositoryInterface;
use App\Enums\TeamStatusEnum;

class Teams extends Component
{
    use WithPagination, WithFileUploads;

    protected TeamRepositoryInterface $repository;

    #[Url(history: true)]
    public $search = '';
    public int $perPage = 10;
    public $isEditMode = false;
    public $teamId = null;

    #[Validate('required|min:3|max:255')]
    public $full_name = '';

    #[Validate('required|min:2|max:255')]
    public $job_post = '';

    #[Validate('required|string')]
    public $status = 'published';

    #[Validate('nullable|image|max:2048')]
    public $thumbnail;
    public $existingThumbnail;

    public function boot(TeamRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getTeamsProperty()
    {
        return $this->repository->getPaginatedTeams(trim($this->search), $this->perPage);
    }

    public function showTeamModal()
    {
        $this->resetData();
        Flux::modal('teamModal')->show();
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
            $this->repository->createTeam($validatedData);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Team Member Added Successfully!']);
            $this->closeModalAndReset();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to create team profile.']);
        }
    }

    public function update()
    {
        // Manual parameter isolation rule schema protects runtime state modifications
        $validatedData = $this->validate([
            'full_name' => 'required|min:3|max:255',
            'job_post'  => 'required|min:2|max:255',
            'status'    => 'required|string',
            'thumbnail' => 'nullable',
        ]);

        if ($this->thumbnail) {
            $validatedData['thumbnail'] = $this->thumbnail->getRealPath();
        }

        try {
            $this->repository->updateTeam($this->teamId, $validatedData);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Team Profile Updated!']);
            $this->closeModalAndReset();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to update profile entries.']);
        }
    }

    public function deleteExistingThumbnail()
    {
        if (!$this->teamId) return;

        try {
            $team = $this->repository->getTeamById($this->teamId);
            $team->clearMediaCollection('team_image');
            $this->existingThumbnail = null;
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Image removed cleanly!']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to drop media file.']);
        }
    }

    public function edit(int $teamId)
    {
        $this->resetData();

        try {
            $team = $this->repository->getTeamById($teamId);

            $this->teamId = $team->id;
            $this->full_name = $team->full_name;
            $this->job_post = $team->job_post;
            $this->status = $team->status instanceof TeamStatusEnum ? $team->status->value : $team->status;
            $this->existingThumbnail = $team->getFirstMediaUrl('team_image', 'large');

            $this->isEditMode = true;
            Flux::modal('teamModal')->show();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not fetch data record.']);
        }
    }

    public function destroy(int $teamId)
    {
        $this->teamId = $teamId;
        $this->dispatch('confirm_delete', ['for' => 'Teams']);
    }

    #[On('deleteActionTeams')]
    public function delete()
    {
        try {
            $this->repository->deleteTeam($this->teamId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Profile removed successfully!']);
            $this->resetData();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Deletion failed.']);
        }
    }

    public function removeUpload()
    {
        $this->reset('thumbnail');
    }

    protected function closeModalAndReset()
    {
        $this->resetData();
        Flux::modal('teamModal')->close();
    }

    public function resetData()
    {
        $this->reset(['full_name', 'job_post', 'teamId', 'thumbnail', 'existingThumbnail', 'isEditMode']);
        $this->status = TeamStatusEnum::PUBLISHED->value;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.teams', [
            'teams' => $this->teams
        ]);
    }
}
