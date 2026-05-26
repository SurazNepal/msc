<?php

namespace App\Repositories;

use App\Interfaces\ContactRepositoryInterface;
use App\Models\Admin\ContactSetting;
use Illuminate\Support\Facades\DB;

class ContactRepository implements ContactRepositoryInterface
{
    /**
     * Fetch the persistent contact details row.
     */
    public function getSettings(): ContactSetting
    {
        return ContactSetting::first() ?? new ContactSetting();
    }

    /**
     * Persist or update the centralized contact entry securely inside a transaction block.
     */
    public function updateSettings(array $payload): ContactSetting
    {
        // Executes the operations atomically; auto-commits on success, auto-rolls back on failure
        return DB::transaction(function () use ($payload) {
            $settings = ContactSetting::first() ?? new ContactSetting();
            $settings->fill($payload);
            $settings->save();

            return $settings;
        });
    }
}
