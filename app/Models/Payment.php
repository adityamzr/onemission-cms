<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'payment_id',
        'payment_date',
        'payment_reference',
        'payment_proof',
        'payment_method',
        'payment_status',
        'refund_reason',
        'amount'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
