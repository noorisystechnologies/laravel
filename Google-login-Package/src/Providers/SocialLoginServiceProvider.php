<?php

namespace Socailogin\Google\Providers;

use Illuminate\Support\ServiceProvider;

class SocialLoginServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Code to bootstrap your package
        
        // $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../views', 'SocialLogin');

    }

    public function register()
    {
        // Code to register your package's services
        $this->app->register(SocialLoginServiceProvider::class);
    }
}
