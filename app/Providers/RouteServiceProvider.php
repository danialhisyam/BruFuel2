<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Laravel\Fortify\Fortify;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        // ✅ Ensure Fortify uses your custom Blade login view
        Fortify::loginView(function () {
            return view('auth.login');
        });

        // No need to "forget" the route manually anymore
        // because Fortify will use this Blade instead of Livewire automatically.

        $this->routes(function () {
            require base_path('routes/web.php');
        });
    }
}
