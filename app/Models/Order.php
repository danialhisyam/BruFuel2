<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'user_id',
        'driver_id',
        'status',
        'total_amount',
        'fuel_type',
        'delivery_address',
        'license_plate',
        'vehicle_type',
        'vehicle_make',
        'vehicle_model',
        'vehicle_color',
        'payment_method',
        'payment_ref_number',
    ];

    // ✅ Relationship to User (Customer)
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // ✅ Relationship to Driver
    public function driver()
    {
        return $this->belongsTo(\App\Models\Driver::class, 'driver_id');
    }

    // ✅ Relationship to Payment
    public function payment()
    {
        return $this->hasOne(\App\Models\Payment::class, 'order_id');
    }
}
