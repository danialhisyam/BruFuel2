<?php
<<<<<<< HEAD
=======
// app/Models/Payment.php
>>>>>>> origin/master
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAdmin extends Model
{
<<<<<<< HEAD
    protected $table = 'payments';
    
    protected $fillable = ['customer_name', 'provider', 'status', 'amount', 'paid_at'];
    
    protected $casts = ['paid_at' => 'datetime'];
=======
    protected $table = 'payments';     // change if different (e.g. transactions)
>>>>>>> origin/master
}
