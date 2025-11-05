<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Custom Views
        |--------------------------------------------------------------------------
        */
        Fortify::loginView(fn () => view('auth.login'));
        Fortify::registerView(fn () => view('auth.register'));

        /*
        |--------------------------------------------------------------------------
        | Redirect After Login
        |--------------------------------------------------------------------------
        */
        Fortify::redirects('login', '/redirect-dashboard');
        Fortify::redirects('register', '/login');

        /*
        |--------------------------------------------------------------------------
        | Rate Limiting (⚙ required)
        |--------------------------------------------------------------------------
        | Fortify expects a "login" limiter; this defines it safely.
        */
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        /*
        |--------------------------------------------------------------------------
        | Default Fortify Views (optional)
        |--------------------------------------------------------------------------
        */
        Fortify::twoFactorChallengeView(fn () => view('livewire.auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn () => view('livewire.auth.confirm-password'));
    }
}




