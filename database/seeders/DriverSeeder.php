<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;   // <-- important

class DriverSeeder extends Seeder
{
    public function run(): void
    {
        Driver::factory()->count(10)->create();
    }
}
