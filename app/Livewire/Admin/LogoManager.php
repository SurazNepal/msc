<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Interfaces\LogoRepositoryInterface;

class LogoManager extends Component
{
    use WithFileUploads;

    protected LogoRepositoryInterface $repository;

    public $logo_file;
    public $alt_text;
    public $existingLogoUrl;

    public function boot(LogoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function mount()
    {
        $this->loadLogoSettings();
    }

    public function loadLogoSettings()
    {
        $settings = $this->repository->getLogoSettings();
        $this->alt_text = $settings->alt_text;
        $this->existingLogoUrl = $settings->getFirstMediaUrl('site_logo');
        $this->logo_file = null; // Clear the temporary file upload input state
    }

    public function saveLogo()
    {
        $this->validate([
            'alt_text'  => 'required|string|max:255',
            'logo_file' => 'nullable|image|max:2048', // Max 2MB payload guard rails
        ]);

        try {
            $data = [
                'alt_text' => $this->alt_text,
            ];

            if ($this->logo_file) {
                $data['logo_file'] = $this->logo_file->getRealPath();
            }

            $this->repository->updateLogo($data);

            $this->dispatch('swalToast', ['icon' => 'success', 'message' => 'Logo asset updated successfully!']);
            $this->loadLogoSettings();
        } catch (\Exception $e) {
            $this->dispatch('swalToast', ['icon' => 'error', 'message' => 'Failed to save updated logo asset.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.logo-manager');
    }
}
