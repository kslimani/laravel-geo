<?php

return [

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
