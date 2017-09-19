<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Locale
    |--------------------------------------------------------------------------
    |
    | 'base_path' is data list files base path.
    */

    'locale' => [
        'base_path' => 'vendor/umpirsky',
    ],

    /*
    |--------------------------------------------------------------------------
    | Location
    |--------------------------------------------------------------------------
    |
    | 'maxmind' is GeoIP2 .mmdb database files. (Set to false or empty
    | string to disable).
    */

    'location' => [
        'maxmind' => [
            'country' => env('GEOIP_COUNTRY', false),
            'city' => env('GEOIP_CITY', false),
            'isp' => env('GEOIP_ISP', false),
        ],
    ],

];
