<?php

namespace App\Livewire\Admin\CustomPages;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Interfaces\CustomPageRepositoryInterface;

class CreateCustomPage extends Component
{
    use WithFileUploads;

    protected CustomPageRepositoryInterface $repository;

    #[Validate('required|min:2|max:255')]
    public $title = '';
    #[Validate('nullable|string')]
    public $content = '';
    #[Validate('required')]
    public $status = 'Published';
    #[Validate('nullable|image|max:2048')]
    public $featuredImage;

    public function boot(CustomPageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function save()
    {
        $validatedData = $this->validate();

        $payload = [
            'title'          => $this->title,
            'content'        => $this->content,
            'status'         => $this->status,
            'featured_image' => $this->featuredImage ? $this->featuredImage->getRealPath() : null,
        ];

        try {
            $this->repository->createPage($payload);
            session()->flash('message', 'Custom Page Added Successfully!');
            return $this->redirect(route('manage-custom-pages'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Insertion aborted. Data structural exception occurred.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.custom-pages.create-custom-page')->layout('layouts.app');
    }
}
