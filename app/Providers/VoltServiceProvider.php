<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Volt\Volt;

class VoltServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Debugging Volt paths
        file_put_contents(storage_path('logs/volt_debug.log'), "VoltServiceProvider booted.\n", FILE_APPEND);
        file_put_contents(storage_path('logs/volt_debug.log'), "Mounting: " . resource_path('views/livewire') . "\n", FILE_APPEND);
        
        Volt::mount([
            resource_path('views/livewire'),
            resource_path('views/pages'),
        ]);
    }
}
