<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Service;

class FooterNavigation extends Model
{
    protected $table = 'footer_navigations';
    protected $fillable = ['heading', 'related_id', 'type'];

    protected $casts = [
        'related_id' => 'array',
    ];

    public function getRelatedAttribute()
    {
        if (!is_array($this->related_id)) {
            return collect();
        }

        return collect($this->related_id)
            ->map(function ($entry) {
                if (!str_contains($entry, ':')) {
                    return null;
                }

                [$type, $id] = explode(':', $entry);

                // Dynamic Service Pages resolution logic block
                if ($type === 'service_page') {
                    $service = Service::find($id);
                    if (!$service) return null;
                    return $this->makeObject($service->title, route('services', $service->id));
                }

                // Explicit Static System Pages route map resolution
                return match ($type) {
                    // 'about_us'     => $this->maeObject('About Us', route('about-us')),
                    // 'contact_us'   => $this->maeObject('Contact Us', route('contact-us')), // Change to your exact contact route
                    'events'       => $this->makeObject('Events', route('portfolio-event')),   // Change to your exact events route
                    // 'testimonials' => $this->makeObject('Testimonials', route('testimonial-page')),
                    'team'         => $this->makeObject('Team', route('teams')),
                    default        => null,
                };
            })
            ->filter()
            ->values();
    }

    private function makeObject($title, $route)
    {
        return (object)[
            'title' => $title ?? 'Untitled',
            'route' => $route,
        ];
    }
}
