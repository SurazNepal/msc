<?php

namespace App\Livewire\Admin\PortfolioEvents;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Interfaces\PortfolioRepositoryInterface;
use App\Enums\PortfolioStatusEnum;

class CreateEvents extends Component
{
    use WithFileUploads;

    #[Validate('required|min:3|max:255')]
    public $title = '';
    #[Validate('required|string')]
    public $tags = '';
    #[Validate('required|string')]
    public $status = 'draft';
    #[Validate('nullable|string|max:50')]
    public $year = '';
    #[Validate('nullable|string')]
    public $description = '';
    #[Validate('nullable|image|max:2048')]
    public $thumbnail;

    public function mount()
    {
        $this->status = PortfolioStatusEnum::DRAFT->value;
    }

    public function save()
    {
        $validatedData = $this->validate();
        $validatedData['tags'] = array_filter(array_map('trim', explode(',', $this->tags)));

        try {
            $repository = app(PortfolioRepositoryInterface::class);
            $repository->createEvent($validatedData);

            session()->flash('message', 'Event Added Successfully!');
            return $this->redirect(route('admin.portfolio-events'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Operation failed.']);
        }
    }

    public function removeUpload()
    {
        $this->reset('thumbnail');
    }

    public function render()
    {
        // Layout path depends on where your main template lives (e.g., layouts.admin)
        return view('livewire.admin.portfolio-events.create-events')->layout('layouts.app');
    }
}

