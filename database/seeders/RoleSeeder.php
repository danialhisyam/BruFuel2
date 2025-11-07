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
        User::where('email', 'danny@brufuel.admin')->first()?->assignRole('admin');
        User::where('email', 'danny@brufuel.driver')->first()?->assignRole('driver');
        User::where('email', 'sammy@gmail.com')->first()?->assignRole('customer');
        User::where('email', 'hirman@brufuel.driver')->first()?->assignRole('driver');
        User::where('email', 'bye@gmail.com')->first()?->assignRole('customer');
       
        // 3️⃣ (Optional) Just for confirmation in terminal
        $this->command->info('✅ Roles and permissions assigned successfully!');
    }
}



