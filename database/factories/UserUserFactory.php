<?php
// database/factories/UserFactory.php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory {
    public function definition(): array {
        $name = $this->faker->name();
        $statuses = ['Active','Inactive','Pending'];
        return [
            'name'           => $name,
            'email'          => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'       => bcrypt('password'), // demo
            'remember_token' => Str::random(10),

            // UI fields
            'status'         => $this->faker->randomElement($statuses),
            'last_login_at'  => $this->faker->dateTimeBetween('-7 days', 'now'),
            'avatar'         => null, // or $this->faker->imageUrl(200,200,'people')
        ];
    }
}
