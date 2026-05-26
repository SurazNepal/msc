<?php

namespace App\Livewire\Pages;

use App\Interfaces\AboutRepositoryInterface;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.guest.main', ['title' => 'About Us Page', 'withFilters' => false, 'breadcrumbs' => ''])]
class AboutUsPage extends Component
{
    /**
     * Renders the frontend About Us page with stored settings and dynamic highlights
     */
    public function render(AboutRepositoryInterface $aboutRepository)
    {
        return view('livewire.pages.about-us-page', [
            'settings'   => $aboutRepository->getSettings(),
            'highlights' => $aboutRepository->getAllHighlights()->where('is_active', true)
        ]);
    }
}
