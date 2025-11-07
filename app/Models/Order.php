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
        'status',
        'total_amount',
    ];

    // ✅ Relationship to Admin (User)
    public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}

}
