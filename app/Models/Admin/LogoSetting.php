<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class LogoSetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $table = 'logo_settings';
    protected $fillable = ['alt_text'];

    public function registerMediaCollections(): void
    {
        // Enforces that only one file exists in this collection at any time
        $this->addMediaCollection('site_logo') ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp']);
    }
    /**
     * Register conversions and process them synchronously (no queues)
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->width(100)->nonQueued();
        $this->addMediaConversion('small')->width(480)->nonQueued();
        $this->addMediaConversion('large')->width(1200)->nonQueued();
    }
}
