<?php

namespace App\Interfaces;

use App\Models\Admin\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ServiceRepositoryInterface
{
    public function getPaginatedServices(string $search = '', int $perPage = 10): LengthAwarePaginator;
    public function getAllServices(): Collection;
    public function getServiceById(int $serviceId): Service;
    public function getServiceBySlug(string $slug): Service;
    public function deleteService(int $serviceId): bool;
    public function createService(array $data): Service;
    public function updateService(int $serviceId, array $data): Service;
}
