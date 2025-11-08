<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vehicle;

class UserController extends Controller
{
    // ✅ Show the logged-in user's home page
    public function home($username, Request $request)
    {
        $user = Auth::user();

        // Prevent accessing another user's page
        if (!$user || strtolower($user->name) !== strtolower($username)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login');
        }

        // Fetch all vehicles for this user
        $vehicles = Vehicle::where('user_id', $user->id)->get();

        return view('logged.home', [
            'user' => $user,
            'vehicles' => $vehicles
        ]);
    }

    // ✅ Show the Add Vehicle page
    public function savevehicle($username)
    {
        $user = Auth::user();

        if (!$user || strtolower($user->name) !== strtolower($username)) {
            Auth::logout();
            return redirect()->route('login');
        }

        return view('logged.savevehicle', ['user' => $user]);
    }

    // ✅ Save new vehicle to database
    public function storeVehicle($username, Request $request)
    {
        $user = Auth::user();

        if (!$user || strtolower($user->name) !== strtolower($username)) {
            Auth::logout();
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'license_plate' => 'required|string|max:20',
            'vehicle_type' => 'required|string|max:50',
            'make' => 'nullable|string|max:50',
            'model' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:50',
        ]);

        Vehicle::create([
            'user_id' => $user->id,
            'license_plate' => $validated['license_plate'],
            'vehicle_type' => $validated['vehicle_type'],
            'make' => $validated['make'] ?? null,
            'model' => $validated['model'] ?? null,
            'color' => $validated['color'] ?? null,
        ]);

        // Redirect back to user home
        return response()->json(['success' => true]);
    }
}
