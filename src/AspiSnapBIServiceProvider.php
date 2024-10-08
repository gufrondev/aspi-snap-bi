<?php

namespace GufronDev\AspiSnapBI;

use Illuminate\Support\ServiceProvider;

class AspiSnapBIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/snapbi.php', 'snapbi');
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('snapbi.php'),
        ], 'aspi-snap-bi');

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
    }
}
