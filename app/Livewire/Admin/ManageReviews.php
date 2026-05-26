<?php

namespace App\Livewire\Admin;

use App\Models\Review;
use Flux\Flux;
use Livewire\Component;
use Livewire\WithPagination;

class ManageReviews extends Component
{
    use WithPagination;

    // Properties for handling modal state safely
    public $selectedReviewId;
    public $modalReviewName = '';
    public $modalReviewComment = '';

    protected $listeners = ['refreshReviews' => '$refresh'];

    /**
     * Opens the confirmation modal and binds info data
     */
    public function selectReview($id, $action)
    {
        $review = Review::findOrFail($id);
        $this->selectedReviewId = $id;
        $this->modalReviewName = $review->name;
        $this->modalReviewComment = $review->comment;

        if ($action === 'approve') {
            Flux::modal('approve-review-modal')->show();
        } elseif ($action === 'delete') {
            Flux::modal('delete-review-modal')->show();
        }
    }

    /**
     * Approves the selected review item
     */
    public function approveReview()
    {
        $review = Review::findOrFail($this->selectedReviewId);
        $review->update(['is_approved' => true]);

        Flux::modal('approve-review-modal')->close();

        // Dispatching custom SweetAlert toast event
        $this->dispatch('swalToast', [
            'icon' => 'success',
            'message' => 'Review approved successfully!'
        ]);

        $this->reset(['selectedReviewId', 'modalReviewName', 'modalReviewComment']);
    }

    /**
     * Deletes a review item from the system completely
     */
    public function deleteReview()
    {
        $review = Review::findOrFail($this->selectedReviewId);
        $review->delete();
        Flux::modal('delete-review-modal')->close();
        $this->dispatch('swalToast', [
            'icon' => 'warning',
            'message' => 'Review deleted successfully.'
        ]);

        $this->reset(['selectedReviewId', 'modalReviewName', 'modalReviewComment']);
    }
    /**
     * Rejects an already live review and moves it back to pending moderation
     */
    public function rejectReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => false]);

        $this->dispatch('swalToast', [
            'icon' => 'info',
            'title' => 'Review moved back to moderation queue.'
        ]);
    }


    public function render()
    {
        return view('livewire.admin.manage-reviews', [
            'pendingReviews' => Review::where('is_approved', false)->latest()->get(),
            'approvedReviews' => Review::where('is_approved', true)->latest()->paginate(10),
        ]);
    }
}
