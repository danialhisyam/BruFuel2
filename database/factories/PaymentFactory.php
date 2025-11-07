<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        $providers = ['BIBD','BAIDURI','TAB','CASH'];
        // Weighted statuses: Paid ~70%, Pending ~20%, Fail ~10%
        $status = collect([
            ...array_fill(0, 70, 'Paid'),
            ...array_fill(0, 20, 'Pending'),
            ...array_fill(0, 10, 'Fail'),
        ])->random();

        // Names in CAPS like your demo data
        $name = strtoupper($this->faker->firstName());

        return [
            'customer_name' => $name,
            'provider'      => $this->faker->randomElement($providers),
            'status'        => $status,
            'amount'        => $this->faker->randomFloat(2, 10, 120), // B$10–120
            'paid_at'       => $this->faker->dateTimeBetween('-30 days', 'now'),
        ];
    }

    // Quick helpers if you ever want specific states:
    public function paid(): static    { return $this->state(fn()=>['status'=>'Paid']); }
    public function pending(): static { return $this->state(fn()=>['status'=>'Pending']); }
    public function fail(): static    { return $this->state(fn()=>['status'=>'Fail']); }
}
