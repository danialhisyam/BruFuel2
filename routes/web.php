<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Laravel\Fortify\Fortify;
use Laravel\Fortify\Features;

// Livewire settings (class-based components)
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;

// Livewire Volt
use Livewire\Volt\Volt;

// Admin controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DriverController as AdminDriverController;
use App\Http\Controllers\Admin\OrderController;   // make sure this file exists

// Driver controllers
use App\Http\Controllers\Driver\AuthController as DriverAuthController;
use App\Http\Controllers\Driver\TransactionController as DriverTransactionController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
| NOTE: If you want a custom landing page instead of redirecting to /login,
| change the first line to: Route::view('/', 'CompanySelectection')->name('welcome');
*/
Route::get('/', function () {
    return view('loading');              // splash/loading screen
})->name('loading');

Route::get('/home', function () {
    return view('mobile.home');          // normal home page
})->name('home');

/*
|--------------------------------------------------------------------------
| Fortify (custom views must be registered before auth routes)
|--------------------------------------------------------------------------
*/
Fortify::loginView(fn () => view('auth.login'));
if (Features::enabled(Features::registration())) {
    Fortify::registerView(fn () => view('auth.register'));
}

/*
|--------------------------------------------------------------------------
| Guest-only pages
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('auth.login'))->name('login');

    if (Features::enabled(Features::registration())) {
        Route::get('/register', fn () => view('auth.register'))->name('register');

        // Custom Register POST -> create user, assign default role, then send to login
        Route::post('/register', function (Request $request) {
            $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
            ]);

            $user = \App\Models\User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('customer');

            return redirect('/login')->with('status', 'Account created successfully! Please log in.');
        })->name('register.post');
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
        // You can switch to 'driver.dashboard' if you have a separate dashboard view
        return redirect()->route('driver.dashboard');
    }

    // Default: customers (or any user without explicit role mapping) -> mobile.home
    return redirect()->route('mobile.home');
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
        // Dashboard via controller
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Static admin pages that are still Blade-only
        Route::view('/users', 'admin.manage-user')->name('users.index');
        Route::view('/orders', 'admin.manage-order')->name('order.index');

        // Users table data endpoint
        Route::get('/users/data', [UserController::class, 'data'])->name('users.data');

        // Payments (controller + exports)
        Route::get('/payments',              [PaymentController::class, 'index'])->name('payments');
        Route::get('/payments/export/csv',   [PaymentController::class, 'exportCsv'])->name('payments.export.csv');
        Route::get('/payments/export/excel', [PaymentController::class, 'exportExcel'])->name('payments.export.excel');

        // Drivers (full RESTful resource)
        Route::resource('drivers', AdminDriverController::class);

        // Stats (JSON) – handy if you want AJAX/Alpine later
    Route::get('/stats/users',   [UserController::class, 'count'])->name('stats.users');
    Route::get('/stats/drivers', [AdminDriverController::class, 'count'])->name('stats.drivers');
    Route::get('/stats/orders',  [OrderController::class, 'count'])->name('stats.orders');

    // (optional) resource pages
    Route::resource('users', UserController::class)->only(['index','show']);
    Route::resource('drivers', AdminDriverController::class)->only(['index','show']);
    Route::resource('orders', OrderController::class)->only(['index','show']);
});


    
/*
|--------------------------------------------------------------------------
| Driver
|--------------------------------------------------------------------------
*/
/// Legacy .html redirects
Route::redirect('/driver/trips.html', '/driver/trips', 301);
Route::redirect('/driver/transactions.html', '/driver/transactions', 301);
Route::redirect('/driver/index.html', '/driver/dashboard', 301);
Route::redirect('/driver/dashboard.html', '/driver/dashboard', 301);
Route::redirect('/driver/login.html', '/driver/login', 301);

// Driver auth pages (public)
Route::prefix('driver')->name('driver.')->group(function () {
    Route::get('/login', [DriverAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [DriverAuthController::class, 'login'])->name('login.submit');
});

// Driver protected pages
Route::middleware(['auth', 'role:driver'])
    ->prefix('driver')
    ->name('driver.')
    ->group(function () {
        Route::view('/dashboard', 'driver.dashboard')->name('dashboard');
        Route::view('/trips', 'driver.trips.index')->name('trips');
        
        // Transactions via controller (index + optional download)
        Route::get('/transactions', [DriverTransactionController::class, 'index'])->name('transactions');
        Route::get('/transactions/download', [DriverTransactionController::class, 'download'])->name('transactions.download');
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
        Route::view('/home',       'mobile.home')->name('home');
        Route::view('/dashboard',  'mobile.dashboard')->name('dashboard');
        Route::view('/history',    'mobile.history')->name('history');
        Route::view('/login',      'mobile.login')->name('login');
        Route::view('/menu',       'mobile.menu')->name('menu');
        Route::view('/signup',     'mobile.signup')->name('signup');
        Route::view('/welcome',    'mobile.welcome')->name('welcome');
    });

/*
|--------------------------------------------------------------------------
| Shared Settings (any authenticated user)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile',     Profile::class)->name('settings.profile');
    Route::get('settings/password',    Password::class)->name('settings.password');
    Route::get('settings/appearance',  Appearance::class)->name('settings.appearance');

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
    Route::view('/admin',   'testing.AdminChat')->name('chat.admin');
    Route::view('/driver',  'testing.DriverChat')->name('chat.driver');
});

/*
|--------------------------------------------------------------------------
| Auth extras (logout + forgot password)
|--------------------------------------------------------------------------
*/
// Logout (explicit POST endpoint)
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Forgot Password (Volt) – must NOT be in prefix('auth')
Volt::route('/forgot-password', 'auth.forgot-password')->name('password.request');

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

Route::get('/debug-auth', function () {
    return [
        'authenticated' => Auth::check(),
        'user' => Auth::user(),
    ];
});
