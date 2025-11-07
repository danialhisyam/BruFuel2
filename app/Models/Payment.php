<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    
    protected $fillable = ['order_id', 'customer_name','provider','status','amount','paid_at'];
    
    protected $casts = [
        'paid_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    /**
     * Relationship to Order
     */
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id');
    }
}
