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

Optionally, publish [Swap service provider configuration](https://github.com/florianv/laravel-swap/blob/master/doc/readme.md#configuration) file :

```bash
php artisan vendor:publish --provider="Swap\Laravel\SwapServiceProvider"
```

## Quick usage

```php
$location =  app('geo.location');
$locale = app('geo.locale');
$money = app('geo.money');

// Get country code from ip address (US)
$countryCode = app('geo.location')->ipCountry('8.8.8.8');

// Get country name (United States)
$countryName = $locale->country($countryCode);

// Get country language code (en)
$languageCode = $locale->countryLanguage($countryCode);

// Get country language name (English)
$languageName = $locale->language($languageCode);

// Get country currency code (USD)
$currencyCode = $locale->countryCurrency($countryCode);

// Get country currency name (US Dollar)
$currencyName = $locale->currency($currencyCode);

// Make money amount
$fiveDollars = $money->make('500', $currencyCode);

// Get amount converted to Euro
$euroAmount = $money->convert($fiveDollars, 'EUR');

// Get formatted amount
$formattedAmount = $money->format($euroAmount);

// Get all countries
$countries = $locale->countries();

// Get all languages
$languages = $locale->languages();

// Get all currencies
$currencies = $locale->currencies();
```
