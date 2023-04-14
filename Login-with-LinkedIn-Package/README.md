# LinkedIn-login-Package

[![Latest Stable Version](http://poser.pugx.org/phpunit/phpunit/v)](https://packagist.org/packages/phpunit/phpunit) [![Total Downloads](http://poser.pugx.org/phpunit/phpunit/downloads)](https://packagist.org/packages/phpunit/phpunit) [![Latest Unstable Version](http://poser.pugx.org/phpunit/phpunit/v/unstable)](https://packagist.org/packages/phpunit/phpunit) [![License](http://poser.pugx.org/phpunit/phpunit/license)](https://packagist.org/packages/phpunit/phpunit) [![PHP Version Require](http://poser.pugx.org/phpunit/phpunit/require/php)](https://packagist.org/packages/phpunit/phpunit)

## Installation
Require this package, with [Composer](https://packagist.org/), in the root directory of your project.

```bash
$ composer require socialogin/linkedin
```

Add the service provider to `config/app.php` in the `providers` array.

```php
 Socialogin\Linkedin\Providers\LinkedInLoginProvider::class,
```

## Configuration

Laravel requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider=" Socialogin\Linkedin\Providers\LinkedInLoginProvider"
```

You are free to change the configuration file as needed, but the default expected values are below in .env file:

```php
LINKEDIN_CLIENT_ID="your cllient key"
LINKEDIN_CLIENT_SECRET="your client secret id" 
```

Add oauth_id and oauth_type column in Users table
and linkedIn login button on login page and assign the route as "url('auth/linkedin')".
