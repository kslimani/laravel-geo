<?php

namespace Tests;

class MaxmindLocationTest extends TestCase
{
    protected $location;

    protected function setUp()
    {
        parent::setUp();
        $this->location = app('geo.location');
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
