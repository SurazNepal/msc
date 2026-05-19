<?php

namespace App\Repositories;

use App\Models\Admin\About\AboutSetting;
use App\Models\Admin\About\AboutHighlight;
use App\Interfaces\AboutRepositoryInterface;
use Illuminate\Support\Facades\DB;

class AboutRepository implements AboutRepositoryInterface
{
    public function getSettings()
    {
        return AboutSetting::firstOrCreate([], [
            'badge_text'             => 'About Mind Share Connect',
            'title'                  => 'Who We Are & What We Do',
            'description_one'        => 'Mind Share Connect is a fully integrated Marketing services company...',
            'description_two'        => 'We work through strategic ideas and innovative approaches...',
            'registration_number'    => 'Reg. No: 81657/067/68',
            'registration_date_text' => 'Est. 20 March 2011',
            'pan_vat_number'         => 'Reg. No: 304957020',
            'pan_vat_date_text'      => 'Registered 2067 B.S.',
            'stats_count'            => '16+',
            'stats_label'            => 'Partner Organisations',
        ]);
    }

    public function updateSettings(array $data)
    {
        return DB::transaction(function () use ($data) {
            $settings = $this->getSettings();
            $settings->update($data);

            if (!empty($data['banner_file'])) {
                $settings->addMedia($data['banner_file'])->toMediaCollection('about_banner');
            }

            return $settings;
        });
    }

    public function getAllHighlights()
    {
        return AboutHighlight::orderBy('sort_order', 'asc')->get();
    }

    public function getHighlightById(int $id)
    {
        return AboutHighlight::findOrFail($id);
    }

    public function saveHighlight(array $data, ?int $id = null)
    {
        return DB::transaction(function () use ($data, $id) {
            $highlight = $id ? AboutHighlight::findOrFail($id) : new AboutHighlight();

            $highlight->fill([
                'title'       => $data['title'],
                'description' => $data['description'],
                'sort_order'  => $data['sort_order'] ?? 0,
                'is_active'   => $data['is_active'] ?? true,
            ])->save();

            if (!empty($data['icon_file'])) {
                $highlight->addMedia($data['icon_file'])->toMediaCollection('highlight_icon');
            }

            return $highlight;
        });
    }

    public function deleteHighlight(int $id)
    {
        return DB::transaction(function () use ($id) {
            $highlight = AboutHighlight::findOrFail($id);
            $highlight->clearMediaCollection('highlight_icon');
            return $highlight->delete();
        });
    }
}
