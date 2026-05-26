<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SocialMedia extends Model
{
    protected $table = 'social_media';

    protected $fillable = ['name', 'url'];
}
