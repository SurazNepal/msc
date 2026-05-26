<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $table = 'contact_settings';

    protected $fillable = [
        'address',
        'phone',
        'email',
    ];
}
