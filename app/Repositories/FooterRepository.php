<?php

namespace App\Repositories;

use App\Models\Admin\FooterNavigation;
use App\Interfaces\FooterRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FooterRepository implements FooterRepositoryInterface
{
    public function getAll()
    {
        return FooterNavigation::all();
    }

    public function storeHeading(string $heading)
    {
        return DB::transaction(function () use ($heading) {
            return FooterNavigation::create([
                'heading' => Str::upper($heading),
            ]);
        });
    }

    public function updateHeadings(string $oldHeading, string $newHeading)
    {
        return DB::transaction(function () use ($oldHeading, $newHeading) {
            $entries = FooterNavigation::where('heading', $oldHeading)->get();
            foreach ($entries as $entry) {
                $entry->update(['heading' => Str::upper($newHeading)]);
            }
        });
    }

    public function deleteHeading(string $heading)
    {
        return DB::transaction(function () use ($heading) {
            return FooterNavigation::where('heading', $heading)->delete();
        });
    }

    public function find(int $id)
    {
        return FooterNavigation::findOrFail($id);
    }

    public function checkExists(string $heading, string $type, array $relatedIdArray)
    {
        return FooterNavigation::where('heading', Str::upper($heading))
            ->where('type', $type)
            ->where('related_id', json_encode($relatedIdArray))
            ->exists();
    }

    public function createContent(array $data)
    {
        return DB::transaction(function () use ($data) {
            return FooterNavigation::create([
                'heading'    => Str::upper($data['heading']),
                'type'       => $data['type'],
                'related_id' => $data['related_id'],
            ]);
        });
    }

    public function deleteContent(int $id)
    {
        return DB::transaction(function () use ($id) {
            $entry = $this->find($id);
            return $entry->delete();
        });
    }
}
