<?php

namespace App\Repositories;

use App\Interfaces\CustomPageRepositoryInterface;
use App\Models\Admin\CustomPage;
use Illuminate\Support\Facades\DB;

class CustomPageRepository implements CustomPageRepositoryInterface
{
    public function getPaginatedPages(string $search, int $perPage)
    {
        return CustomPage::query()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage);
    }

    public function getPageBySlug(string $slug)
    {
        return CustomPage::where('slug', $slug)->first();
    }

    public function createPage(array $data)
    {
        return DB::transaction(function () use ($data) {
            $page = CustomPage::create([
                'title'   => $data['title'],
                'content' => $data['content'] ?? null,
                'status'  => $data['status'] ?? 'Published',
            ]);

            if (!empty($data['featured_image'])) {
                $page->addMedia($data['featured_image'])
                     ->toMediaCollection('featured_images');
            }

            return $page;
        });
    }

    public function updatePage(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $page = CustomPage::findOrFail($id);

            $page->update([
                'title'   => $data['title'],
                'content' => $data['content'] ?? null,
                'status'  => $data['status'] ?? 'Published',
            ]);

            if (!empty($data['featured_image'])) {
                $page->clearMediaCollection('featured_images');
                $page->addMedia($data['featured_image'])
                     ->toMediaCollection('featured_images');
            }

            return $page;
        });
    }

    public function deletePage(int $id)
    {
        return DB::transaction(function () use ($id) {
            $page = CustomPage::findOrFail($id);
            return $page->delete();
        });
    }
}
