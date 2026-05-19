<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use Livewire\Component;
use Livewire\Attributes\Url;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use App\Interfaces\HowWeWorkRepositoryInterface;
use App\Enums\WorkStepEnum;
use App\Enums\WorkStatusEnum;
use Illuminate\Support\Facades\DB;

class HowWeWorks extends Component
{
    use WithPagination, WithFileUploads;

    protected HowWeWorkRepositoryInterface $repository;

    #[Url(history: true)]
    public $search = '';
    public int $perPage = 10;
    public $isEditMode = false;
    public $stepId = null;

    #[Validate('required|string')]
    public $step = '01';

    #[Validate('required|min:3|max:255')]
    public $title = '';

    #[Validate('required|min:10')]
    public $description = '';

    #[Validate('required|string')]
    public $status = 'published';

    #[Validate('nullable|image|max:2048')]
    public $icon;
    public $existingIcon;

    public bool $shouldDeleteExistingIcon = false;

    public function boot(HowWeWorkRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getStepsProperty()
    {
        return $this->repository->getPaginatedSteps(trim($this->search), $this->perPage);
    }

    public function showStepModal()
    {
        $this->resetData();
        Flux::modal('stepModal')->show();
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

        if ($this->icon) {
            $validatedData['icon'] = $this->icon->getRealPath();
        }

        try {
            $this->repository->createStep($validatedData);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Work Step Added!']);
            $this->closeModalAndReset();
        } catch (\Exception $e) {
            $this->closeModalAndReset();
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to create work step.']);
        }
    }

    public function update()
    {
        $validatedData = $this->validate([
            'step'        => 'required|string',
            'title'       => 'required|min:3|max:255',
            'description' => 'required|min:10',
            'status'      => 'required|string',
            'icon'        => 'nullable',
        ]);

        if ($this->icon) {
            $validatedData['icon'] = $this->icon->getRealPath();
        }

        try {
            // Wrapping additional UI collection rules cleanly side-by-side with your model updating logic
            DB::transaction(function () use ($validatedData) {
                $this->repository->updateStep($this->stepId, $validatedData);

                if ($this->shouldDeleteExistingIcon && !$this->icon) {
                    $stepModel = $this->repository->getStepById($this->stepId);
                    $stepModel->clearMediaCollection('work_icon');
                }
            });

            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Work Step Updated!']);
            $this->closeModalAndReset();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to modify details.']);
        }
    }

    public function markExistingIconForDeletion()
    {
        $this->shouldDeleteExistingIcon = true;
    }

    public function edit(int $id)
    {
        $this->resetData();

        try {
            $stepModel = $this->repository->getStepById($id);

            $this->stepId = $stepModel->id;
            $this->step = $stepModel->step instanceof WorkStepEnum ? $stepModel->step->value : $stepModel->step;
            $this->title = $stepModel->title;
            $this->description = $stepModel->description;
            $this->status = $stepModel->status instanceof WorkStatusEnum ? $stepModel->status->value : $stepModel->status;
            $this->existingIcon = $stepModel->getFirstMediaUrl('work_icon', 'thumb');

            $this->isEditMode = true;
            Flux::modal('stepModal')->show();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Unable to read step info.']);
        }
    }

    public function destroy(int $id)
    {
        $this->stepId = $id;
        $this->dispatch('confirm_delete', ['for' => 'HowWeWorks']);
    }

    #[On('deleteActionHowWeWorks')]
    public function delete()
    {
        try {
            $this->repository->deleteStep($this->stepId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Step deleted successfully!']);
            $this->resetData();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Deletion failed.']);
        }
    }

    public function removeImage()
    {
        $this->reset('icon');
    }

    protected function closeModalAndReset()
    {
        $this->resetData();
        Flux::modal('stepModal')->close();
    }

    public function resetData()
    {
        $this->reset(['step', 'title', 'description', 'stepId', 'icon', 'existingIcon', 'isEditMode', 'shouldDeleteExistingIcon']);
        $this->step = WorkStepEnum::STEP_01->value;
        $this->status = WorkStatusEnum::PUBLISHED->value;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.how-we-works', [
            'steps' => $this->steps
        ]);
    }
}
