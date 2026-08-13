<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpinPrize extends Model
{
    protected $fillable = [
        'name',
        'type',
        'discount_percent',
        'probability',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'discount_percent' => 'decimal:2',
        'probability' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
