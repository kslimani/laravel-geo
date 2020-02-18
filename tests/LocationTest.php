<?php

namespace Tests;

use Sk\Geo\Location\Location as LocationContract;

class LocationTest extends TestCase
{
    public function test_it_can_change_default_location()
    {
        $this->app['config']->set('geo.defaults.location', CustomLocation::class);

        $code = $this->app->make('geo.location')->ipCountry('8.8.8.8');
        $this->assertSame('AQ', $code);
    }

    public function test_it_is_backward_compatible()
    {
        $this->app['config']->set('geo.defaults', null); // Will default to MaxmindLocation

        $code = $this->app->make('geo.location')->ipCountry('8.8.8.8');
        $this->assertSame('US', $code);
    }
}

class CustomLocation implements LocationContract
{
    /**
     * {@inheritdoc}
     */
    public function ipCountry($ip)
    {
        return 'AQ'; // Antarctica
    }
}
