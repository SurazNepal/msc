<?php

namespace App\Interfaces;

use App\Models\Admin\ContactSetting;

interface ContactRepositoryInterface
{
    /**
     * Fetch the persistent contact details row or return a fresh instance.
     *
     * @return ContactSetting
     */
    public function getSettings(): ContactSetting;

    /**
     * Persist or update the centralized contact entry.
     *
     * @param array $payload
     * @return ContactSetting
     */
    public function updateSettings(array $payload): ContactSetting;
}
