<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    protected $fillable = ['name', 'photo', 'description', 'cv', 'scopes'];

    protected $casts = [
        'scopes' => 'array',
    ];
}
