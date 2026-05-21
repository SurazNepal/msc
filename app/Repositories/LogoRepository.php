<?php

namespace App\Repositories;

use App\Models\Admin\LogoSetting;
use App\Interfaces\LogoRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LogoRepository implements LogoRepositoryInterface
{
    public function getLogoSettings()
    {
        // Always fall back to or instantiate the single first configuration record row
        return LogoSetting::firstOrCreate([], [
            'alt_text' => 'MSC'
        ]);
    }

    public function updateLogo(array $data)
    {
        return DB::transaction(function () use ($data) {
            $logoSetting = $this->getLogoSettings();
            $logoSetting->update([
                'alt_text' => $data['alt_text'] ?? $logoSetting->alt_text,
            ]);

            if (!empty($data['logo_file'])) {
                // Spatie singleFile() handles removing the previous image automatically
                $logoSetting->addMedia($data['logo_file'])->toMediaCollection('site_logo');
            }

            return $logoSetting;
        });
    }
}
