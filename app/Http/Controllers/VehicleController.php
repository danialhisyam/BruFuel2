<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'license_plate' => 'required|string|max:20',
            'vehicle_type'  => 'required|string|max:50',
            'make'          => 'nullable|string|max:50',
            'model'         => 'nullable|string|max:50',
            'color'         => 'nullable|string|max:50',
        ]);

        Vehicle::create([
            'user_id' => Auth::id(),
            'license_plate' => $request->license_plate,
            'vehicle_type'  => $request->vehicle_type,
            'make'          => $request->make,
            'model'         => $request->model,
            'color'         => $request->color,
        ]);

        return response()->json(['success' => true]);
    }
}
