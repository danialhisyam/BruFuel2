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

        // ✅ Determine where to redirect next
        // If coming from payment, return there — otherwise go to location
            logger('Fuel stored:', session('checkout.fuel'));

        $redirect = $request->query('redirect_back') ?? $request->redirect_back ?? 'location';

        return redirect()->route("user.checkout.$redirect", [
            'username' => strtolower(auth()->user()->name),
        ]);
    }

    public function locationStore(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        // ✅ Save location to session
        session(['checkout.location' => [
            'address' => $request->address,
        ]]);

        return response()->json(['success' => true]);
    }

    public function reset(Request $request)
    {
        // Clear only checkout-related data
        $request->session()->forget('checkout');

        return redirect()->route('user.home', [
            'username' => strtolower(auth()->user()->name),
        ]);
    }

    public function vehicleStore(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string|max:20',
            'vehicle_type' => 'nullable|string|max:50',
            'make' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        // ✅ Preserve previous data if user changes only one field
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

    }



