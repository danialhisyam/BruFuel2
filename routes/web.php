<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

// ✅ Show Login Page
Route::get('/login', function () {
    return view('login');
})->name('login');

// ✅ Process Login (handled by AuthController)
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// ✅ Show Signup Page
Route::view('/signup', 'signup')->name('signup');

// ✅ Process Signup Form
Route::post('/signup', function () {
    $name = request('name');
    $email = request('email');
    $password = request('password');
    $confirm = request('password_confirmation');

    if (!$name || !$email || !$password || $password !== $confirm) {
        return back()->with('error', 'Invalid input.');
    }

    // ✅ Check if email already exists
    if (DB::table('users')->where('email', $email)->exists()) {
        return back()->with('email_error', 'This email is already registered.')->withInput();
    }

    // ✅ Insert user
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

    // ✅ Settings Routes (Volt)
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
