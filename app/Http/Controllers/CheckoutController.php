<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * ✅ Store selected fuel in session
     * Handles redirect logic depending on where user came from.
     */
    public function fuelStore(Request $request)
    {
        $request->validate([
            'fuel_type' => 'required|string',
        ]);

        // ✅ Save selected fuel to session
        session(['checkout.fuel' => [
            'fuel_type' => $request->fuel_type,
        ]]);

        logger('Fuel stored:', session('checkout.fuel'));

        $redirect = $request->query('redirect_back') ?? $request->redirect_back ?? 'location';

        return redirect()->route("user.checkout.$redirect", [
            'username' => strtolower(auth()->user()->name),
        ]);
    }

    /**
     * ✅ Save location
     */
    public function locationStore(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        session(['checkout.location' => [
            'address' => $request->address,
        ]]);

        return response()->json(['success' => true]);
    }

    /**
     * ✅ Save vehicle details
     */
    public function vehicleStore(Request $request)
    {
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

        return response()->json(['success' => true]);
    }

    /**
     * ✅ Final confirmation — Save payment details and complete session
     */
    public function confirm(Request $request)
    {
        $checkout = session('checkout', []);

        $checkout['payment'] = [
            'amount'      => $request->input('fuel_amount', $checkout['payment']['amount'] ?? null),
            'method'      => $request->input('payment_method', 'Credit Card'),
            'ref_number'  => rand(10000000, 99999999),
            'timestamp'   => now()->format('H:i:s'),
            'sender'      => $request->input('sender_name', auth()->user()->name),
        ];

        $checkout['active'] = true;

        session(['checkout' => $checkout]);

        logger('Checkout confirmed:', session('checkout'));

        return redirect()->route('user.home', [
            'username' => strtolower(auth()->user()->name),
        ]);
    }

    /**
     * ✅ Reset checkout session manually
     */
    public function reset(Request $request)
    {
        $request->session()->forget('checkout');

        return redirect()->route('user.home', [
            'username' => strtolower(auth()->user()->name),
        ]);
    }
}
