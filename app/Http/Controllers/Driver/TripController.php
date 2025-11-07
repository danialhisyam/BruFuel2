<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TripController extends Controller
{
    /**
     * Get the driver record for the logged-in user
     * Auto-creates driver record if it doesn't exist
     */
    private function getDriver()
    {
        $user = Auth::user();
        
        // First try to find by user_id
        $driver = Driver::where('user_id', $user->id)->first();
        
        if ($driver) {
            return $driver;
        }
        
        // Try to find by email or name (for existing drivers)
        $driver = Driver::where('email', $user->email)
            ->orWhere('name', $user->name)
            ->first();
        
        // If found, link it to the user
        if ($driver && !$driver->user_id) {
            $driver->update(['user_id' => $user->id]);
            return $driver;
        }
        
        // If no driver exists, create one automatically
        if (!$driver) {
            $driver = Driver::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => 'active',
            ]);
        }
        
        return $driver;
    }

    public function index()
    {
        $driver = $this->getDriver();
        
        $pendingTrips = Order::where('status', 'pending')
                         ->whereNull('driver_id')
                         ->with('user')
                         ->orderByDesc('created_at')
                         ->get();
                         
        $inProgressTrips = Order::where('driver_id', $driver->id)
                           ->where('status', 'in_progress')
                           ->with('user')
                           ->orderByDesc('updated_at')
                           ->get();
                           
        $completedTrips = Order::where('driver_id', $driver->id)
                          ->where('status', 'completed')
                          ->with('user')
                          ->orderByDesc('updated_at')
                          ->get();
                          
        $cancelledTrips = Order::where('driver_id', $driver->id)
                          ->where('status', 'cancelled')
                          ->with('user')
                          ->orderByDesc('updated_at')
                          ->get();

        return view('driver.trips.index', compact(
            'pendingTrips', 
            'inProgressTrips', 
            'completedTrips', 
            'cancelledTrips',
            'driver'
        ));
    }

    public function accept(Request $request, Order $order)
    {
        try {
            $driver = $this->getDriver();
            
            if (!$driver) {
                return back()->with('error', 'Driver profile not found.');
            }

            if ($order->driver_id || $order->status !== 'pending') {
                return back()->with('error', 'Order no longer available.');
            }

            $order->update([
                'driver_id' => $driver->id,
                'status' => 'in_progress'
            ]);

            Log::info('Order accepted by driver', [
                'order_id' => $order->id,
                'order_no' => $order->order_no,
                'driver_id' => $driver->id,
            ]);

            return back()->with('success', 'Order accepted successfully!');
            
        } catch (\Exception $e) {
            Log::error('Error accepting order: ' . $e->getMessage());
            return back()->with('error', 'Failed to accept order. Please try again.');
        }
    }

    public function decline(Request $request, Order $order)
    {
        try {
            if ($order->driver_id || $order->status !== 'pending') {
                return back()->with('error', 'Order no longer available.');
            }

            $order->update([
                'status' => 'cancelled'
            ]);

            Log::info('Order declined', [
                'order_id' => $order->id,
                'order_no' => $order->order_no,
            ]);

            return back()->with('success', 'Order declined.');
            
        } catch (\Exception $e) {
            Log::error('Error declining order: ' . $e->getMessage());
            return back()->with('error', 'Failed to decline order. Please try again.');
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:in_progress,completed'
            ]);

            $driver = $this->getDriver();
            
            if (!$driver) {
                return back()->with('error', 'Driver profile not found.');
            }

            // Verify driver owns this order
            if ($order->driver_id !== $driver->id) {
                abort(403, 'Unauthorized action.');
            }

            DB::beginTransaction();
            
            try {
                // Load user relationship if not already loaded
                if (!$order->relationLoaded('user')) {
                    $order->load('user');
                }
                
                // Update order status
                $order->update(['status' => $request->status]);
                
                // Refresh order to get latest data
                $order->refresh();

                // If order is completed, update payment status to Paid
                if ($request->status === 'completed') {
                    // Try to find payment using the order's payment relationship first
                    $payment = $order->fresh()->payment;
                    
                    // If not found, try to find by order_id
                    if (!$payment) {
                        $payment = \App\Models\Payment::where('order_id', $order->id)->first();
                    }
                    
                    // If still not found, try to find by matching order details (for existing payments without order_id)
                    if (!$payment && $order->user) {
                        // Try exact match: customer name, amount, and provider
                        $payment = \App\Models\Payment::where('customer_name', $order->user->name)
                            ->whereRaw('ABS(amount - ?) < 0.01', [$order->total_amount])
                            ->where('provider', $order->payment_method ?? '')
                            ->where('status', 'Pending')
                            ->whereNull('order_id')
                            ->orderByDesc('created_at')
                            ->first();
                        
                        // If found, link it to the order
                        if ($payment) {
                            $payment->update(['order_id' => $order->id]);
                        }
                    }
                    
                    // If still not found, try a more flexible match (just amount and customer name)
                    if (!$payment && $order->user) {
                        $payment = \App\Models\Payment::where('customer_name', $order->user->name)
                            ->whereRaw('ABS(amount - ?) < 0.01', [$order->total_amount])
                            ->where('status', 'Pending')
                            ->orderByDesc('created_at')
                            ->first();
                        
                        if ($payment) {
                            $payment->update([
                                'order_id' => $order->id,
                                'provider' => $order->payment_method ?? $payment->provider,
                            ]);
                        }
                    }
                    
                    // If still not found, try to find any pending payment for this customer with matching amount
                    if (!$payment && $order->user) {
                        $payment = \App\Models\Payment::where('customer_name', $order->user->name)
                            ->whereRaw('ABS(amount - ?) < 0.01', [$order->total_amount])
                            ->where('status', 'Pending')
                            ->orderByDesc('created_at')
                            ->first();
                        
                        if ($payment) {
                            $payment->update([
                                'order_id' => $order->id,
                            ]);
                        }
                    }
                    
                    if ($payment) {
                        $payment->update([
                            'status' => 'Paid',
                            'paid_at' => now(),
                        ]);

                        Log::info('Payment marked as paid', [
                            'payment_id' => $payment->id,
                            'order_id' => $order->id,
                            'order_no' => $order->order_no,
                            'amount' => $payment->amount,
                        ]);
                    } else {
                        Log::warning('Payment not found for completed order', [
                            'order_id' => $order->id,
                            'order_no' => $order->order_no,
                            'customer_name' => optional($order->user)->name,
                            'amount' => $order->total_amount,
                            'payment_method' => $order->payment_method,
                        ]);
                    }
                }

                DB::commit();

                Log::info('Order status updated', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'new_status' => $request->status,
                ]);

                return back()->with('success', 'Order status updated!');
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage());
            return back()->with('error', 'Failed to update order status.');
        }
    }
}