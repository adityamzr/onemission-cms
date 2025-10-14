<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'order_number',
        'status',
        'payment_status',
        'shipping_provider',
        'shipping_cost',
        'subtotal',
        'total_discount',
        'total_amount',
        'discount_id',
        'notes',
        'cancel_reason',
        'expires_at'
    ];

    protected $casts = [
        'shipping_address' => 'array',
        'order_items' => 'array',
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function shippingAddress()
    {
        return $this->hasOne(ShippingAddress::class, 'order_id');
    }
}
