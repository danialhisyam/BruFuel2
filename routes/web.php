<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Livewire\Volt\Volt;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| DASHBOARD REDIRECT
|--------------------------------------------------------------------------
*/
Route::redirect('/dashboard', '/home')->name('dashboard');

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
| USER-SPECIFIC ROUTES (USERNAME PREFIX)
|--------------------------------------------------------------------------
|
| Every logged-in route (home, menu, history, checkout pages) 
| will include the username in the URL.
| Example:
|   /hisyam/home
|   /hisyam/menu
|   /hisyam/checkout/fuel
|--------------------------------------------------------------------------
*/

Route::pattern('username', '^(?!signup|login|logout|home|menu|history|admin|driver|settings).*');

Route::group([
    'prefix' => '{username}',
    'middleware' => ['auth'],
], function () {

    // ✅ Inline access-control middleware using Route::group callback
    Route::group([], function () {
        // Everything below runs only if user is logged in AND matches username
        Route::get('/home', function ($username, Request $request) {
            $user = Auth::user();

            // Not logged in or mismatch → logout and redirect
            if (!$user || strtolower($user->name) !== strtolower($username)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login');
            }

            return view('logged.home', ['user' => $user]);
        })->name('user.home');

        Route::get('/menu', function ($username, Request $request) {
            $user = Auth::user();
            if (!$user || strtolower($user->name) !== strtolower($username)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login');
            }

            return view('logged.menu', ['user' => $user]);
        })->name('user.menu');

        Route::get('/history', function ($username, Request $request) {
            $user = Auth::user();
            if (!$user || strtolower($user->name) !== strtolower($username)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('login');
            }

            return view('logged.history', ['user' => $user]);
        })->name('user.history');

        // ✅ Checkout pages (same protection applied)
        Route::prefix('checkout')->group(function () {

            Route::get('/reset', [\App\Http\Controllers\CheckoutController::class, 'reset'])
            ->name('user.checkout.reset');

                // 🆕 ADD THIS BELOW RESET:
            Route::post('/confirm', [\App\Http\Controllers\CheckoutController::class, 'confirm'])
            ->name('user.checkout.confirm');
        
            Route::post('/fuel', [\App\Http\Controllers\CheckoutController::class, 'fuelStore'])
            ->name('user.checkout.fuel.store');
            Route::post('/location/save', [\App\Http\Controllers\CheckoutController::class, 'locationStore'])
            ->name('user.checkout.location.save');
            // ✅ Save vehicle details (license plate + brand/model)
            Route::post('/vehicledetails', [App\Http\Controllers\CheckoutController::class, 'vehicleStore'])
           ->name('user.checkout.vehicledetails.store');
           Route::post('/confirm', [\App\Http\Controllers\CheckoutController::class, 'confirm'])
           ->name('user.checkout.confirm');

            Route::get('/fuel', fn() => view('logged.checkout.fuel'))->name('user.checkout.fuel');
            Route::get('/vehicledetails', fn() => view('logged.checkout.vehicledetails'))->name('user.checkout.vehicledetails');
            Route::get('/location', fn() => view('logged.checkout.location'))->name('user.checkout.location');
            Route::get('/payment', fn() => view('logged.checkout.payment'))->name('user.checkout.payment');
            Route::get('/success', fn() => view('logged.checkout.success'))->name('user.checkout.success');
        });
    });
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

/*
|--------------------------------------------------------------------------
| SESSION RESET (HIDDEN KILLER)
|--------------------------------------------------------------------------
*/
use Illuminate\Support\Facades\Session;

Route::post('/reset-session', function () {
    Session::forget('checkout');
    return redirect()->back()->with('success', 'Checkout session cleared!');
})->name('user.session.reset');


/*
|--------------------------------------------------------------------------
| DISABLE CACHE AFTER LOGOUT
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    \Illuminate\Support\Facades\Response::macro('nocache', function ($content) {
        return response($content)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    });
});

Route::get('/debug-session', function () {
    return session('checkout', 'No checkout session found');
});