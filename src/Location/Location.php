<?php

namespace Sk\Geo\Location;

interface Location
{
    /**
     * Get ISO 3166-1 country code.
     *
     * @param  string  $ip
     * @return string|null
     */
    public function ipCountry($ip);
}
