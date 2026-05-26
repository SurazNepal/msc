<?php

namespace App\Livewire\Pages\Services;

use App\Models\Admin\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;
use DOMDocument;

#[Layout('layouts.guest.main', ['title' => 'Our Services Page', 'withFilters' => false, 'breadcrumbs' => ''])]
class ServicesPage extends Component
{
    public function render()
    {
        $services = Service::Published()->oldest()->get();


        $processedServices = $services->map(function ($service, $index) {
            $description = $service->description;
            $extractedItems = [];

            if (!empty($description)) {
                // Prevent errors on empty or invalid html structures
                libxml_use_internal_errors(true);
                $dom = new DOMDocument();
                // Load HTML with UTF-8 encoding wrapper to prevent character distortion
                $dom->loadHTML('<?xml encoding="utf-8" ?>' . $description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                // Track nodes to safely strip out from raw body after collection
                $nodesToRemove = [];

                // Extract items from unordered lists (ul)
                foreach ($dom->getElementsByTagName('ul') as $ul) {
                    foreach ($ul->getElementsByTagName('li') as $li) {
                        $extractedItems[] = trim($li->nodeValue);
                    }
                    $nodesToRemove[] = $ul;
                }

                // Extract items from ordered lists (ol)
                foreach ($dom->getElementsByTagName('ol') as $ol) {
                    $counter = 1;
                    foreach ($ol->getElementsByTagName('li') as $li) {
                        $extractedItems[] = $counter . ') ' . trim($li->nodeValue);
                        $counter++;
                    }
                    $nodesToRemove[] = $ol;
                }

                // Strip collected list blocks entirely from description output
                foreach ($nodesToRemove as $node) {
                    if ($node->parentNode) {
                        $node->parentNode->removeChild($node);
                    }
                }

                $description = $dom->saveHTML();
                libxml_clear_errors();
            }

            return [
                'id' => $service->id,
                'slug' => $service->slug,
                'title' => $service->title,
                'description' => $description,
                'items' => $extractedItems,
                'icon' => $service->getFirstMediaUrl('icon') ?: null,
                'index_label' => sprintf('%02d', $index + 1),
            ];
        });

        // Split lists for structural presentation logic: First 2 prominent, rest layout inside a bottom grid
        $featuredServices = $processedServices->take(2);
        $additionalServices = $processedServices->slice(2);

        return view('livewire.pages.services.services-page', [
            'featuredServices' => $featuredServices,
            'additionalServices' => $additionalServices,
        ]);
    }
}
