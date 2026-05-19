<?php

namespace App\Interfaces;

interface HowWeWorkRepositoryInterface
{
    public function getPaginatedSteps(string $search, int $perPage);
    public function getStepById(int $id);
    public function createStep(array $data);
    public function updateStep(int $id, array $data);
    public function deleteStep(int $id);
}

