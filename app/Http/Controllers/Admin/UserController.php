<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // renders your Blade: resources/views/admin/manage-user.blade.php
    public function index()
    {
        return view('admin.manage-user');
    }

    // JSON for the Alpine table
    public function data(Request $request)
    {
        $context = strtolower($request->get('context', 'admin')); // 'admin' | 'customer'

        // If you use Spatie roles, this filters to the selected context.
        $q = User::query()->with('roles');
        if ($context === 'admin') {
            $q->role('admin');
        } elseif ($context === 'customer') {
            $q->role('customer');
        }
        // If you’re not assigning roles yet, comment the two lines above.

        $users = $q->select(['id','name','email','status','last_login_at','avatar','external_id'])->get();

        $payload = $users->map(function ($u) {
            $role = ucfirst($u->getRoleNames()->first() ?? 'Customer'); // Admin/Driver/Customer
            $id   = $u->external_id ?: sprintf('%s-%03d', strtoupper(substr($role,0,2)), $u->id);

            return [
                'id'        => $id,
                'name'      => $u->name,
                'email'     => $u->email,
                'role'      => $role,
                'status'    => $u->status ?? 'Active',
                'lastLogin' => optional($u->last_login_at)->toIso8601String() ?? now()->subDays(1)->toIso8601String(),
                'avatar'    => $u->avatar,
            ];
        });

        return response()->json($payload);
    }
}
