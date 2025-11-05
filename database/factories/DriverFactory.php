<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Driver;

class DriverFactory extends Factory
{
    public function definition(): array
    {
        $count = Driver::count() + 1; // count existing records
        $code = 'DRV-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return [
            'driver_code'   => 'DRV-' . strtoupper($this->faker->bothify('???###')),
            'name'          => $this->faker->name(),
            'email' => $this->faker->unique()->userName() . '@brufuel.driver',
            'phone'         => $this->faker->phoneNumber(),
            
            'status'        => $this->faker->randomElement(['active','inactive']),
        ];
    }
}
