<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'tax',
        'shipping_cost',
        'discount',
        'total',
        'status',
        'payment_method',
        'payment_status',
        'name',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
