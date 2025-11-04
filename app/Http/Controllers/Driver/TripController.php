<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function index()
    {
        $driver = Auth::user();
        
        $pendingTrips = Order::where('status', 'pending')
                         ->whereNull('driver_id')
                         ->with('user')
                         ->get();
                         
        $inProgressTrips = Order::where('driver_id', $driver->id)
                           ->where('status', 'in_progress')
                           ->with('user')
                           ->get();
                           
        $completedTrips = Order::where('driver_id', $driver->id)
                          ->where('status', 'completed')
                          ->with('user')
                          ->get();
                          
        $cancelledTrips = Order::where('driver_id', $driver->id)
                          ->where('status', 'cancelled')
                          ->with('user')
                          ->get();

        return view('driver.trips.index', compact(
            'pendingTrips', 
            'inProgressTrips', 
            'completedTrips', 
            'cancelledTrips'
        ));
    }

    public function accept(Request $request, Order $order)
    {
        if ($order->driver_id || $order->status !== 'pending') {
            return back()->with('error', 'Order no longer available.');
        }

        $order->update([
            'driver_id' => Auth::id(),
            'status' => 'accepted'
        ]);

        return back()->with('success', 'Order accepted successfully!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:in_progress,completed'
        ]);

        // Verify driver owns this order
        if ($order->driver_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated!');
    }
}