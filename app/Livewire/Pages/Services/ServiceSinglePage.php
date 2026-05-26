<?php

namespace App\Livewire\Pages\Services;

use App\Models\Admin\Service;
use App\Enums\ServiceStatusEnum;
use Livewire\Attributes\Layout;
use Livewire\Component;
use DOMDocument;

#[Layout('layouts.guest.main', ['title' => 'Service Details', 'withFilters' => false, 'breadcrumbs' => ''])]
class ServiceSinglePage extends Component
{
    public Service $service;

    public function mount(Service $service)
    {
        // Fail early if the record isn't published
        if ($service->status !== ServiceStatusEnum::PUBLISHED) {
            abort(404);
        }

        $this->service = $service;
    }

    public function render()
    {
        $description = $this->service->description;
        $extractedItems = [];

        if (!empty($description)) {
            libxml_use_internal_errors(true);
            $dom = new DOMDocument();
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $nodesToRemove = [];

            foreach ($dom->getElementsByTagName('ul') as $ul) {
                foreach ($ul->getElementsByTagName('li') as $li) {
                    $extractedItems[] = trim($li->nodeValue);
                }
                $nodesToRemove[] = $ul;
            }

            foreach ($dom->getElementsByTagName('ol') as $ol) {
                $counter = 1;
                foreach ($ol->getElementsByTagName('li') as $li) {
                    $extractedItems[] = $counter . ') ' . trim($li->nodeValue);
                    $counter++;
                }
                $nodesToRemove[] = $ol;
            }

            foreach ($nodesToRemove as $node) {
                if ($node->parentNode) {
                    $node->parentNode->removeChild($node);
                }
            }

            $description = $dom->saveHTML();
            libxml_clear_errors();
        }

        return view('livewire.pages.services.service-single-page', [
            'htmlContent' => $description,
            'features' => $extractedItems,
            'icon' => $this->service->getFirstMediaUrl('icon') ?: null
        ]);
    }
}
