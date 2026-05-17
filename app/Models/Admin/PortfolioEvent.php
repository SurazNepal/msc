<?php

namespace App\Models\Admin;

use App\Enums\PortfolioStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class PortfolioEvent extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = ['title', 'tags','description', 'year','status'];

    protected $casts = [
        'tags' => 'array', // Automatically serializes array arrays to JSON strings
        'status' => PortfolioStatusEnum::class,
    ];
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
}
