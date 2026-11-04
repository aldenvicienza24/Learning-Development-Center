<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Testimonial extends Model
{
    protected $fillable = [
        'program_id', 'registration_id', 'author_name', 'author_role', 
        'body', 'photos', 'comments', 'is_published', 
        'token', 'rating', 'status', 'is_submitted'
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean', 
            'photos' => 'array', 
            'comments' => 'array',
            'is_submitted' => 'boolean',
            'rating' => 'integer'
        ];
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }
}
