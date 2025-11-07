<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAdmin extends Model
{
    protected $table = 'payments';
    
    protected $fillable = ['customer_name', 'provider', 'status', 'amount', 'paid_at'];
    
    protected $casts = ['paid_at' => 'datetime'];
}
