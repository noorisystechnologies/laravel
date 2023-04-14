# Laravel PayPal Subscription Package

[![Latest Stable Version](http://poser.pugx.org/phpunit/phpunit/v)](https://packagist.org/packages/phpunit/phpunit) [![Total Downloads](http://poser.pugx.org/phpunit/phpunit/downloads)](https://packagist.org/packages/phpunit/phpunit) [![Latest Unstable Version](http://poser.pugx.org/phpunit/phpunit/v/unstable)](https://packagist.org/packages/phpunit/phpunit) [![License](http://poser.pugx.org/phpunit/phpunit/license)](https://packagist.org/packages/phpunit/phpunit) [![PHP Version Require](http://poser.pugx.org/phpunit/phpunit/require/php)](https://packagist.org/packages/phpunit/phpunit)

## Installation
Require this package, with [Composer](https://packagist.org/), in the root directory of your project.

```bash
$ composer require noorisys/paypal-subscription
```

Add the service provider to `config/app.php` in the `providers` array.

```php
Noorisys\PaypalSubscription\Providers\PaypalSubscriptionServiceProvider::class,
```

## Configuration

Laravel PayPal requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="Noorisys\PaypalSubscription\Providers\PaypalSubscriptionServiceProvider" --force
```

This will create a `config/paypal.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

You are free to change the configuration file as needed, but the default expected values are below:

```php
    'mode'    => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'            => 'APP-80W284485P519543T',
    ],
    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
    ],
```

#### Run APIs on Postman

import postman collection via link and run APIs 
```
https://api.postman.com/collections/18476697-7e81ea1c-7d1e-4965-9953-b25b40ebaf25?access_key=PMAT-01GVFRSKHNB4F5RY2CWY4G75YG
```

