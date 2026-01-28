<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Load helpers
        if (file_exists(app_path('Helpers/helpers.php'))) {
            require_once app_path('Helpers/helpers.php');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        \Illuminate\Support\Facades\Gate::define('access-admin-panel', function (\App\Models\User $user) {
             return $user->isAdmin() || $user->isManager();
        });

        \Illuminate\Support\Facades\Gate::define('access-goals', function (\App\Models\User $user) {
             return $user->isAdmin() || !$user->isManager();
        });

        \Illuminate\Support\Facades\Gate::define('access-subscriptions', function (\App\Models\User $user) {
             return $user->isAdmin() || !$user->isManager();
        });

        \Illuminate\Support\Facades\Gate::define('manage-subscriptions', function (\App\Models\User $user) {
             return $user->isSuperAdmin();
        });

         \Illuminate\Support\Facades\Gate::define('manage-roles', function (\App\Models\User $user) {
             return $user->isSuperAdmin();
        });

        \Illuminate\Support\Facades\Gate::define('manage-everything', function (\App\Models\User $user) {
             return $user->isSuperAdmin();
        });
    }
}
