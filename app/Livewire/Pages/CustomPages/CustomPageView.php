<?php

namespace App\Livewire\Pages\CustomPages;

use Livewire\Component;
use App\Interfaces\CustomPageRepositoryInterface;
use Livewire\Attributes\Layout;

#[Layout('layouts.guest.main', ['title' => 'Custom Page', 'withFilters' => false, 'breadcrumbs' => ''])]
class CustomPageView extends Component
{
    public $title;
    public $content;
    public $createdAt;
    public $imageUrl;

    public function mount(string $slug, CustomPageRepositoryInterface $repository)
    {
        $page = $repository->getPageBySlug($slug);

        // Fail with a 404 if the page doesn't exist or isn't published yet
        if (!$page || $page->status !== 'Published') {
            abort(404);
        }

        // Bind data parameters safely to local properties
        $this->title = $page->title;
        $this->content = $page->content;
        $this->createdAt = $page->created_at->format('M d, Y');
        $this->imageUrl = $page->getFirstMediaUrl('featured_images', 'large');
    }

    public function render()
    {
        return view('livewire.pages.custom-pages.custom-page-view');
    }
}
