<?php

namespace App\Repositories;

use App\Interfaces\PortfolioRepositoryInterface;
use App\Models\Admin\PortfolioEvent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PortfolioRepository implements PortfolioRepositoryInterface
{
    public function getPaginatedPortfolioEvent(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return PortfolioEvent::where('title', 'like', '%' . trim($search) . '%')
            ->latest()
            ->paginate($perPage);
    }

    public function getAllEvents(): Collection
    {
        return PortfolioEvent::latest()->get();
    }

    public function getEventById(int $eventId): PortfolioEvent
    {
        return PortfolioEvent::findOrFail($eventId);
    }

    public function createEvent(array $data): PortfolioEvent
    {
        try {
            return DB::transaction(function () use ($data) {
                $event = PortfolioEvent::create([
                    'title'       => $data['title'],
                    'year'        => $data['year'] ?? null,
                    'tags'        => $data['tags'],
                    'description' => $data['description'] ?? null,
                    'status'      => $data['status'],
                ]);

                if (!empty($data['thumbnail'])) {
                    $event->addMedia($data['thumbnail'])
                        ->toMediaCollection('portfolio_image');
                }

                return $event;
            });
        } catch (Exception $e) {
            Log::error('PortfolioEvent Creation Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateEvent(int $eventId, array $data): PortfolioEvent
    {
        try {
            return DB::transaction(function () use ($eventId, $data) {
                $event = $this->getEventById($eventId);

                $event->update([
                    'title'       => $data['title'],
                    'year'        => $data['year'] ?? null,
                    'tags'        => $data['tags'],
                    'description' => $data['description'] ?? null,
                    'status'      => $data['status'],
                ]);

                if (array_key_exists('thumbnail', $data) && !empty($data['thumbnail'])) {
                    $event->addMedia($data['thumbnail'])
                        ->toMediaCollection('portfolio_image');
                }

                return $event;
            });
        } catch (Exception $e) {
            Log::error("PortfolioEvent Update Failed for ID {$eventId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteEvent(int $eventId): bool
    {
        try {
            return DB::transaction(function () use ($eventId) {
                $event = $this->getEventById($eventId);
                $event->clearMediaCollection('portfolio_image');
                return (bool) $event->delete();
            });
        } catch (Exception $e) {
            Log::error("PortfolioEvent Deletion Failed for ID {$eventId}: " . $e->getMessage());
            throw $e;
        }
    }
}
