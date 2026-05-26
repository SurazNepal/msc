<?php

namespace App\Livewire\Home\Sections;

use App\Models\Review;
use Livewire\Component;

class TestimonialSection extends Component
{
    // Listens to form submissions so the review grid updates instantly without refreshing the page
    protected $listeners = ['reviewSubmitted' => '$refresh'];

    public function render()
    {
        return view('livewire.home.sections.testimonial-section', [
            'reviews' => Review::where('is_approved', true)->latest()->get()
        ]);
    }
}
