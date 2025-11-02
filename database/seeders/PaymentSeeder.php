<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        // Bulk fake data
        Payment::factory()->count(300)->create();

        // A few familiar rows like your UI examples
        $examples = [
            ['customer_name'=>'ADIB',            'provider'=>'BAIDURI','status'=>'Pending','amount'=>80.00, 'paid_at'=>now()->subDays(21)->setTime(17,53)],
            ['customer_name'=>'MOHAMMAD ALI',    'provider'=>'BIBD',   'status'=>'Paid',   'amount'=>40.00, 'paid_at'=>now()->subDays(21)->setTime(12,05)],
            ['customer_name'=>'IRYNA',           'provider'=>'TAB',    'status'=>'Paid',   'amount'=>26.00, 'paid_at'=>now()->subDays(22)->setTime(18,12)],
            ['customer_name'=>'NADEERAH',        'provider'=>'BAIDURI','status'=>'Fail',   'amount'=>30.00, 'paid_at'=>now()->subDays(23)->setTime(15,10)],
            ['customer_name'=>'AFIQ',            'provider'=>'CASH',   'status'=>'Paid',   'amount'=>20.00, 'paid_at'=>now()->subDays(24)->setTime(20,53)],
            ['customer_name'=>'FAIZ',            'provider'=>'TAB',    'status'=>'Paid',   'amount'=>30.00, 'paid_at'=>now()->subDays(24)->setTime(13,45)],
            ['customer_name'=>'SARAH',           'provider'=>'BIBD',   'status'=>'Fail',   'amount'=>20.00, 'paid_at'=>now()->subDays(25)->setTime(18,20)],
            ['customer_name'=>'MOHAMMAD SAFWAN', 'provider'=>'BIBD',   'status'=>'Paid',   'amount'=>40.00, 'paid_at'=>now()->subDays(26)->setTime(10,02)],
        ];
        foreach ($examples as $row) {
            Payment::create($row);
        }
    }
}
