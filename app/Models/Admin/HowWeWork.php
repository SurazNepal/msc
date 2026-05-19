<?php

namespace App\Models\Admin;

use App\Enums\WorkStepEnum;
use App\Enums\WorkStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HowWeWork extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'step',
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'step'   => WorkStepEnum::class,
        'status' => WorkStatusEnum::class,
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('work_icon')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
       $this->addMediaConversion('thumb')->width(100)->nonQueued();
        $this->addMediaConversion('small')->width(480)->nonQueued();
        $this->addMediaConversion('large')->width(1200)->nonQueued();
    }
}
