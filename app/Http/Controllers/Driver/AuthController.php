<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // If someone is already logged in but not a driver, log them out
        if (Auth::check() && Auth::user()->role !== 'driver') {
            Auth::logout();
            session()->invalidate();
            session()->regenerateToken();
        }

        return view('driver.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Enforce driver role
            if (Auth::user()->role !== 'driver') {
                Auth::logout();
                return back()->withErrors(['email' => 'Driver access only.']);
            }

            return redirect()->route('driver.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Always go to the driver login page
        return redirect('/driver/login');
    }
}

