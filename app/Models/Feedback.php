<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $fillable = [
        'name',
        'institution',
        'contact',
        'message',
        'attachment',
        'willing_to_contact',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'willing_to_contact' => 'boolean',
            'is_read' => 'boolean',
        ];
    }
}
