<?php
namespace Aaisha\Stripe\Providers;

use Illuminate\Support\ServiceProvider;

class OmnistripeProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../views', 'payment');
        

    }
}