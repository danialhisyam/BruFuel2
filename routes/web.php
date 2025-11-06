<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;

// Livewire settings
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
| NOTE: If you want a custom landing page instead of redirecting to /login,
| change the first line to: Route::view('/', 'ComapnySelectection')->name('welcome');
*/
Route::view('/','/mobile/home')->name('home');

// Fortify custom views MUST be registered before auth routes
Fortify::loginView(fn () => view('auth.login'));
if (Features::enabled(Features::registration())) {
    Fortify::registerView(fn () => view('auth.register'));
}

// Guest-only pages
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');

    if (Features::enabled(Features::registration())) {
        Route::get('/register', fn () => view('auth.register'))->name('register');
    }
});

// Fortify endpoints (login, register, logout, reset, etc.)
require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Post-login, role-aware redirect
|--------------------------------------------------------------------------
*/
Route::get('/redirect-dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->hasRole('driver')) {
        return redirect()->route('driver.trips');
    }
    if ($user->hasRole('customer')) {
        return redirect()->route('mobile.home');
    }

    abort(403, 'No role assigned.');
})->middleware('auth')->name('redirect.dashboard');

// Stable alias used by many libs
Route::get('/dashboard', fn () => redirect()->route('redirect.dashboard'))
    ->middleware('auth')
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin (auth + role:admin)
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
| Driver
| - Keeps your custom driver login controller/routes under /driver/*
| - Driver pages themselves require the 'driver' role.
|--------------------------------------------------------------------------
*/
// Legacy .html redirects
Route::redirect('/driver/trips.html', '/driver/trips', 301);
Route::redirect('/driver/transactions.html', '/driver/transactions', 301);
Route::redirect('/driver/index.html', '/driver/dashboard', 301);
Route::redirect('/driver/dashboard.html', '/driver/dashboard', 301);
Route::redirect('/driver/login.html', '/driver/login', 301);

// Driver auth pages (public)
Route::prefix('driver')->name('driver.')->group(function () {
    Route::get('/login', [App\Http\Controllers\Driver\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [App\Http\Controllers\Driver\AuthController::class, 'login'])->name('login.submit');
});

// Driver protected pages
Route::middleware(['auth', 'role:driver'])
    ->prefix('driver')
    ->name('driver.')
    ->group(function () {
        Route::view('/dashboard', 'driver.transactions.index')->name('dashboard');
        Route::view('/trips', 'driver.trips.index')->name('trips');
        Route::view('/transactions', 'driver.transactions.index')->name('transactions');
    });

/*
|--------------------------------------------------------------------------
| Customer (mobile) — auth + role:customer
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:customer'])
    ->prefix('mobile')
    ->name('mobile.')
    ->group(function () {
        Route::view('/home',     'mobile.home')->name('home');
        Route::view('/dashboard','mobile.dashboard')->name('dashboard'); // ensure file exists at resources/views/mobile/dashboard.blade.php
        Route::view('/history',  'mobile.history')->name('history');
        Route::view('/login',    'mobile.login')->name('login');
        Route::view('/menu',     'mobile.menu')->name('menu');
        Route::view('/signup',   'mobile.signup')->name('signup');        // rename from 'sign' -> 'signup'
        Route::view('/welcome',  'mobile.welcome')->name('welcome');
    });

/*
|--------------------------------------------------------------------------
| Shared Settings (any authenticated user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Conditionally require password.confirm for 2FA page
    Route::get('settings/two-factor', TwoFactor::class)
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
| Testing + Chat (open)
|--------------------------------------------------------------------------
*/
Route::prefix('testing')->name('testing.')->group(function () {
    Route::view('/testing', 'Testing.Test1')->name('page');
    Route::view('/admin', 'testing.AdminChat')->name('chat.admin');
    Route::view('/driver', 'testing.DriverChat')->name('chat.driver');
});

/*
|--------------------------------------------------------------------------
| For Auth Login
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->name('auth.')->group(function () {
    Route::redirect('/login', 'auth.login')->name('login');
    Route::view('/register', 'auth.register')->name('register');
    Route::view('/forgot-password', 'auth.forgot-password')->name('forgot-password');
});



/*
|--------------------------------------------------------------------------
| Utilities (dev)
|--------------------------------------------------------------------------
*/
Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/login');
});

// Legacy driver redirects that point to public login or protected dashboard
Route::redirect('/driver/login.html', '/driver/login', 301);

use App\Http\Controllers\Admin\PaymentController;
Route::get('/admin/payments', [PaymentController::class, 'index'])->name('admin.payments');

Route::prefix('admin')->group(function () {
Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments');
    Route::get('/payments/export/csv',   [PaymentController::class, 'exportCsv'])->name('admin.payments.export.csv');
    Route::get('/payments/export/excel', [PaymentController::class, 'exportExcel'])->name('admin.payments.export.excel');
    });

    // routes/web.php
use App\Http\Controllers\Admin\DriverController;

Route::get('/admin/drivers', [DriverController::class,'index'])->name('admin.drivers.index');
Route::get('/admin/drivers/{driver}', [DriverController::class,'show'])->name('admin.drivers.show');
Route::put('/admin/drivers/{driver}', [DriverController::class,'update'])->name('admin.drivers.update');
Route::delete('/admin/drivers/{driver}', [DriverController::class,'destroy'])->name('admin.drivers.destroy');

// routes/web.php

Route::prefix('admin')->name('admin.')->group(function () {
  Route::get('/drivers', [\App\Http\Controllers\Admin\DriverController::class,'index'])->name('drivers.index');
  Route::get('/drivers/{driver}', [\App\Http\Controllers\Admin\DriverController::class,'show'])->name('drivers.show');
  Route::post('/drivers', [\App\Http\Controllers\Admin\DriverController::class,'store'])->name('drivers.store');
  Route::put('/drivers/{driver}', [\App\Http\Controllers\Admin\DriverController::class,'update'])->name('drivers.update');
  Route::delete('/drivers/{driver}', [\App\Http\Controllers\Admin\DriverController::class,'destroy'])->name('drivers.destroy');
});

Route::middleware(['auth','role:admin'])
    ->prefix('admin')->name('admin.')
    ->group(function () {
        // keep the page route
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        // NEW: data route for your table
        Route::get('/users/data', [UserController::class, 'data'])->name('users.data');
    });

    // routes/web.php
// routes/web.php
use App\Http\Controllers\Admin\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});

// routes/web.php
Route::prefix('admin')->name('admin.')->group(function () {
  Route::get('/drivers/{driver}',  [DriverController::class, 'show'])->name('drivers.show');
  Route::put('/drivers/{driver}',  [DriverController::class, 'update'])->name('drivers.update');
});

// routes/web.php
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('drivers', App\Http\Controllers\Admin\DriverController::class);
});


