<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('signup');
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Incorrect password. Please try again.');
        }

        Auth::login($user);
        $request->session()->regenerate();

        if (str_ends_with($user->email, '@admin.brufuel.bn')) {
            return redirect()->route('admin.dashboard');
        } elseif (str_ends_with($user->email, '@driver.brufuel.bn')) {
            return redirect()->route('driver.dashboard');
        }

        return redirect()->route('home');
    }
}
