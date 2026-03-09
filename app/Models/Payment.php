<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'total_price',
        'cash',
        'change'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}