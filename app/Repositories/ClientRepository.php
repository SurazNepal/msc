<?php

namespace App\Repositories;

use App\Interfaces\ClientRepositoryInterface;
use App\Models\Admin\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class ClientRepository implements ClientRepositoryInterface
{
    public function getPaginatedClients(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return Client::where('full_name', 'like', '%' . trim($search) . '%')
            ->latest()
            ->paginate($perPage);
    }

    public function getAllClients(): Collection
    {
        return Client::latest()->get();
    }

    public function getClientById(int $clientId): Client
    {
        return Client::findOrFail($clientId);
    }

    public function createClient(array $data): Client
    {
        try {
            return DB::transaction(function () use ($data) {
                $client = Client::create([
                    'full_name'        => $data['full_name'],
                    'website_url' => $data['website_url'] ?? null,
                    'status'      => $data['status'],
                ]);

                if (!empty($data['thumbnail'])) {
                    $client->addMedia($data['thumbnail'])
                        ->toMediaCollection('client_logo');
                }

                return $client;
            });
        } catch (Exception $e) {
            Log::error('Client Creation Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateClient(int $clientId, array $data): Client
    {
        try {
            return DB::transaction(function () use ($clientId, $data) {
                $client = $this->getClientById($clientId);

                $client->update([
                    'full_name'        => $data['full_name'],
                    'website_url' => $data['website_url'] ?? null,
                    'status'      => $data['status'],
                ]);

                if (array_key_exists('thumbnail', $data) && !empty($data['thumbnail'])) {
                    $client->addMedia($data['thumbnail'])
                        ->toMediaCollection('client_logo');
                }

                return $client;
            });
        } catch (Exception $e) {
            Log::error("Client Update Failed for ID {$clientId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteClient(int $clientId): bool
    {
        try {
            return DB::transaction(function () use ($clientId) {
                $client = $this->getClientById($clientId);
                $client->clearMediaCollection('client_logo');
                return (bool) $client->delete();
            });
        } catch (Exception $e) {
            Log::error("Client Deletion Failed for ID {$clientId}: " . $e->getMessage());
            throw $e;
        }
    }
}
