<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $providers = ['BIBD','BAIDURI','TAP','CASH'];
        $statuses  = ['Paid','Pending','Fail'];

        for ($i=0; $i<50; $i++) {
            Payment::create([
                'customer_name' => fake()->name(),
                'provider' => $providers[array_rand($providers)],
                'status'   => $statuses[array_rand($statuses)],
                'amount'   => fake()->randomFloat(2, 20, 200),
                'paid_at'  => now()->subDays(rand(0,180)),
            ]);
        }
    }
}
