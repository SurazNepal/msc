<?php

namespace App\Interfaces;

interface FooterRepositoryInterface
{
    public function getAll();
    public function storeHeading(string $heading);
    public function updateHeadings(string $oldHeading, string $newHeading);
    public function deleteHeading(string $heading);

    public function find(int $id);
    public function checkExists(string $heading, string $type, array $relatedIdArray);
    public function createContent(array $data);
    public function deleteContent(int $id);
}
