<?php

namespace App\Livewire\Admin;

use Flux\Flux;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Interfaces\AboutRepositoryInterface;
use Livewire\Attributes\On;

class AboutManager extends Component
{
    use WithFileUploads;

    protected AboutRepositoryInterface $repository;

    // About Settings Binding Parameters
    public array $state = [];
    public $banner_file;
    public $existingBanner;
    public bool $shouldDeleteBanner = false;

    // Highlights Sub-Collection Modal Fields
    public $highlightId = null;
    public $isHighlightEdit = false;
    public $h_title = '';
    public $h_description = '';
    public $h_sort_order = 0;
    public $h_is_active = true;
    public $h_icon;
    public $existingHIcon;
    public bool $shouldDeleteHIcon = false;

    public function boot(AboutRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $settings = $this->repository->getSettings();
        $this->state = $settings->toArray();
        $this->existingBanner = $settings->getFirstMediaUrl('about_banner');
        $this->shouldDeleteBanner = false;
        $this->banner_file = null;
    }

    public function saveSettings()
    {
        $this->validate([
            'state.badge_text'             => 'required|string|max:255',
            'state.title'                  => 'required|string|max:255',
            'state.description_one'        => 'required|string',
            'state.description_two'        => 'nullable|string',
            'state.registration_number'    => 'nullable|string',
            'state.registration_date_text' => 'nullable|string',
            'state.pan_vat_number'         => 'nullable|string',
            'state.pan_vat_date_text'      => 'nullable|string',
            'state.stats_count'            => 'nullable|string',
            'state.stats_label'            => 'nullable|string',
            'state.button_text'            => 'required|string',
            'state.button_url'             => 'required|string',
            'banner_file'                  => 'nullable|image|max:3072'
        ]);

        try {
            DB::transaction(function () {
                $data = $this->state;
                if ($this->banner_file) {
                    $data['banner_file'] = $this->banner_file->getRealPath();
                }

                $this->repository->updateSettings($data);

                if ($this->shouldDeleteBanner && !$this->banner_file) {
                    $this->repository->getSettings()->clearMediaCollection('about_banner');
                }
            });

            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'About metrics stored!']);
            $this->loadSettings();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to store page updates.']);
        }
    }

    public function openHighlightModal(?int $id = null)
    {
        $this->resetHighlightFields();

        if ($id) {
            $this->isHighlightEdit = true;
            $this->highlightId = $id;

            try {
                // Fixed: Utilizing the interface contract wrapper layers safely
                $highlight = $this->repository->getHighlightById($id);

                $this->h_title = $highlight->title;
                $this->h_description = $highlight->description;
                $this->h_sort_order = $highlight->sort_order;
                $this->h_is_active = $highlight->is_active;
                $this->existingHIcon = $highlight->getFirstMediaUrl('highlight_icon');
            } catch (\Exception $e) {
                $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not find highlight record.']);
                return;
            }
        }

        Flux::modal('highlightModal')->show();
    }

    public function saveHighlight()
    {
        $this->validate([
            'h_title'       => 'required|string|max:255',
            'h_description' => 'required|string',
            'h_sort_order'  => 'required|integer',
            'h_icon'        => 'nullable|image|max:1024'
        ]);

        try {
            DB::transaction(function () {
                $data = [
                    'title'       => $this->h_title,
                    'description' => $this->h_description,
                    'sort_order'  => $this->h_sort_order,
                    'is_active'   => $this->h_is_active,
                ];

                if ($this->h_icon) {
                    $data['icon_file'] = $this->h_icon->getRealPath();
                }

                $highlight = $this->repository->saveHighlight($data, $this->highlightId);

                if ($this->shouldDeleteHIcon && !$this->h_icon) {
                    $highlight->clearMediaCollection('highlight_icon');
                }
            });

            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Highlight block saved!']);
            Flux::modal('highlightModal')->close();
            $this->resetHighlightFields();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to save highlight element.']);
        }
    }
    public function deleteHighlight(int $id){
        $this->highlightId = $id;
        $this->dispatch('confirm_delete', ['for' => 'Highlights']);

    }
    #[On('deleteActionHighlights')]
    public function destroy()
    {
        try {
            $this->repository->deleteHighlight($this->highlightId);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Item removed successfully!']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not drop entity records.']);
        }
    }

    public function resetHighlightFields()
    {
        $this->reset(['highlightId', 'isHighlightEdit', 'h_title', 'h_description', 'h_sort_order', 'h_is_active', 'h_icon', 'existingHIcon', 'shouldDeleteHIcon']);
    }

    public function render()
    {
        return view('livewire.admin.about-manager', [
            'highlights' => $this->repository->getAllHighlights()
        ]);
    }
}
