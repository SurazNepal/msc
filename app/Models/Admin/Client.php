<?php

namespace App\Models\Admin;

use App\Enums\ClientStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Client extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['full_name', 'website_url', 'status'];

    protected $casts = [
        'status' => ClientStatusEnum::class,
    ];

    /**
     * Scope a query to only include published clients.
     */
    public function scopePublished(Builder $query): Builder
    {
        // Assumes your ClientStatusEnum has a value or case for PUBLISHED (e.g., ClientStatusEnum::PUBLISHED)
        return $query->where('status', ClientStatusEnum::PUBLISHED);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('client_logo')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/svg+xml', 'image/webp'])
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
       $this->addMediaConversion('thumb')->width(100)->nonQueued();
        $this->addMediaConversion('small')->width(480)->nonQueued();
        $this->addMediaConversion('large')->width(1200)->nonQueued();
    }
}
