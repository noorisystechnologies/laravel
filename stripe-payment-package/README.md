# Laravel Stripe Payment Integration Package

[![Latest Stable Version](http://poser.pugx.org/phpunit/phpunit/v)](https://packagist.org/packages/phpunit/phpunit) [![Total Downloads](http://poser.pugx.org/phpunit/phpunit/downloads)](https://packagist.org/packages/phpunit/phpunit) [![Latest Unstable Version](http://poser.pugx.org/phpunit/phpunit/v/unstable)](https://packagist.org/packages/phpunit/phpunit) [![License](http://poser.pugx.org/phpunit/phpunit/license)](https://packagist.org/packages/phpunit/phpunit) [![PHP Version Require](http://poser.pugx.org/phpunit/phpunit/require/php)](https://packagist.org/packages/phpunit/phpunit)

## Installation
Require this package, with [Composer](https://packagist.org/), in the root directory of your project.

```bash
$ composer require noorisys/stripe-payment
```

Add the service provider to `config/app.php` in the `providers` array.

```php
Noorisys\StripePayment\Providers\StripePaymentServiceProvider::class,
```

## Configuration

Laravel Stripe requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="Noorisys\StripePayment\Providers\StripePaymnetServiceProvider" --force
```

This will create a `config/stripe.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

You are free to change the configuration file as needed, but the default expected values are below:

```php
    'STRIPE_KEY' => env('STRIPE_KEY'),
    'STRIPE_SECRET' => env('STRIPE_SECRET'),
    'STRIPE_CURRENCY' => env('STRIPE_CURRENCY'),
```

#### Run APIs on Postman

import postman collection via link and run APIs 
```
https://api.postman.com/collections/18476697-0daf72f8-89a5-4a08-a382-8846c7c4c2c0?access_key=PMAT-01GVYPDJMC37HEPYGJYF7ZKED2
```

