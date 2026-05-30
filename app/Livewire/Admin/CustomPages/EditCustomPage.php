<?php

namespace App\Livewire\Admin\CustomPages;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Interfaces\CustomPageRepositoryInterface;

class EditCustomPage extends Component
{
    use WithFileUploads;

    protected CustomPageRepositoryInterface $repository;

    public $pageId;

    #[Validate('required|min:2|max:255')]
    public $title = '';
    #[Validate('nullable|string')]
    public $content = '';
    #[Validate('required')]
    public $status = '';
    #[Validate('nullable|image|max:2048')]
    public $featuredImage;
    public $existingFeaturedImage;

    public function boot(CustomPageRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function mount(string $slug)
    {
        $page = $this->repository->getPageBySlug($slug);

        if (!$page) {
            return $this->redirect(route('custom-pages'), navigate: true);
        }

        $this->pageId = $page->id;
        $this->title = $page->title;
        $this->content = $page->content;
        $this->status = $page->status;
        $this->existingFeaturedImage = $page->getFirstMediaUrl('featured_images', 'thumb');
    }

    public function update()
    {
        $validatedData = $this->validate();

        $payload = [
            'title'          => $this->title,
            'content'        => $this->content,
            'status'         => $this->status,
            'featured_image' => $this->featuredImage ? $this->featuredImage->getRealPath() : null,
        ];

        try {
            $this->repository->updatePage($this->pageId, $payload);
            session()->flash('message', 'Custom Page Updated Successfully!');
            return $this->redirect(route('manage-custom-pages'), navigate: true);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Update transaction failed execution safely.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.custom-pages.edit-custom-page')->layout('layouts.app');
    }
}
