<?php

namespace App\Livewire\Components;

use App\Models\Review;
use Livewire\Component;

class ReviewSubmission extends Component
{
    // Form attributes
    public $name = '';
    public $designation = '';
    public $comment = '';
    public $rating = 5; // Default choice

    // Interactive state indicator
    public $successMessage = '';

    protected $rules = [
        'name' => 'required|string|min:3|max:50',
        'designation' => 'nullable|string|max:100',
        'comment' => 'required|string|min:10|max:500',
        'rating' => 'required|integer|between:1,5',
    ];

    public function setRating($value)
    {
        $this->rating = (int) $value;
    }

    public function submitReview()
    {
        $this->validate();

        Review::create([
            'name' => $this->name,
            'designation' => $this->designation,
            'comment' => $this->comment,
            'rating' => $this->rating,
            'is_approved' => false, // Set to true if moderation is not needed
        ]);

        $this->reset(['name', 'designation', 'comment', 'rating']);
        $this->dispatch('swalToast',['icon' => 'success', 'message' => ' Thank you! Your feedback has been submitted for review.']);

    }

    public function render()
    {
        return view('livewire.components.review-submission');
    }
}
