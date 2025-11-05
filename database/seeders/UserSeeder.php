<?php
// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Roles (safe to call repeatedly)
        foreach (['Admin','Dispatcher','Driver','Customer'] as $r) {
            Role::findOrCreate($r);
        }

        // ----- Static Admins (read-only on UI) -----
        $admins = [
            ['ext' => 'FL-001', 'name' => 'Michael Foster',   'email' => 'michael.foster@example.com'],
            ['ext' => 'FL-002', 'name' => 'Hafiz Sapiuddin',  'email' => 'hafiz.sapiuddin@example.com'],
            ['ext' => 'FL-003', 'name' => 'Hirman',           'email' => 'hirman@example.com'],
            ['ext' => 'FL-004', 'name' => 'Ajay Ghale',       'email' => 'ajay.ghale@example.com'],
            ['ext' => 'FL-005', 'name' => 'Abng Muiz',        'email' => 'abng.muiz@example.com'],
        ];

        $hourOffsets = [ -2, -12, -0.033, -24, -12 ]; // match your demo times

        foreach ($admins as $i => $a) {
            $u = User::updateOrCreate(
                ['email' => $a['email']],
                [
                    'name'          => $a['name'],
                    'password'      => bcrypt('password'),
                    'external_id'   => $a['ext'],
                    'status'        => 'Active',
                    'last_login_at' => now()->addHours($hourOffsets[$i]),
                    'avatar'        => null,
                ]
            );
            if (method_exists($u,'assignRole')) $u->syncRoles(['Admin']);
        }

        // ----- Fake Customers (CRUD on UI, but still seeded) -----
        // How many?
        $count = 30;

        // current max customer number to continue CU-XXX sequence
        $max = (int) preg_replace('/\D/','', (string) User::where('external_id','like','CU-%')
                    ->orderBy(DB::raw("CAST(SUBSTRING(external_id,4) AS UNSIGNED)"), 'desc')
                    ->value('external_id')) ?: 100;

        User::factory()
            ->count($count)
            ->create()
            ->each(function(User $u) use (&$max){
                $max++;
                $u->external_id = 'CU-'.str_pad($max, 3, '0', STR_PAD_LEFT);
                $u->save();
                if (method_exists($u,'assignRole')) $u->syncRoles(['Customer']);
            });
    }
}
