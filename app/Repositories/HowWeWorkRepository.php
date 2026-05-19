<?php

namespace App\Repositories;

use App\Models\Admin\HowWeWork;
use App\Interfaces\HowWeWorkRepositoryInterface;
use Illuminate\Support\Facades\DB;

class HowWeWorkRepository implements HowWeWorkRepositoryInterface
{
    public function getPaginatedSteps(string $search, int $perPage)
    {
        return HowWeWork::query()
            ->where('title', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('step', 'like', "%{$search}%")
            ->orderBy('step', 'asc')
            ->paginate($perPage);
    }

    public function getStepById(int $id)
    {
        return HowWeWork::findOrFail($id);
    }

    public function createStep(array $data)
    {
        return DB::transaction(function () use ($data) {
            $step = HowWeWork::create([
                'step'        => $data['step'],
                'title'       => $data['title'],
                'description' => $data['description'],
                'status'      => $data['status'],
            ]);

            if (!empty($data['icon'])) {
                $step->addMedia($data['icon'])->toMediaCollection('work_icon');
            }

            return $step;
        });
    }

    public function updateStep(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $step = $this->getStepById($id);

            $step->update([
                'step'        => $data['step'],
                'title'       => $data['title'],
                'description' => $data['description'],
                'status'      => $data['status'],
            ]);

            if (!empty($data['icon'])) {
                $step->addMedia($data['icon'])->toMediaCollection('work_icon');
            }

            return $step;
        });
    }

    public function deleteStep(int $id)
    {
        return DB::transaction(function () use ($id) {
            $step = $this->getStepById($id);
            $step->clearMediaCollection('work_icon');
            return $step->delete();
        });
    }
}
