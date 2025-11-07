<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $q      = $request->query('q');
        $status = $request->query('status'); // 'active'|'inactive'|null

        $drivers = Driver::query()
            ->when($q, function ($s) use ($q) {
                $s->where(function ($x) use ($q) {
                    $x->where('name', 'like', "%{$q}%")
                      ->orWhere('driver_code', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->when($status, fn ($s) => $s->where('status', $status))
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.manage-drivers', compact('drivers'));
    }

    public function show(Driver $driver)
    {
        return response()->json($driver);
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'           => ['required','string','max:255'],
            'email'          => ['nullable','email','max:255'],
            'phone'          => ['nullable','string','max:40'],
            'license_type'   => ['nullable','string','max:50'],
            'license_expiry' => ['nullable','date'],
            'status'         => ['required', Rule::in(['active','inactive'])],
        ]);

        // If your Driver model auto-generates driver_code in booted(), no need to set it here.
        $driver = Driver::create($data);

        return response()->json(['success' => true, 'driver' => $driver], 201);
    }

    public function update(Request $r, Driver $driver)
    {
        $data = $r->validate([
            'name'           => ['required','string','max:255'],
            'email'          => ['nullable','email','max:255'],
            'phone'          => ['nullable','string','max:40'],
            'license_type'   => ['nullable','string','max:50'],
            'license_expiry' => ['nullable','date'],
            'status'         => ['required', Rule::in(['active','inactive'])],
        ]);

        $driver->update($data);

        return response()->json(['success' => true, 'driver' => $driver]);
    }

    public function destroy(Driver $driver)
    {
        $driver->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Return count of drivers for stats endpoint
     */
    public function count()
    {
        $total = Driver::count();
        return response()->json(['count' => $total]);
    }
}
