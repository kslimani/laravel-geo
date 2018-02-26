<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\CreatesConfig;
use Money\Exchange\SwapExchange;
use Sk\Geo\Geo;
use Sk\Geo\Locale;
use Sk\Geo\Location\MaxmindLocation;
use Sk\Geo\Money;
use Swap\Builder;

class GeoTest extends TestCase
{
    use CreatesConfig;

    protected $geo;

    protected function setUp()
    {
        $basePath = realpath(__DIR__.'/../');
        $config = $this->CreateConfig();
        $exchange = new SwapExchange((new Builder())->add('fixer')->build());

        $this->geo = new Geo(
            new Locale($config, $basePath),
            new MaxmindLocation($config),
            new Money($config, $exchange)
        );
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
