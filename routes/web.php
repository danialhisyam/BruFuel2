<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

// ✅ Show Login Page
Route::view('/login', 'login')->name('login');

// ✅ Process Login (handled by controller)
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// ✅ Show Signup Page
Route::view('/signup', 'signup')->name('signup');

// ✅ Process Signup
Route::post('/signup', function () {
    $name = request('name');
    $email = strtolower(trim(request('email')));
    $password = request('password');
    $confirm = request('password_confirmation');

    // 1️⃣ Basic validation
    if (!$name || !$email || !$password || $password !== $confirm) {
        return back()->with('error', 'Please fill all fields correctly.');
    }

    // 2️⃣ Check if email exists
    if (DB::table('users')->where('email', $email)->exists()) {
        return back()->with('email_error', 'This email is already registered.')->withInput();
    }

    // 3️⃣ Create new user
    $userId = DB::table('users')->insertGetId([
        'name' => $name,
        'email' => $email,
        'password' => Hash::make($password),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 4️⃣ Auto-login
    Auth::loginUsingId($userId);
    session()->regenerate();

    // 5️⃣ Redirect based on email domain
    if (str_ends_with($email, '@admin.brufuel.bn')) {
        return redirect()->route('admin.dashboard');
    } elseif (str_ends_with($email, '@driver.brufuel.bn')) {
        return redirect()->route('driver.dashboard');
    } else {
        return redirect()->route('home');
    }
});

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

// ✅ Redirect root → home
Route::redirect('/', '/home');

// ✅ Public pages (accessible even if not logged in)
Route::view('/home', 'home')->name('home');
Route::view('/history', 'history')->name('history');
Route::view('/menu', 'menu')->name('menu');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED PAGES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // ✅ Admin Dashboard
    Route::view('/admin.dashboard', 'admin.dashboard')->name('admin.dashboard');

    // ✅ Driver Dashboard
    Route::view('/driver.dashboard', 'driver.dashboard')->name('driver.dashboard');

    // ✅ Default Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Settings (Volt Components)
    |--------------------------------------------------------------------------
    */
    Route::redirect('/settings', '/settings/profile');

    Volt::route('/settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('/settings/password', 'settings.password')->name('password.edit');
    Volt::route('/settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('/settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                []
            )
        )
        ->name('two-factor.show');
});
