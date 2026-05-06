<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'order_id',
        'payment_id',
        'method',
        'amount',
        'status',
        'response',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
