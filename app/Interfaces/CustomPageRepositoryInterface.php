<?php

namespace App\Interfaces;

interface CustomPageRepositoryInterface
{
    public function getPaginatedPages(string $search, int $perPage);

    public function getPageBySlug(string $slug);

    public function createPage(array $data);

    public function updatePage(int $id, array $data);

    public function deletePage(int $id);
}
