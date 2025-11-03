<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $driver = Auth::user();
        
        $stats = [
            'todayTrips' => Order::where('driver_id', $driver->id)
                            ->whereDate('created_at', today())
                            ->count(),
            'completedTrips' => Order::where('driver_id', $driver->id)
                               ->where('status', 'completed')
                               ->whereDate('created_at', today())
                               ->count(),
            'inProgressTrips' => Order::where('driver_id', $driver->id)
                                ->where('status', 'in_progress')
                                ->count(),
            'todayEarnings' => Payment::whereHas('order', function($query) use ($driver) {
                                $query->where('driver_id', $driver->id)
                                      ->whereDate('created_at', today());
                            })->sum('amount') * 0.8,
        ];

        $pendingTrips = Order::where('status', 'pending')
                         ->whereNull('driver_id')
                         ->with('user')
                         ->limit(5)
                         ->get();

        return view('driver.dashboard', compact('stats', 'pendingTrips', 'driver'));
    }
}