<?php

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sk\Geo\GeoServiceProvider;
use Sk\Geo\Facades\Geo;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            GeoServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'geo' => Geo::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $geo = include(dirname(__FILE__)."/../config/geo.php");
        $app['config']->set('geo', $geo);
        $app['config']->set('swap', [
            'services' => [
                'array' => [
                    'EUR/RON' => 4.63,
                ],
            ],
        ]);
    }
}
