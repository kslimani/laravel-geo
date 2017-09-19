<?php

namespace Tests;

use Tests\CreatesConfig;
use Sk\Geo\Location\MaxmindLocation;

class MaxmindLocationTest extends \PHPUnit_Framework_TestCase
{
    use CreatesConfig;

    protected $location;

    protected function setUp()
    {
        $this->location = new MaxmindLocation($this->CreateConfig());
    }

    public function test_it_resolve_ip_country()
    {
        $code = $this->location->ipCountry('8.8.8.8');
        $this->assertSame('US', $code);
    }

    public function test_it_resolve_city()
    {
        $city = $this->location->city('172.217.19.227');
        $this->assertSame('Mountain View', $city);
    }

    public function test_it_resolve_isp()
    {
        $isp = $this->location->isp('8.8.8.8');
        $this->assertSame('Google Inc.', $isp);
    }

    public function test_it_resolve_asn()
    {
        $asn = $this->location->asn('8.8.8.8');
        $this->assertSame(15169, $asn);
    }
}
