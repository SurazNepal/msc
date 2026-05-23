<?php

namespace App\Livewire\Admin;

use App\Models\Admin\Service;
use App\Interfaces\FooterRepositoryInterface;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Validate;
use Livewire\Component;

class FooterNavigations extends Component
{
    protected FooterRepositoryInterface $repository;

    #[Validate('required|string|max:255')]
    public $heading = '';

    public array $selectedPages = [];
    public bool $isEditHeading = false;
    public bool $isEditContent = false;
    public $footer_id = null;
    public $oldHeading;

    public array $pages = [];

    protected $listeners = [
        'deleteActionHeading',
        'deleteActionContent',
    ];

    public function boot(FooterRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function mount()
    {
        $services = Service::all()->map(fn($service) => (object)[
            'id'    => $service->id,
            'title' => $service->title . ' (Service)',
            'type'  => 'service_page',
            'value' => 'service_page:' . $service->id,
        ]);

        $staticOptions = collect([
            ['id' => 0, 'title' => 'About Us (Static)', 'type' => 'about_us', 'value' => 'about_us:0'],
            ['id' => 0, 'title' => 'Contact Us (Static)', 'type' => 'contact_us', 'value' => 'contact_us:0'],
            ['id' => 0, 'title' => 'Events (Static)', 'type' => 'events', 'value' => 'events:0'],
            ['id' => 0, 'title' => 'Portfolio (Static)', 'type' => 'portfolio', 'value' => 'portfolio:0'],
            ['id' => 0, 'title' => 'Testimonials (Static)', 'type' => 'testimonials', 'value' => 'testimonials:0'],
            ['id' => 0, 'title' => 'Team (Static)', 'type' => 'team', 'value' => 'team:0'],
        ]);

        $this->pages = collect($services)
            ->merge($staticOptions)
            ->map(fn($item) => (array) $item)
            ->toArray();
    }

    public function showFooterNavigationModal()
    {
        $this->resetValidation();
        $this->reset(['heading', 'isEditHeading']);
        Flux::modal('addFooterHeadingModal')->show();
    }

    public function storeHeading()
    {
        $this->validateOnly('heading');

        try {
            $this->repository->storeHeading($this->heading);
            $this->reset(['heading', 'selectedPages']);
            Flux::modal('addFooterHeadingModal')->close();
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Footer column heading saved successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not save section column heading.']);
        }
    }

    public function editHeading($heading)
    {
        $this->resetValidation();
        $this->oldHeading = $heading;
        $this->heading = $heading;
        $this->isEditHeading = true;
        Flux::modal('addFooterHeadingModal')->show();
    }

    public function updateHeading()
    {
        $this->validateOnly('heading');

        try {
            $this->repository->updateHeadings($this->oldHeading, $this->heading);
            Flux::modal('addFooterHeadingModal')->close();
            $this->isEditHeading = false;
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Column header updated successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to adjust column structure details.']);
        }
    }

    public function destroyHeading($heading)
    {
        $this->heading = $heading;
        $this->dispatch('confirm_delete', ['for' => 'Heading']);
    }

    public function deleteActionHeading()
    {
        try {
            $this->repository->deleteHeading($this->heading);
            $this->reset(['heading', 'selectedPages']);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Footer header group purged.']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to wipe layout structure mappings.']);
        }
    }

    public function ShowContentModal($heading)
    {
        $this->heading = $heading;
        $this->selectedPages = [];
        $this->isEditContent = false;
        Flux::modal('addFooterContentModal')->show();
    }

    public function storeContent()
    {
        if (empty($this->selectedPages)) {
            $this->dispatch('swalToast', ['icon' => 'warning', 'message' => 'Please select at least one page link element.']);
            return;
        }

        try {
            foreach ($this->selectedPages as $pageString) {
                if (!str_contains($pageString, ':')) continue;

                [$type, $related_id] = explode(':', $pageString);
                $relatedIdArray = ["$type:$related_id"];

                $exists = $this->repository->checkExists($this->heading, $type, $relatedIdArray);

                if (!$exists) {
                    $this->repository->createContent([
                        'heading'    => $this->heading,
                        'type'       => $type,
                        'related_id' => $relatedIdArray,
                    ]);
                }
            }

            $this->reset(['heading', 'selectedPages']);
            Flux::modal('addFooterContentModal')->close();
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Assigned navigation links saved.']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to bundle subcollection page assets.']);
        }
    }

    public function editContent($id)
    {
        try {
            $entry = $this->repository->find($id);
            $this->heading = $entry->heading;
            $this->selectedPages = [];

            if (is_array($entry->related_id) && count($entry->related_id) > 0) {
                $this->selectedPages[] = $entry->related_id[0];
            }

            $this->footer_id = $entry->id;
            $this->isEditContent = true;
            Flux::modal('addFooterContentModal')->show();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not reference targeted mapping trace ID.']);
        }
    }

    public function updateContent()
    {
        try {
            $entry = $this->repository->find($this->footer_id);
            $entry->delete();

            foreach ($this->selectedPages as $pageString) {
                [$type, $related_id] = explode(':', $pageString);
                $relatedIdArray = ["$type:$related_id"];

                $this->repository->createContent([
                    'heading'    => $this->heading,
                    'type'       => $type,
                    'related_id' => $relatedIdArray,
                ]);
            }

            $this->resetData();
            $this->isEditContent = false;
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Content lin structural modifications updated.']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to overwrite selected dynamic node parameters.']);
        }
    }

    public function destroyContent($id)
    {
        $this->footer_id = $id;
        $this->dispatch('confirm_delete', ['for' => 'Content']);
    }

    public function deleteActionContent()
    {
        try {
            $this->repository->deleteContent($this->footer_id);
            $this->reset(['footer_id']);
            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Content removed from column module.']);
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Could not isolate reference structural node to discard.']);
        }
    }

    public function resetData()
    {
        $this->reset(['heading', 'footer_id', 'selectedPages', 'oldHeading', 'isEditHeading', 'isEditContent']);
        Flux::modals()->close();
    }

    public function render()
    {
        return view('livewire.admin.footer-navigations', [
            'footerGroups' => collect($this->repository->getAll())->groupBy('heading'),
        ]);
    }
}
