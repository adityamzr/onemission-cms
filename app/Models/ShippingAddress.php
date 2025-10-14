<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    protected $table = 'shipping_addresses';

    protected $fillable = [
        'order_id',
        'country',
        'province',
        'city',
        'district',
        'postal_code',
        'address'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
