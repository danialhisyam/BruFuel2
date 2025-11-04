<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $driver = Auth::user();
        
        // Calculate earnings
        $earnings = [
            'today' => Payment::whereHas('order', function($query) use ($driver) {
                        $query->where('driver_id', $driver->id)
                              ->whereDate('created_at', today());
                    })->sum('amount') * 0.8,
            'week' => Payment::whereHas('order', function($query) use ($driver) {
                        $query->where('driver_id', $driver->id)
                              ->where('created_at', '>=', now()->subWeek());
                    })->sum('amount') * 0.8,
            'month' => Payment::whereHas('order', function($query) use ($driver) {
                        $query->where('driver_id', $driver->id)
                              ->where('created_at', '>=', now()->subMonth());
                    })->sum('amount') * 0.8,
            'total' => Payment::whereHas('order', function($query) use ($driver) {
                        $query->where('driver_id', $driver->id);
                    })->sum('amount') * 0.8,
        ];

        // Get transactions
        $transactions = Payment::whereHas('order', function($query) use ($driver) {
                            $query->where('driver_id', $driver->id);
                        })
                        ->with('order.user')
                        ->latest()
                        ->paginate(10);

        // Payment breakdown
        $paymentBreakdown = [
            'cash' => Payment::whereHas('order', function($query) use ($driver) {
                        $query->where('driver_id', $driver->id);
                    })->where('method', 'cash')->sum('amount') * 0.8,
            'card' => Payment::whereHas('order', function($query) use ($driver) {
                        $query->where('driver_id', $driver->id);
                    })->where('method', 'card')->sum('amount') * 0.8,
        ];

        // Recent activities
        $recentActivities = [
            'Latest payment received - BND $' . number_format($transactions->first()->amount * 0.8 ?? 0, 2),
            'Completed delivery for Order #' . ($transactions->first()->order->id ?? 'N/A'),
            'You have ' . $transactions->count() . ' completed trips this month',
        ];

        return view('driver.transactions.index', compact(
            'earnings', 
            'transactions', 
            'paymentBreakdown', 
            'recentActivities'
        ));
    }
}