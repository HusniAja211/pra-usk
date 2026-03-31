<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'total_price',
        'cash',
        'change',
        'proof',
        'payment_method',
        'status',
        'reject_reason',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}