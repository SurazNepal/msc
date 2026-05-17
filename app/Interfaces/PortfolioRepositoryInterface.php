<?php

namespace App\Interfaces;

use App\Models\Admin\PortfolioEvent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PortfolioRepositoryInterface
{
    public function getPaginatedPortfolioEvent(string $search = '', int $perPage = 10): LengthAwarePaginator;
    public function getAllEvents(): Collection;
    public function getEventById(int $eventId): PortfolioEvent;
    public function deleteEvent(int $eventId): bool;
    public function createEvent(array $data): PortfolioEvent;
    public function updateEvent(int $eventId, array $data): PortfolioEvent;
}
