<?php

namespace App\Models\Admin;

use App\Enums\ServiceStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Service extends Model implements HasMedia
{
    use InteractsWithMedia ;
    protected $fillable=['title','slug','description','status'];

    protected $casts = [
    'status' => \App\Enums\ServiceStatusEnum::class, // <-- CRITICAL
];
/**
     * Scope a query to only include published clients.
     */
    public function scopePublished(Builder $query): Builder
    {
        // Assumes your ClientStatusEnum has a value or case for PUBLISHED (e.g., ClientStatusEnum::PUBLISHED)
        return $query->where('status', ServiceStatusEnum::PUBLISHED);
    }
/**
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
    /**
     * Auto-generate unique slugs whenever a Service is created or its title changes
     */
    protected static function booted(): void
    {
        static::saving(function ($service) {
            // Only generate or update slug if title is present and has changed
            if ($service->isDirty('title')) {
                $slug = Str::slug($service->title);

                // Ensure the slug is completely unique in the database
                $count = static::where('slug', 'LIKE', "{$slug}%")
                    ->where('id', '!=', $service->id ?? 0)
                    ->count();

                $service->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
            }
        });
    }
}
