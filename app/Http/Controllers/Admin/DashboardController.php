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

    }
}
