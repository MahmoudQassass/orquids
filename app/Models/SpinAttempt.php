<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SpinAttempt extends Model
{
    protected $fillable = [
        'spin_prize_id',
        'visitor_token',
        'coupon_code',
        'is_used',
        'used_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'used_at' => 'datetime',
    ];

    public function prize()
    {
        return $this->belongsTo(
            SpinPrize::class,
            'spin_prize_id'
        );
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }
}
