<?php

namespace App\Repositories;

use App\Interfaces\TeamRepositoryInterface;
use App\Models\Admin\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class TeamRepository implements TeamRepositoryInterface
{
    public function getPaginatedTeams(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return Team::where('full_name', 'like', '%' . trim($search) . '%')
            ->orWhere('job_post', 'like', '%' . trim($search) . '%')
            ->latest()
            ->paginate($perPage);
    }

    public function getAllTeams(): Collection
    {
        return Team::latest()->get();
    }

    public function getTeamById(int $teamId): Team
    {
        return Team::findOrFail($teamId);
    }

    public function createTeam(array $data): Team
    {
        try {
            return DB::transaction(function () use ($data) {
                $team = Team::create([
                    'full_name' => $data['full_name'],
                    'job_post'  => $data['job_post'],
                    'status'    => $data['status'],
                ]);

                if (!empty($data['thumbnail'])) {
                    $team->addMedia($data['thumbnail'])
                        ->toMediaCollection('team_image');
                }

                return $team;
            });
        } catch (Exception $e) {
            Log::error('Team Member Creation Failed: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateTeam(int $teamId, array $data): Team
    {
        try {
            return DB::transaction(function () use ($teamId, $data) {
                $team = $this->getTeamById($teamId);

                $team->update([
                    'full_name' => $data['full_name'],
                    'job_post'  => $data['job_post'],
                    'status'    => $data['status'],
                ]);

                if (array_key_exists('thumbnail', $data) && !empty($data['thumbnail'])) {
                    $team->addMedia($data['thumbnail'])
                        ->toMediaCollection('team_image');
                }

                return $team;
            });
        } catch (Exception $e) {
            Log::error("Team Member Update Failed for ID {$teamId}: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteTeam(int $teamId): bool
    {
        try {
            return DB::transaction(function () use ($teamId) {
                $team = $this->getTeamById($teamId);
                $team->clearMediaCollection('team_image');
                return (bool) $team->delete();
            });
        } catch (Exception $e) {
            Log::error("Team Member Deletion Failed for ID {$teamId}: " . $e->getMessage());
            throw $e;
        }
    }
}
