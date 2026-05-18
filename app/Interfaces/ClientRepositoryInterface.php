<?php

namespace App\Interfaces;

use App\Models\Admin\Client;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface ClientRepositoryInterface
{
    public function getPaginatedClients(string $search = '', int $perPage = 10): LengthAwarePaginator;
    public function getAllClients(): Collection;
    public function getClientById(int $clientId): Client;
    public function deleteClient(int $clientId): bool;
    public function createClient(array $data): Client;
    public function updateClient(int $clientId, array $data): Client;
}
