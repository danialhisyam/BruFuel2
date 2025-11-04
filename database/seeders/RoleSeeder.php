<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1️⃣ Create roles if they don’t exist
        Role::findOrCreate('admin');
        Role::findOrCreate('driver');
        Role::findOrCreate('customer');

        // 2️⃣ Assign roles to existing users by their email
        User::where('email', 'admin@brufuel.com')->first()?->assignRole('admin');
        User::where('email', 'admin2@brufuel.com')->first()?->assignRole('admin'); 
        User::where('email', 'driver3@brufuel.com')->first()?->assignRole('driver');
        User::where('email', 'driver@brufuel.com')->first()?->assignRole('driver');
        User::where('email', 'driver2@brufuel.com')->first()?->assignRole('driver');
        User::where('email', 'customer@brufuel.com')->first()?->assignRole('customer');
        User::where('email', 'hafiz123@brufueladmin.com')->first()?->assignRole('admin'); 
        User::where('email', 'hirman@brufuel.driver.com')->first()?->assignRole('driver'); 
        

        // 3️⃣ (Optional) Just for confirmation in terminal
        $this->command->info('✅ Roles and permissions assigned successfully!');
    }
}
