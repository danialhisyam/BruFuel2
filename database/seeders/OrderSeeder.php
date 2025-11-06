<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['pending','assigned','completed','cancelled'];

        Order::factory()
            ->count(20)
            ->state(fn () => [
                'status'     => fake()->randomElement($statuses),
                'updated_at' => now()->subDays(rand(0, 7)),
            ])
            ->create();
    }
}
