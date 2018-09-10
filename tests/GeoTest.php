<?php

namespace Tests;

use Sk\Geo\Locale;
use Sk\Geo\Location\MaxmindLocation;
use Sk\Geo\Money;

class GeoTest extends TestCase
{
    protected $geo;

    protected function setUp()
    {
        parent::setUp();
        $this->geo = app('geo');
    }

    public function test_it_access_by_methods()
    {
        $this->assertInstanceOf(Locale::class, $this->geo->locale());
        $this->assertInstanceOf(MaxmindLocation::class, $this->geo->location());
        $this->assertInstanceOf(Money::class, $this->geo->money());
    }

    public function test_it_access_by_properties()
    {
        $this->assertInstanceOf(Locale::class, $this->geo->locale);
        $this->assertInstanceOf(MaxmindLocation::class, $this->geo->location);
        $this->assertInstanceOf(Money::class, $this->geo->money);
    }
}
