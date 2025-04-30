<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('isAdmin', function ($user) {
            return $user->role->slug === 'admin';
        });
        Gate::define('isCustomer', function ($user) {
            return $user->role->slug === 'customer';
        });
        Gate::define('isAdminOrCustomer', function ($user) {
            return $user->role->slug === 'admin' || $user->role->slug === 'customer';
        });
    }
}
