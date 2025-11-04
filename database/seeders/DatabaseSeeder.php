<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Example user
User::factory()->create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => Hash::make('password123'),
]);


        // Call other seeders here
        $this->call([
            DriverSeeder::class, // Make sure you’ve created this seeder
        ]);
    }
}
