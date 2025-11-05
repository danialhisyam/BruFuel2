<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Livewire\Volt\Volt;
use App\Http\Controllers\AuthController;

Route::middleware('auth')->group(function () {
    Route::view('/checkout/fuel', 'logged.checkout.fuel')->name('checkout.fuel')->middleware('auth');
    Route::view('/checkout/vehicledetails', 'logged.checkout.vehicledetails')->name('checkout.vehicledetails')->middleware('auth');
    Route::view('/checkout/location', 'logged.checkout.location')->name('checkout.location')->middleware('auth');
    Route::view('/checkout/payment', 'logged.checkout.payment')->name('checkout.payment');
    Route::view('/checkout/confirm', 'logged.checkout.confirm')->name('checkout.confirm');
    Route::view('/checkout/success', 'logged.checkout.success')->name('checkout.success');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (LOGIN & SIGNUP)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.home', ['username' => $username]);
    }
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/signup', function () {
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.home', ['username' => $username]);
    }
    return view('signup');
})->name('signup');

Route::post('/signup', function () {
    $name = trim(request('name'));
    $email = strtolower(trim(request('email')));
    $password = request('password');
    $confirm = request('password_confirmation');

    if (!$name || !$email || !$password || $password !== $confirm) {
        return back()->with('error', 'Please fill all fields correctly.');
    }

    if (DB::table('users')->where('email', $email)->exists()) {
        return back()->with('email_error', 'This email is already registered.')->withInput();
    }

    DB::table('users')->insert([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('login')->with('success', 'Account created! Please log in.');
});

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/home');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES (NO LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/home');

Route::get('/home', function () {
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.home', ['username' => $username]);
    }
    return view('home');
})->name('home');

Route::get('/menu', function () {
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.menu', ['username' => $username]);
    }
    return view('menu');
})->name('menu');

Route::get('/history', function () {
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.history', ['username' => $username]);
    }
    return view('history');
})->name('history');

/*
|--------------------------------------------------------------------------
| ADMIN / DRIVER DASHBOARDS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::view('/admin.dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/driver.dashboard', 'driver.dashboard')->name('driver.dashboard');

    // Fortify Volt settings pages
    Route::redirect('/settings', '/settings/profile');
    Volt::route('/settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('/settings/password', 'settings.password')->name('password.edit');
    Volt::route('/settings/appearance', 'settings.appearance')->name('appearance.edit');
    Volt::route('/settings/two-factor', 'settings.two-factor')->name('two-factor.show');
});

/*
|--------------------------------------------------------------------------
| USER-SPECIFIC DASHBOARD (/username/home, /username/menu, /username/history)
|--------------------------------------------------------------------------
*/
Route::pattern('username', '^(?!signup|login|logout|home|menu|history|admin\.dashboard|driver\.dashboard|settings).*');

Route::middleware('auth')->prefix('{username}')->group(function () {

    // 🏠 Logged Home
    Route::get('/home', function ($username) {
        $user = Auth::user();
        abort_if(strtolower($user->name) !== strtolower($username), 403);
        return view('logged.home', ['user' => $user]);
    })->name('user.home');

    // 🍔 Logged Menu
    Route::get('/menu', function ($username) {
        $user = Auth::user();
        abort_if(strtolower($user->name) !== strtolower($username), 403);
        return view('logged.menu', ['user' => $user]);
    })->name('user.menu');

    // 🕓 Logged History
    Route::get('/history', function ($username) {
        $user = Auth::user();
        abort_if(strtolower($user->name) !== strtolower($username), 403);
        return view('logged.history', ['user' => $user]);
    })->name('user.history');
});

/*
|--------------------------------------------------------------------------
| PROFILE PICTURE UPLOAD
|--------------------------------------------------------------------------
*/
Route::post('/profile/upload', function (Request $request) {
    $user = Auth::user();
    if (!$user) return redirect()->route('login');

    $request->validate([
        'profile_picture' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $path = $request->file('profile_picture')->store('profile_pictures', 'public');
    $user->profile_picture = $path;
    $user->save();

    return back()->with('success', 'Profile picture updated successfully!');
})->name('profile.upload')->middleware('auth');

/*
|--------------------------------------------------------------------------
| DEBUG AUTH STATE
|--------------------------------------------------------------------------
*/
Route::get('/debug-auth', function () {
    return [
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
    ];
});

// 🚫 Prevent browser caching after logout
Route::middleware('auth')->group(function () {
    \Illuminate\Support\Facades\Response::macro('nocache', function ($content) {
        return response($content)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    });
});
