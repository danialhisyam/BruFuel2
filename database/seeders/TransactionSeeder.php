<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Faker\Factory as Faker;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 15) as $i) {
            Transaction::create([
                'trip_id' => 'TRP-' . $faker->numerify('######'),
                'type' => $faker->randomElement(['trip', 'payout']),
                'amount' => $faker->randomFloat(2, 5, 500),
                'status' => $faker->randomElement(['completed', 'pending', 'cancelled']),
                'transaction_date' => $faker->dateTimeBetween('-1 month', 'now'),
            ]);
        }
    }
}
