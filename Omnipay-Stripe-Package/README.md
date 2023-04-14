# Omnipay-Stripe-Package
[![Latest Stable Version](http://poser.pugx.org/phpunit/phpunit/v)](https://packagist.org/packages/phpunit/phpunit) [![Total Downloads](http://poser.pugx.org/phpunit/phpunit/downloads)](https://packagist.org/packages/phpunit/phpunit) [![Latest Unstable Version](http://poser.pugx.org/phpunit/phpunit/v/unstable)](https://packagist.org/packages/phpunit/phpunit) [![License](http://poser.pugx.org/phpunit/phpunit/license)](https://packagist.org/packages/phpunit/phpunit) [![PHP Version Require](http://poser.pugx.org/phpunit/phpunit/require/php)](https://packagist.org/packages/phpunit/phpunit)

## Installation
Require this package, with [Composer](https://packagist.org/), in the root directory of your project.

```bash
$ composer require aaisha/stripe
```

Add the service provider to `config/app.php` in the `providers` array.

```php
        Aaisha\Stripe\Providers\OmnistripeProvider::class,
```

## Configuration

Laravel requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="Omnipay\Aaisha\Stripe\Providers\OmnistripeProvider"
```

You are free to change the configuration file as needed, but the default expected values are below in .env file:

```php
STRIPE_PUBLISHABLE_KEY="Your Publishable Key"
STRIPE_SECRET_KEY="Your Secret Key"
STRIPE_CURRENCY=INR
```

#### Run The Project

```
http://127.0.0.1:8000/payment
```
