<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use Illuminate\Http\Request;
use App\Livewire\CheckoutComponent;

// ✅ Temporary helper to simulate a cart
Route::get('/set-total/{amount}', function ($amount) {
    session(['cart_total' => $amount]);
    return "Cart total set to B$$amount";
});

Route::get('/checkout', CheckoutComponent::class)->name('checkout');

Route::get('/payment-success', function (Illuminate\Http\Request $request) {
    $amount = $request->query('amount', 'B$0');
    return view('payment-success', ['amount' => $amount]);
})->name('payment.success');

Route::redirect('/dashboard', '/checkout')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
});

=======
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (LOGIN & SIGNUP)
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    // If user is already logged in, send them to their personal home
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.home', ['username' => $username]);
    }
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/signup', function () {
    // If logged in, go back home
    if (Auth::check()) {
        return redirect()->route('home');
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

    // ✅ After signup, go to login page (NOT logged in automatically)
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
    return redirect('/home'); // goes straight back to public home
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES (NO LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/home');
Route::view('/home', 'home')->name('home');
Route::view('/menu', 'menu')->name('menu');
Route::view('/history', 'history')->name('history');

// 🏠 HOME PAGE
Route::get('/home', function () {
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.home', ['username' => $username]);
    }
    return view('home');
})->name('home');

// 🍔 MENU PAGE
Route::get('/menu', function () {
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.menu', ['username' => $username]);
    }
    return view('menu');
})->name('menu');

// 🕓 HISTORY PAGE
Route::get('/history', function () {
    if (Auth::check()) {
        $username = strtolower(Auth::user()->name);
        return redirect()->route('user.history', ['username' => $username]);
    }
    return view('history');
})->name('history');

/*
|--------------------------------------------------------------------------
| AUTH DASHBOARDS (ADMIN / DRIVER)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::view('/admin.dashboard', 'admin.dashboard')->name('admin.dashboard');
    Route::view('/driver.dashboard', 'driver.dashboard')->name('driver.dashboard');

    Route::redirect('/settings', '/settings/profile');
    Volt::route('/settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('/settings/password', 'settings.password')->name('password.edit');
    Volt::route('/settings/appearance', 'settings.appearance')->name('appearance.edit');
    Volt::route('/settings/two-factor', 'settings.two-factor')->name('two-factor.show');
});

/*
|--------------------------------------------------------------------------
| USER-SPECIFIC DASHBOARD (/username/home etc.)
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
| DEBUG AUTH STATE (OPTIONAL)
|--------------------------------------------------------------------------
*/
Route::get('/debug-auth', function () {
    return [
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
    ];
});
>>>>>>> 9274150457084e72d569d3ae769f1817318a4c10
