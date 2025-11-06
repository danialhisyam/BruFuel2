<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentAdmin as Payment;   // <-- use your actual model
use Illuminate\Support\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $providers = ['BIBD','BAIDURI','TAP','CASH'];
        $statuses  = ['Paid','Pending','Failed']; // 'Failed' instead of 'Fail'

        // optional: clear old demo data
        // \DB::table('payments')->truncate();

        for ($i = 0; $i < 50; $i++) {
            // random timestamp within last 30 days (some will be "today")
            $created = Carbon::today()
                ->subDays(rand(0, 30))
                ->setTime(rand(0, 23), rand(0, 59), rand(0, 59));

            Payment::create([
                'customer_name' => fake()->name(),
                'provider'      => $providers[array_rand($providers)],
                'status'        => $statuses[array_rand($statuses)],
                'amount'        => fake()->randomFloat(2, 20, 200),

                // keep if you use this column elsewhere
                'paid_at'       => $created->copy()->addMinutes(rand(5, 120)),

                // make the dashboard filter work
                'created_at'    => $created,
                'updated_at'    => $created->copy()->addMinutes(rand(1, 120)),
            ]);
        }
    }
}
