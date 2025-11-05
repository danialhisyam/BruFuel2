<?php
use Illuminate\Support\Facades\Route;
use App\Models\User;

Route::get('/users', function () {
    $context = request('context', 'Admin'); // 'Admin' or 'Customer'
    $q       = request('q');
    $status  = request('status');
    $role    = request('role');
    $last    = request('last');

    $users = User::query()
        // If external_id prefixes exist, use them; otherwise fall back to roles or no filter.
        ->when($context === 'Admin', function ($q2) {
            $q2->where(function($w){
                $w->where('external_id', 'like', 'FL-%')
                  ->orWhereHas('roles', fn($r)=>$r->where('name','Admin'))
                  ->orWhereNull('external_id'); // tolerate missing prefixes
            });
        })
        ->when($context === 'Customer', function ($q2) {
            $q2->where(function($w){
                $w->where('external_id', 'like', 'CU-%')
                  ->orWhereHas('roles', fn($r)=>$r->where('name','Customer'))
                  ->orWhereNull('external_id'); // tolerate missing prefixes
            });
        })
        ->when($q, function ($qq) use ($q) {
            $qq->where(function ($s) use ($q) {
                $s->where('name','like',"%$q%")->orWhere('email','like',"%$q%");
            });
        })
        ->when($status, fn($qq)=>$qq->where('status',$status))
        ->when($role,   fn($qq)=>$qq->whereHas('roles', fn($r)=>$r->where('name',$role)))
        ->when($last, function ($qq) use ($last) {
            $since = ['24h'=>now()->subDay(),'7d'=>now()->subDays(7),'30d'=>now()->subDays(30)][$last] ?? null;
            if ($since) $qq->where('last_login_at','>=',$since);
        })
        ->with('roles')
        ->orderByRaw("CASE WHEN external_id IS NULL THEN 1 ELSE 0 END, external_id ASC")
        ->get()
        ->map(function($u){
            $roleName = optional($u->roles->first())->name;
            return [
                'id'        => $u->external_id ?? (string)$u->id,
                'name'      => $u->name,
                'email'     => $u->email,
                'role'      => $roleName ?: (str_starts_with((string)$u->external_id,'FL-') ? 'Admin' : 'Customer'),
                'status'    => $u->status ?? 'Active',
                'lastLogin' => optional($u->last_login_at)->toIso8601String() ?? now()->toIso8601String(),
                'avatar'    => $u->avatar,
            ];
        });

    return response()->json($users);
});
