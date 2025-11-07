<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    /**
     * ✅ Display checkout page
     */
    public function index()
    {
        return view('mobile.checkout');
    }

    /**
     * ✅ Store selected fuel in session and redirect
     */
    public function fuelStore(Request $request)
    {
        try {
            $request->validate([
                'fuel_type' => 'required|string|max:50',
            ]);

            // Save selected fuel to session for multi-step process
            session(['checkout.fuel' => [
                'fuel_type' => $request->fuel_type,
            ]]);

            // Redirect to mobile home (or wherever the next step is)
            return redirect()->route('mobile.home')
                ->with('success', 'Fuel type selected. Please continue with your order.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Fuel store error: ' . $e->getMessage());
            return redirect()->route('mobile.home')
                ->with('error', 'Failed to save fuel selection. Please try again.');
        }
    }

    /**
     * ✅ Save location to session
     */
    public function locationStore(Request $request)
    {
        try {
            $request->validate([
                'address' => 'required|string|max:500',
            ]);

            session(['checkout.location' => [
                'address' => $request->address,
            ]]);

            return response()->json([
                'success' => true,
                'message' => 'Location saved successfully'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Location store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save location'
            ], 500);
        }
    }

    /**
     * ✅ Save vehicle details to session
     */
    public function vehicleStore(Request $request)
    {
        try {
            $request->validate([
                'license_plate' => 'required|string|max:20',
                'vehicle_type' => 'nullable|string|max:50',
                'make' => 'nullable|string|max:50',
                'model' => 'nullable|string|max:50',
                'color' => 'nullable|string|max:50',
            ]);

            $current = session('checkout.vehicle', []);

            session(['checkout.vehicle' => array_merge($current, array_filter([
                'license_plate' => $request->license_plate,
                'vehicle_type' => $request->vehicle_type,
                'make' => $request->make,
                'model' => $request->model,
                'color' => $request->color,
            ]))]);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle details saved successfully'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Vehicle store error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to save vehicle details'
            ], 500);
        }
    }

    /**
     * ✅ Final confirmation — Create Order and Payment records in database
     */
    public function confirm(Request $request)
    {
        try {
            $checkout = session('checkout', []);
            
            // Validate required checkout data
            if (empty($checkout['fuel']) || empty($checkout['location'])) {
                return redirect()->route('mobile.home')
                    ->with('error', 'Please complete all checkout steps before confirming.');
            }

            // Validate payment amount
            $request->validate([
                'fuel_amount' => 'required|numeric|min:0.01',
                'payment_method' => 'required|string|max:50',
            ]);

            $user = auth()->user();
            
            // Generate secure reference number
            $refNumber = $this->generateSecureRefNumber();
            
            // Generate order number
            $orderNo = 'ORD-' . strtoupper(Str::random(8));
            
            // Ensure order number is unique
            while (Order::where('order_no', $orderNo)->exists()) {
                $orderNo = 'ORD-' . strtoupper(Str::random(8));
            }

            DB::beginTransaction();
            
            try {
                // Create Order in database
                $order = Order::create([
                    'order_no' => $orderNo,
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'total_amount' => $request->fuel_amount,
                    'fuel_type' => $checkout['fuel']['fuel_type'] ?? null,
                    'delivery_address' => $checkout['location']['address'] ?? null,
                    'license_plate' => $checkout['vehicle']['license_plate'] ?? null,
                    'vehicle_type' => $checkout['vehicle']['vehicle_type'] ?? null,
                    'vehicle_make' => $checkout['vehicle']['make'] ?? null,
                    'vehicle_model' => $checkout['vehicle']['model'] ?? null,
                    'vehicle_color' => $checkout['vehicle']['color'] ?? null,
                    'payment_method' => $request->payment_method,
                    'payment_ref_number' => $refNumber,
                ]);

                // Create Payment record linked to order
                Payment::create([
                    'order_id' => $order->id,
                    'customer_name' => $user->name,
                    'provider' => $request->payment_method,
                    'status' => 'Pending',
                    'amount' => $request->fuel_amount,
                    'paid_at' => null, // Will be updated when order is completed
                ]);

                DB::commit();

                // Clear checkout session after successful order creation
                session()->forget('checkout');

                Log::info('Order created successfully', [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'user_id' => $user->id,
                ]);

                return redirect()->route('mobile.home')
                    ->with('success', "Order #{$order->order_no} created successfully! Reference: {$refNumber}");
                    
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order confirmation error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->route('mobile.home')
                ->with('error', 'Failed to create order. Please try again or contact support.');
        }
    }

    /**
     * ✅ Reset checkout session manually
     */
    public function reset(Request $request)
    {
        try {
            $request->session()->forget('checkout');

            return redirect()->route('mobile.home')
                ->with('success', 'Checkout session cleared.');
                
        } catch (\Exception $e) {
            Log::error('Checkout reset error: ' . $e->getMessage());
            return redirect()->route('mobile.home')
                ->with('error', 'Failed to reset checkout.');
        }
    }

    /**
     * Generate a secure reference number
     * Format: 8 alphanumeric characters (uppercase)
     */
    private function generateSecureRefNumber(): string
    {
        do {
            $refNumber = strtoupper(Str::random(8));
        } while (Order::where('payment_ref_number', $refNumber)->exists());

        return $refNumber;
    }
}
