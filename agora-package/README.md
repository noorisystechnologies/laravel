# Laravel Package to Generate Agora Token

[![Latest Stable Version](http://poser.pugx.org/phpunit/phpunit/v)](https://packagist.org/packages/phpunit/phpunit) [![Total Downloads](http://poser.pugx.org/phpunit/phpunit/downloads)](https://packagist.org/packages/phpunit/phpunit) [![Latest Unstable Version](http://poser.pugx.org/phpunit/phpunit/v/unstable)](https://packagist.org/packages/phpunit/phpunit) [![License](http://poser.pugx.org/phpunit/phpunit/license)](https://packagist.org/packages/phpunit/phpunit) [![PHP Version Require](http://poser.pugx.org/phpunit/phpunit/require/php)](https://packagist.org/packages/phpunit/phpunit)

## Installation
Require this package, with [Composer](https://packagist.org/), in the root directory of your project.

```bash
$ composer require noorisys/agora
```

Add the service provider to `config/app.php` in the `providers` array.

```php
Noorisys\Agora\Providers\AgoraServiceProvider::class,
```

## Configuration

Laravel Agora requires connection configuration. To get started, you'll need to publish all vendor assets:

```bash
$ php artisan vendor:publish --provider="Noorisys\Agora\Providers\AgoraServiceProvider"
```

This will create a `config/agora.php` file in your app that you can modify to set your configuration. Also, make sure you check for changes to the original config file in this package between releases.

You are free to change the configuration file as needed, but the default expected values are below:

```php
'AGORA_APP_ID' => env('AGORA_APP_ID'),
'AGORA_APP_CERTIFICATE' => env('AGORA_APP_CERTIFICATE'),
```

#### Run APIs on Postman

import postman collection via link and run APIs 
```
https://api.postman.com/collections/18476697-81f4d51c-8779-4fcb-92f6-45fba7714cda?access_key=PMAT-01GW73S1B84WRF79TGNTWVW8KV
```

