<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DriverAdmin as Driver;
use App\Models\Order;
use App\Models\PaymentAdmin as Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        /** ---------- USERS / DRIVERS ---------- */
        $totalUsers    = User::count();

        $totalDrivers  = Driver::count();
        $activeDrivers = Driver::where('status', 'active')->count();
        $activePct     = $totalDrivers ? round($activeDrivers / max(1, $totalDrivers) * 100) : 0;

        /** ---------- ORDERS (guard if table missing) ---------- */
        if (Schema::hasTable('orders')) {
            $todaysOrders = Order::whereDate('created_at', $today)->count();

            // recent orders with driver relation
           // recent orders with user (admin) relation
        $recent = Order::with('user')
        ->orderByDesc('updated_at')
            ->take(10)
                ->get();

        } else {
            $todaysOrders = 0;
            $recent       = collect();
        }

        /** ---------- PAYMENTS (today + all-time) ---------- */
        $dateCol   = Schema::hasColumn('payments', 'paid_at') ? 'paid_at' : 'created_at';
        $providers = ['TAP', 'CASH', 'BIBD', 'BAIDURI']; // always show these

        // Today total
        $paymentToday = (float) Payment::whereDate($dateCol, $today)
            ->whereIn('status', ['Paid', 'paid'])
            ->sum('amount');

        // All-time total
        $paymentTotal = (float) Payment::whereIn('status', ['Paid', 'paid'])->sum('amount');

        // Today by provider (raw)
        $rawToday = Payment::select('provider', DB::raw('SUM(amount) as total'))
            ->whereDate($dateCol, $today)
            ->whereIn('status', ['Paid', 'paid'])
            ->groupBy('provider')
            ->pluck('total', 'provider')
            ->toArray();

        // Normalize to include all providers
        $paymentByMethod = collect($providers)->mapWithKeys(fn ($p) => [
            $p => (float) ($rawToday[$p] ?? 0),
        ]);

        // All-time by provider (raw)
        $rawAllTime = Payment::select('provider', DB::raw('SUM(amount) as total'))
            ->whereIn('status', ['Paid', 'paid'])
            ->groupBy('provider')
            ->pluck('total', 'provider')
            ->toArray();

        // Normalize all-time
        $paymentAllTimeByMethod = collect($providers)->mapWithKeys(fn ($p) => [
            $p => (float) ($rawAllTime[$p] ?? 0),
        ]);

        /** ---------- VIEW ---------- */
        return view('admin.dashboard', [
            'totalUsers'               => $totalUsers,
            'activeDrivers'            => $activeDrivers,
            'activePct'                => $activePct,
            'todaysOrders'             => $todaysOrders,
            'paymentToday'             => $paymentToday,
            'paymentTotal'             => $paymentTotal,
            'paymentByMethod'          => $paymentByMethod,
            'paymentAllTimeByMethod'   => $paymentAllTimeByMethod,
            'recent'                   => $recent,
        ]);
    }
}
