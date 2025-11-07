<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'order_no'     => 'ORD-' . $this->faker->unique()->numerify('####'),
            'user_id'      => 1,          // or: User::factory()
            'driver_id'    => null,       // or a valid driver id if you have ones
            'status'       => 'pending',  // seeder will override randomly
            'total_amount' => $this->faker->randomFloat(2, 20, 200),
        ];
    }
}
