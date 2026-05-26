<?php

namespace App\Models\Admin;

use App\Enums\TeamStatusEnum;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;


class Team extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $fillable = ['full_name','job_post','status'];
/**
     * Scope a query to only include published clients.
     */
    public function scopePublished(Builder $query): Builder
    {
        // Assumes your ClientStatusEnum has a value or case for PUBLISHED (e.g., ClientStatusEnum::PUBLISHED)
        return $query->where('status', TeamStatusEnum::PUBLISHED);
    }
/**
     * Define the collection and ensure single file automatic replacement
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('team_image')
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
