<?php

namespace App\Repositories;

use App\Interfaces\ServiceRepositoryInterface;
use App\Models\Admin\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Override;

class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * Search, Filter, and Paginate services safely
     */
    public function getPaginatedServices(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return Service::with('media')
            ->when(!empty($search), function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%' . $search . '%')
                             ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate($perPage);
    }
    public function getAllServices(): Collection
    {
        return Service::with('media')->latest()->get();
    }

    public function getServiceById(int $serviceId): Service
    {
        return Service::findOrFail($serviceId);
    }
    public function createService(array $serviceDetails): Service
    {
        return DB::transaction(function () use ($serviceDetails) {
            $service = Service::create([
                'title'       => $serviceDetails['title'],
                'description' => $serviceDetails['description'],
                'status'      => $serviceDetails['status'] ?? 'active',
            ]);

            if (!empty($serviceDetails['icon'])) {
                $service->addMedia($serviceDetails['icon'])
                    ->toMediaCollection('icon');
            }

            return $service;
        });
    }

    #[Override]
    public function updateService(int $serviceId, array $data): Service
    {
        return DB::transaction(function () use ($serviceId, $data) {
            $service = $this->getServiceById($serviceId);

            $service->update([
                'title'       => $data['title'],
                'description' => $data['description'],
                'status'      => $data['status'] ?? 'active',
            ]);

            if (!empty($data['icon'])) {
                $service->addMedia($data['icon'])
                    ->toMediaCollection('icon');
            }

            return $service;
        });
    }

    public function deleteService(int $serviceId): bool
    {
        return DB::transaction(function () use ($serviceId) {
            return $this->getServiceById($serviceId)->delete();
        });
    }


}
