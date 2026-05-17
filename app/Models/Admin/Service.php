<?php

namespace App\Models\Admin;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia ;
    protected $fillable=['title','description','status'];

    /**
     * Define the collection and ensure single file automatic replacement
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('icon')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'])
            ->singleFile();
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
