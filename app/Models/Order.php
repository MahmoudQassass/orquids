<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'user_id',
        'payment_token',
        'customer_name',
        'phone',
        'email',
        'country',
        'city',
        'address',
        'quantity',
        'subtotal',
        'total',
        'payment_status',
        'payment_reference',
    ];

     protected $casts = [
        'quantity' => 'integer',
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
