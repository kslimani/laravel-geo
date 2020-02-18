![](https://github.com/kslimani/laravel-geo/workflows/Integration%20tests/badge.svg)

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

Publish the [configuration file](https://github.com/kslimani/laravel-geo/blob/master/config/geo.php) `config/geo.php` :

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

// Decompose money amount
$keyValueArray = Geo::money()->decompose($fiveDollars);
// [
//   "locale" => "en"
//   "subunit" => 2
//   "sign" => "+"
//   "unsigned_part" => "5"
//   "decimal_part" => "00"
//   "grouping_separator" => ","
//   "decimal_separator" => "."
//   "symbol" => "$"
// ]

// Get all countries (country code -> name associative array)
$countries = Geo::locale()->countries();

// Get all languages (language code -> name associative array)
$languages = Geo::locale()->languages();

// Get all currencies (currency code -> name associative array)
$currencies = Geo::locale()->currencies();

// All methods returning a name accept an optional locale (default is application locale)
Geo::locale()->country('US', 'es');      // 'Estados Unidos'
Geo::locale()->language('en', 'de')      // 'Englisch'
Geo::locale()->currency('USD', 'ru')     // 'Доллар США'
Geo::locale()->countries('zh')           // [ 'BT' => '不丹', 'TL' => '东帝汶', ... ]
Geo::money()->format($fiveDollars, 'fr') // '5,00 $US'
Geo::money()->decompose($amount, 'fr');  // [ 'locale' => 'fr', ... ]

// Get instances using app helper
$location =  app('geo.location');
$locale = app('geo.locale');
$money = app('geo.money');
```

## Console commands

This package also provides some Artisan console commands :

```
geo:exchange          Simple currency converter
geo:info              Display geo data for ip address
geo:list              Display countries with default language and currency
geo:maxmind           Display Maxmind DB countries with matched geo country name
```

Note: `geo:list` and `geo:maxmind` are mainly used for package development.
