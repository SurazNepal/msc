<?php

namespace App\Models\Admin;

use App\Enums\PortfolioStatusEnum;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PortfolioEvent extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['title', 'slug', 'tags','description', 'year','status'];

    protected $casts = [
        'tags' => 'array', // Automatically serializes array arrays to JSON strings
        'status' => PortfolioStatusEnum::class,
    ];
/**
     * Scope a query to only include published clients.
     */
    public function scopePublished(Builder $query): Builder
    {
        // Assumes your ClientStatusEnum has a value or case for PUBLISHED (e.g., ClientStatusEnum::PUBLISHED)
        return $query->where('status', PortfolioStatusEnum::PUBLISHED);
    }
/**
     * Define the collection and ensure single file automatic replacement
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('portfolio_image')
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
    protected static function booted(): void
    {
        static::saving(function ($portfolioEvent) {
            // Only generate or update slug if title is present and has changed
            if ($portfolioEvent->isDirty('title')) {
                $slug = Str::slug($portfolioEvent->title);

                // Ensure the slug is completely unique in the database
                $count = static::where('slug', 'LIKE', "{$slug}%")
                    ->where('id', '!=', $portfolioEvent->id ?? 0)
                    ->count();

                $portfolioEvent->slug = $count > 0 ? "{$slug}-{$count}" : $slug;
            }
        });
    }
}
