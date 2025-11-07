<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DriverAdmin as Driver;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
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
    }
}
