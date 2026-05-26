<?php

namespace App\Repositories;

use App\Interfaces\SocialMediaRepositoryInterface;
use App\Models\Admin\SocialMedia;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SocialMediaRepository implements SocialMediaRepositoryInterface
{
    public function all(): Collection
    {
        return SocialMedia::oldest('name')->get();
    }

    public function find(int $id): ?SocialMedia
    {
        return SocialMedia::find($id);
    }

    public function store(array $payload): SocialMedia
    {
        return DB::transaction(function () use ($payload) {
            return SocialMedia::create($payload);
        });
    }

    public function update(int $id, array $payload): bool
    {
        return DB::transaction(function () use ($id, $payload) {
            $record = SocialMedia::findOrFail($id);
            return $record->update($payload);
        });
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $record = SocialMedia::findOrFail($id);
            return $record->delete();
        });
    }
}
