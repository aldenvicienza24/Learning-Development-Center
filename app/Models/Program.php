<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'title',
        'category',
        'faculty',
        'image_url',
        'registration_date',
        'price',
        'quota',
        'total_quota',
        'detail_url',
    ];
}
