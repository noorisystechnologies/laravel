<?php

namespace Noorisys\Agora\Providers;

use Illuminate\Support\ServiceProvider;

class AgoraServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // load helper
        require_once __DIR__.'/../Helpers/HelperFunctions.php';

        // publish agora.php config file
        $this->publishes([
            __DIR__.'/../config/agora.php' => config_path('agora.php'),
        ]);
        
        // publish migrations
        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->publishes([
            __DIR__.'/../routes' => base_path('routes'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'agora');

        $this->publishes([
            __DIR__.'/../resources/lang' => lang_path(),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/agora.php', 'agora'
        );
    }
}