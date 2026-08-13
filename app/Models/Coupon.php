<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'discount_percent',
        'spin_attempt_id',
        'is_used',
        'order_id',
        'used_at',
        'expires_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'discount_percent' => 'decimal:2',
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function spinAttempt()
    {
        return $this->belongsTo(SpinAttempt::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * هل الكوبون منتهي؟
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expires_at !== null
            && $this->expires_at->isPast();
    }

    /**
     * هل الكوبون صالح للاستخدام؟
     */
    public function getIsValidAttribute(): bool
    {
        if ($this->is_used) {
            return false;
        }

        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        return true;
    }
}
