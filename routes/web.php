<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Redirect the root (/) to /home
Route::redirect('/', '/home');
Route::view('/home', 'home')->name('home');

// Redirect the root (/) to /history
Route::redirect('/', '/history');
Route::view('/history', 'history')->name('history');

// Redirect the root (/) to /menu
Route::redirect('/', '/menu');
Route::view('/menu', 'menu')->name('menu');

// Redirect the root (/) to /signup
Route::redirect('/', '/signup');
Route::view('/signup', 'signup')->name('signup');

// Redirect the root (/) to /admin.dashboardnup
Route::redirect('/', '/admin.dashboard');
Route::view('/admin.dashboard', 'admin.dashboard')->name('admin.dashboard');

// Redirect the root (/) to /driver.dashboardnup
Route::redirect('/', '/driver.dashboard');
Route::view('/driver.dashboard', 'driver.dashboard')->name('driver.dashboard');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    // Settings redirect and subroutes
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

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';

