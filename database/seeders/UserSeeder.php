<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Seed a few admins (static)
        $admins = [
           
        ];

        foreach ($admins as $i => $a) {
            $u = User::updateOrCreate(
                ['email' => $a['email']],
                [
                    'name' => $a['name'],
                    'password' => Hash::make('password123'),
                    'status' => 'Active',
                    'last_login_at' => now()->subHours(2 + $i),
                ]
            );

            // match RoleSeeder casing exactly
            $u->syncRoles(['admin']);
        }

        // Fake customers
        $count = 30;

        // get max customer code CU-xxx
        $max = (int) preg_replace('/\D/', '', (string)
            User::where('external_id', 'like', 'CU-%')
                ->orderByRaw("CAST(SUBSTRING(external_id, 4) AS UNSIGNED) DESC")
                ->value('external_id')
        ) ?: 100;

        User::factory()
            ->count($count)
            ->create()
            ->each(function (User $u) use (&$max) {
                $max++;
                $u->external_id = 'CU-' . str_pad($max, 3, '0', STR_PAD_LEFT);
                $u->save();

                $u->syncRoles(['customer']);
            });
    }
}
