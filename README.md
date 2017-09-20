# Laravel Geo

A simple service provider to work with locales, countries and currencies.

It uses the following dependencies :

* [florianv/laravel-swap](https://github.com/florianv/laravel-swap)
* [maxmind/MaxMind-DB-Reader-php](https://github.com/maxmind/MaxMind-DB-Reader-php)
* [moneyphp/money](https://github.com/moneyphp/money)
* [umpirsky/country-list](https://github.com/umpirsky/country-list)
* [umpirsky/currency-list](https://github.com/umpirsky/currency-list)
* [umpirsky/language-list](https://github.com/umpirsky/language-list)

## Installation

Adds the service provider in `config/app.php` :

```php
'providers' => [
    // ...
    Sk\Geo\GeoServiceProvider::class,
];
```

Publish the configuration file :

```bash
php artisan vendor:publish --provider="Sk\Geo\GeoServiceProvider" --tag="config"
```
