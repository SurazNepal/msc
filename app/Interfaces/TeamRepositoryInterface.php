<?php

namespace App\Interfaces;

use App\Models\Admin\Team;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TeamRepositoryInterface
{
    public function getPaginatedTeams(string $search = '', int $perPage = 10): LengthAwarePaginator;
    public function getAllTeams(): Collection;
    public function getTeamById(int $teamId): Team;
    public function deleteTeam(int $teamId): bool;
    public function createTeam(array $data): Team;
    public function updateTeam(int $teamId, array $data): Team;
}
