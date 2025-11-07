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
<<<<<<< HEAD
        $today      = Carbon::today();
        $yesterday  = $today->clone()->subDay();

        /** ---------- USERS ---------- */
        $totalUsers     = User::count();
        $usersThisWeek  = User::where('created_at', '>=', now()->startOfWeek())->count();
        $userGrowthPct  = $totalUsers ? round(($usersThisWeek / max(1,$totalUsers)) * 100) : 0;

        /** ---------- DRIVERS ---------- */
        $totalDrivers   = Driver::count();
        $activeDrivers  = Driver::where('status', 'active')->count();
        // if you track online status, keep; else set 0
        $onlineDrivers  = Schema::hasColumn('driver_admins','is_online')
                            ? Driver::where('is_online', true)->count()
                            : 0;
        $activePct      = $totalDrivers ? round($activeDrivers / max(1,$totalDrivers) * 100) : 0;

        /** ---------- ORDERS (guard if table missing) ---------- */
        $todaysOrders = 0;
        $orderDeltaPct = 0;
        $recent = collect();

        if (Schema::hasTable('orders')) {
            $todaysOrders   = Order::whereDate('created_at', $today)->count();
            $yesterdays     = Order::whereDate('created_at', $yesterday)->count();
            $delta          = $todaysOrders - $yesterdays;
            $orderDeltaPct  = $yesterdays ? round(($delta / $yesterdays) * 100) : 0;

            // recent orders with admin user relation (adjust relation name if needed)
            $recent = Order::with('user')
                ->orderByDesc('updated_at')
                ->take(10)
                ->get();
        }

        /** ---------- PAYMENTS SUMMARY ---------- */
        $providers       = ['TAP', 'CASH', 'BIBD', 'BAIDURI'];

        $totalRevenue    = Schema::hasTable('payments')
            ? (float) Payment::whereIn('status', ['Paid','paid'])->sum('amount')
            : 0;

        $paymentByMethod = Schema::hasTable('payments')
            ? Payment::select('provider', DB::raw('SUM(amount) as total'))
                ->whereIn('status', ['Paid','paid'])
                ->groupBy('provider')
                ->pluck('total', 'provider')
                ->toArray()
            : [];

        $paymentByMethod = collect($providers)->mapWithKeys(
            fn ($p) => [$p => (float) ($paymentByMethod[$p] ?? 0)]
        );

        /** ---------- VIEW ---------- */
        return view('admin.dashboard', [
            // Users
            'totalUsers'      => $totalUsers,
            'usersThisWeek'   => $usersThisWeek,
            'userGrowthPct'   => $userGrowthPct,

            // Drivers
            'totalDrivers'    => $totalDrivers,
            'activeDrivers'   => $activeDrivers,
            'onlineDrivers'   => $onlineDrivers,
            'activePct'       => $activePct,

            // Orders
            'todaysOrders'    => $todaysOrders,
            'orderDeltaPct'   => $orderDeltaPct,
            'recent'          => $recent,

            // Payments
            'totalRevenue'    => $totalRevenue,
            'paymentByMethod' => $paymentByMethod,
        ]);
=======
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

       /** ---------- SIMPLE PAYMENTS SUMMARY ---------- */
$providers = ['TAP', 'CASH', 'BIBD', 'BAIDURI'];

// Total revenue (sum of all paid transactions)
$totalRevenue = (float) Payment::whereIn('status', ['Paid', 'paid'])->sum('amount');

// Revenue by payment method
$paymentByMethod = Payment::select('provider', DB::raw('SUM(amount) as total'))
    ->whereIn('status', ['Paid', 'paid'])
    ->groupBy('provider')
    ->pluck('total', 'provider')
    ->toArray();

// Make sure all 4 providers always show up even if 0
$paymentByMethod = collect($providers)->mapWithKeys(fn ($p) => [
    $p => (float) ($paymentByMethod[$p] ?? 0),
]);


        /** ---------- VIEW ---------- */
       return view('admin.dashboard', [
    'totalUsers'      => $totalUsers,
    'activeDrivers'   => $activeDrivers,
    'activePct'       => $activePct,
    'todaysOrders'    => $todaysOrders,
    'recent'          => $recent,
    'totalRevenue'    => $totalRevenue,
    'paymentByMethod' => $paymentByMethod,
]);

>>>>>>> origin/master
    }
}
