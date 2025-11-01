<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Laravel\Fortify\Features;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// 🚀 Default landing page redirects straight to login
Route::get('/', fn() => redirect('/login'));

/*
|--------------------------------------------------------------------------
| Custom Fortify Views (Login + Register)
|--------------------------------------------------------------------------
| These override Fortify’s default pages to use your custom Blade files.
| They MUST come before `require __DIR__.'/auth.php';`
*/
Fortify::loginView(fn() => view('auth.login'));
Fortify::registerView(fn() => view('auth.register'));

Route::get('/login', fn() => view('auth.login'))
    ->middleware('guest')
    ->name('login');

Route::get('/register', fn() => view('auth.register'))
    ->middleware('guest')
    ->name('register');

/*
|--------------------------------------------------------------------------
| Include Fortify authentication routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Redirect users to their role dashboards after login
|--------------------------------------------------------------------------
*/
Route::get('/redirect-dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('driver')) {
        return redirect()->route('driver.dashboard');
    } elseif ($user->hasRole('customer')) {
        return redirect()->route('mobile.dashboard.logged');
    }

    abort(403, 'No role assigned.');
})->middleware('auth')->name('redirect.dashboard');

/*
|--------------------------------------------------------------------------
| Default /dashboard redirects to correct role-based dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', fn() => redirect()->route('redirect.dashboard'))
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes (protected by role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
        Route::view('/users', 'admin.manage-user')->name('users.index');
        Route::view('/orders', 'admin.manage-order')->name('order.index');
        Route::view('/drivers', 'admin.manage-drivers')->name('drivers.index');
        Route::view('/payments', 'admin.payment')->name('payments.index');
    });

/*
|--------------------------------------------------------------------------
| Driver Routes (protected by role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:driver'])
    ->prefix('driver')
    ->name('driver.')
    ->group(function () {
        Route::view('/dashboard', 'driver.dashboard')->name('dashboard');
        Route::view('/trips', 'driver.trips.index')->name('trips');
        Route::view('/transactions', 'driver.transactions.index')->name('transactions');
    });

/*
|--------------------------------------------------------------------------
| Customer Routes (protected by role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->prefix('mobile')
    ->name('mobile.')
    ->group(function () {
        Route::view('/dashboardlogged', 'mobile.screens.dashboardlogged')->name('dashboard.logged');
        Route::view('/dashboard1', 'mobile.screens.dashboard1')->name('dashboard1');
    });

/*
|--------------------------------------------------------------------------
| Shared User Settings (for all authenticated users)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

/*
|--------------------------------------------------------------------------
| Force Logout (for testing)
|--------------------------------------------------------------------------
*/
Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| Legacy Redirects (optional)
|--------------------------------------------------------------------------
*/
Route::redirect('/driver/dashboard.html', '/driver/dashboard', 301);
Route::redirect('/driver/login.html', '/login', 301);

