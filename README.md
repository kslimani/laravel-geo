# Laravel Geo

A simple service provider to work with locales, countries and currencies.

It uses the following dependencies :

* [florianv/laravel-swap](https://github.com/florianv/laravel-swap)
* [kslimani/geo-list](https://github.com/kslimani/geo-list) (tiny version of umpirsky's projects)
* [maxmind/MaxMind-DB-Reader-php](https://github.com/maxmind/MaxMind-DB-Reader-php)
* [moneyphp/money](https://github.com/moneyphp/money)

## Installation

use Composer to add the package to your project's dependencies :

```bash
composer require kslimani/laravel-geo
```

Note: Swap uses [HTTPlug](http://httplug.io/) abstraction which may require additional dependencies. For example using Curl :

```bash
composer require php-http/curl-client nyholm/psr7 php-http/message
```

Optionally, adds the Geo facade in `config/app.php` :

```php
'aliases' => [
    // ...
    'Geo' => Sk\Geo\Facades\Geo::class,
];
```

Publish the configuration file :

```bash
php artisan vendor:publish --provider="Sk\Geo\GeoServiceProvider" --tag="config"
```

Optionally, publish [Swap service provider configuration](https://github.com/florianv/laravel-swap/blob/master/doc/readme.md#configuration) file :

```bash
php artisan vendor:publish --provider="Swap\Laravel\SwapServiceProvider"
```

## Quick usage

```php
use Sk\Geo\Facades\Geo;

// Get country code from ip address (US)
$countryCode = Geo::location()->ipCountry('8.8.8.8');

// Get country name (United States)
$countryName = Geo::locale()->country($countryCode);

// Get country language code (en)
$languageCode = Geo::locale()->countryLanguage($countryCode);

// Get country language name (English)
$languageName = Geo::locale()->language($languageCode);

// Get country currency code (USD)
$currencyCode = Geo::locale()->countryCurrency($countryCode);

// Get country currency name (US Dollar)
$currencyName = Geo::locale()->currency($currencyCode);

// Make money amount
$fiveDollars = Geo::money()->make('500', $currencyCode);

// Get amount converted to Euro
$euroAmount = Geo::money()->convert($fiveDollars, 'EUR');

// Get formatted amount ("Intl" formatter)
$intlFormattedAmount = Geo::money()->format($euroAmount);

// Get formatted amount ("Decimal" formatter)
$decFormattedAmount = Geo::money()->formatDec($euroAmount);

// Parse "Decimal" formatted amount
$newEuroAmount = Geo::money()->parse($decFormattedAmount, 'EUR');

// Get all countries
$countries = Geo::locale()->countries();

// Get all languages
$languages = Geo::locale()->languages();

// Get all currencies
$currencies = Geo::locale()->currencies();

// Get instances using app helper
$location =  app('geo.location');
$locale = app('geo.locale');
$money = app('geo.money');
```
