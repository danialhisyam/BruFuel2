<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            DriverSeeder::class,   // if you have them
            PaymentSeeder::class,  // if you have them
        ]);
    }
}
