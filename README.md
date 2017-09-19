# Laravel Geo

A simple service provider to work with locales, countries and currencies.

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
