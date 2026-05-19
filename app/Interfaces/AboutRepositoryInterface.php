<?php

namespace App\Interfaces;

interface AboutRepositoryInterface
{
    public function getSettings();
    public function updateSettings(array $data);

    public function getAllHighlights();
    public function getHighlightById(int $id);
    public function saveHighlight(array $data, ?int $id = null);
    public function deleteHighlight(int $id);
}
