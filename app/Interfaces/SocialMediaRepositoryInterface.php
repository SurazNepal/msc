<?php

namespace App\Interfaces;

use App\Models\Admin\SocialMedia;
use Illuminate\Database\Eloquent\Collection;

interface SocialMediaRepositoryInterface
{
    public function all(): Collection;
    public function find(int $id): ?SocialMedia;
    public function store(array $payload): SocialMedia;
    public function update(int $id, array $payload): bool;
    public function delete(int $id): bool;
}
