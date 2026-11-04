<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPushSubscription extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['subscription' => 'encrypted:array'];
    }
}
