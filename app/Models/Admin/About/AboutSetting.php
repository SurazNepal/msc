<?php

namespace App\Models\Admin\About;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AboutSetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'badge_text', 'title', 'description_one', 'description_two',
        'registration_number', 'registration_date_text', 'pan_vat_number',
        'pan_vat_date_text', 'stats_count', 'stats_label', 'button_text', 'button_url'
    ];

    public function registerMediaCollections(): void
    {
        // Right-side prominent illustration graphic layout
        $this->addMediaCollection('about_banner')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp']);
    }
    public function registerMediaConversions(?Media $media = null): void
    {
       $this->addMediaConversion('thumb')->width(100)->nonQueued();
        $this->addMediaConversion('small')->width(480)->nonQueued();
        $this->addMediaConversion('large')->width(1200)->nonQueued();
    }
}
