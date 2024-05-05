<?php

namespace GufronDev\AspiSnapBI;

use Illuminate\Support\ServiceProvider;

class AspiSnapBIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/snapbi.php', 'snapbi');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/snap.php' => config_path('snapbi.php'),
        ], 'snapbi-config');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }
}
