<?php

namespace Noorisys\PaypalSubscription\Providers;

use Illuminate\Support\ServiceProvider;

class PaypalSubscriptionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // load helper
        require_once __DIR__.'/../Helpers/invoicePdfHelper.php';

        // load routes
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        
        // load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // load view
        $this->loadViewsFrom(__DIR__.'/../resources/views','paypalSubscription');

        // load translations
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'paypalSubscription');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
            __DIR__.'/../database/seeders' => database_path('seeders'),
            __DIR__.'/../routes' => base_path('routes'),
            __DIR__.'/../config/paypal.php' => config_path('paypal.php'),
            __DIR__.'/../resources/lang' => lang_path(),
            __DIR__.'/../resources/views' => resource_path('views'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/paypal.php', 'paypalSubscription'
        );
    }
}