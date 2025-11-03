<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Volt::route('/signup', 'auth.signup')->name('signup');


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// ✅ When visiting root (brufuel.test), go to /home
Route::redirect('/', '/home');  // LABEL: Redirects to /home

// Public pages (no login required)
Route::view('/home', 'home')->name('home');          // LABEL: Goes to resources/views/home.blade.php
Route::view('/history', 'history')->name('history'); // LABEL: Goes to resources/views/history.blade.php
Route::view('/menu', 'menu')->name('menu');          // LABEL: Goes to resources/views/menu.blade.php
Route::view('/signup', 'signup')->name('signup');    // LABEL: Goes to resources/views/signup.blade.php

// Custom authentication routes
Route::view('/login', 'login')->name('login');       // LABEL: Goes to resources/views/login.blade.php

/*
|--------------------------------------------------------------------------
| Protected Routes (Require Login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Admin Dashboard
    Route::view('/admin.dashboard', 'admin.dashboard')->name('admin.dashboard');  // LABEL: Goes to resources/views/admin.dashboard.blade.php

    // Driver Dashboard
    Route::view('/driver.dashboard', 'driver.dashboard')->name('driver.dashboard'); // LABEL: Goes to resources/views/driver.dashboard.blade.php

    // User Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard'); // LABEL: Goes to resources/views/dashboard.blade.php

    // Settings pages
    Route::redirect('/settings', '/settings/profile'); // LABEL: Redirects to /settings/profile

    Volt::route('/settings/profile', 'settings.profile')->name('profile.edit');     // LABEL: Goes to Livewire Volt component
    Volt::route('/settings/password', 'settings.password')->name('password.edit');  // LABEL: Goes to Livewire Volt component
    Volt::route('/settings/appearance', 'settings.appearance')->name('appearance.edit'); // LABEL: Goes to Livewire Volt component

    Volt::route('/settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                []
            )
        )
        ->name('two-factor.show'); // LABEL: Goes to Livewire Volt component
});