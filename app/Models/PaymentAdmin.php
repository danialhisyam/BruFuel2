<?php
// app/Models/Payment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentAdmin extends Model
{
    protected $table = 'payments';     // change if different (e.g. transactions)
}
