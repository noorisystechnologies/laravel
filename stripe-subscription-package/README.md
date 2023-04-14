# Laravel Stripe Subscription Package

[![Latest Stable Version](http://poser.pugx.org/phpunit/phpunit/v)](https://packagist.org/packages/phpunit/phpunit) [![Total Downloads](http://poser.pugx.org/phpunit/phpunit/downloads)](https://packagist.org/packages/phpunit/phpunit) [![Latest Unstable Version](http://poser.pugx.org/phpunit/phpunit/v/unstable)](https://packagist.org/packages/phpunit/phpunit) [![License](http://poser.pugx.org/phpunit/phpunit/license)](https://packagist.org/packages/phpunit/phpunit) [![PHP Version Require](http://poser.pugx.org/phpunit/phpunit/require/php)](https://packagist.org/packages/phpunit/phpunit)

## Installation
Require this package, with [Composer](https://packagist.org/), in the root directory of your project.

```bash
$ composer require noorisys/stripe-subscription
```

Add the service provider to `config/app.php` in the `providers` array.

```php
Noorisys\StripeSubscription\Providers\StripeSubscriptionServiceProvider::class,
```

## Configuration

Laravel Stripe requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="Noorisys\StripeSubscription\Providers\StripeSubscriptionServiceProvider" --force
```

This will create a `config/stripe.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

You are free to change the configuration file as needed, but the default expected values are below:

```php
    'STRIPE_KEY' => env('STRIPE_KEY'),
    'STRIPE_SECRET' => env('STRIPE_SECRET'),
    'STRIPE_CURRENCY' => env('STRIPE_CURRENCY'),
    'STRIPE_WEBHOOK_SECRET' => env('STRIPE_WEBHOOK_SECRET'),
```

#### Run APIs on Postman

import postman collection via link and run APIs 
```
https://api.postman.com/collections/18476697-2b8e4239-4264-4c5b-9ead-217e9242ef10?access_key=PMAT-01GVQH1D3EWJP761ESNDPP9J2D
```

