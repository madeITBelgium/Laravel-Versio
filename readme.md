# PHP Laravel Versio
[![Build Status](https://travis-ci.org/madeITBelgium/Laravel-Versio.svg?branch=master)](https://travis-ci.org/madeITBelgium/Laravel-Versio)
[![Coverage Status](https://coveralls.io/repos/github/madeITBelgium/Laravel-Versio/badge.svg?branch=master)](https://coveralls.io/github/madeITBelgium/Laravel-Versio?branch=master)
[![Maintainability](https://api.codeclimate.com/v1/badges/a02d5ce31bccce094068/maintainability)](https://codeclimate.com/github/madeITBelgium/Laravel-Versio/maintainability)
[![Latest Stable Version](https://poser.pugx.org/madeITBelgium/Laravel-Versio/v/stable.svg)](https://packagist.org/packages/madeITBelgium/Laravel-Versio)
[![Latest Unstable Version](https://poser.pugx.org/madeITBelgium/Laravel-Versio/v/unstable.svg)](https://packagist.org/packages/madeITBelgium/Laravel-Versio)
[![Total Downloads](https://poser.pugx.org/madeITBelgium/Laravel-Versio/d/total.svg)](https://packagist.org/packages/madeITBelgium/Laravel-Versio)
[![License](https://poser.pugx.org/madeITBelgium/Laravel-Versio/license.svg)](https://packagist.org/packages/madeITBelgium/Laravel-Versio)

With this Laravel package you can connect to your vesta cp server.

# Installation
Install the package through composer
```php
composer require madeitbelgium/laravel-versio
```

Require this package in your `composer.json` and update composer.

```php
"madeitbelgium/laravel-versio": "0.*"
```

## On laravel Version < 5.5
updating composer, add the ServiceProvider to the providers array in `config/app.php`

```php
MadeITBelgium\Versio\VersioServiceProvider::class,
```

You can use the facade for shorter code. Add this to your aliases:

```php
'Versio' => MadeITBelgium\Versio\VersioFacade::class,
```
## On laravel version >= 5.5
The service provider is auto loaded.

# Documentation
## Usage
```php

use MadeITBelgium\Versio\Versio;

$versio = new Versio($email, $password, null, $test);

```

In laravel you can use the Facade
```php

$domains = Versio::domain()->all();

```

## Laraval validator
```php
public function store(Request $request) {
    $this->validate($request, ['domainname' => 'domainavailable']);
}
```

The complete documentation can be found at: [http://www.madeit.be/](http://www.madeit.be/)

# Support

Support github or mail: tjebbe.lievens@madeit.be

# Contributing

Please try to follow the psr-2 coding style guide. http://www.php-fig.org/psr/psr-2/
# License

This package is licensed under LGPL. You are free to use it in personal and commercial projects. The code can be forked and modified, but the original copyright author should always be included!
