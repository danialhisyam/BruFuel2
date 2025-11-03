<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        // Simple/defensive queries (won't crash if tables are empty)
        $users     = DB::table('users')->count();
        $drivers   = DB::schema()->hasTable('drivers')
                    ? DB::table('drivers')->where('status','active')->count()
                    : 0;

        $ordersQ   = DB::schema()->hasTable('orders')
                    ? DB::table('orders')->whereBetween('created_at', [$today->startOfDay(), $today->endOfDay()])
                    : DB::table('users')->whereRaw('1=0'); // empty placeholder

        $orders    = DB::schema()->hasTable('orders') ? (clone $ordersQ)->count() : 0;
        $paid      = DB::schema()->hasTable('orders') ? (float) (clone $ordersQ)->where('status','completed')->sum('amount') : 0;

        $recent = DB::schema()->hasTable('orders')
            ? DB::table('orders')
                ->select('id','code','status','driver_name','amount','created_at')
                ->orderByDesc('created_at')->limit(8)->get()
                ->map(fn($o) => [
                    'id'        => $o->id,
                    'code'      => $o->code,
                    'status'    => $o->status,
                    'driver'    => $o->driver_name,
                    'amount'    => (float) $o->amount,
                    'when'      => \Carbon\Carbon::parse($o->created_at)->diffForHumans(),
                    'createdAt' => (string) $o->created_at,
                ])
            : collect([]);

        $initial = [
            'range'  => ['start'=>$today->toDateString(),'end'=>$today->toDateString()],
            'counts' => ['users'=>$users,'drivers'=>$drivers,'orders'=>$orders,'paid'=>round($paid,2)],
            'orders' => $recent,
        ];

        // Blade expects $initial
        return view('admin.dashboard', compact('initial'));
    }

    // Optional JSON endpoint (not required for first render)
    public function data(Request $request)
    {
        return response()->json(['ok'=>true]);
    }
}
