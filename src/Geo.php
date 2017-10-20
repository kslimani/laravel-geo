<?php

namespace Sk\Geo;

use Sk\Geo\Location\Location;

class Geo
{
    /**
     * @var \SK\Geo\Locale
     */
    public $locale;

    /**
     * @var \SK\Geo\Location\Location
     */
    public $location;

    /**
     * @var \SK\Geo\Money
     */
    public $money;

    public function __construct(Locale $locale, Location $location, Money $money)
    {
        $this->locale = $locale;
        $this->location = $location;
        $this->money = $money;
    }

    public function locale()
    {
        return $this->locale;
    }

    public function location()
    {
        return $this->location;
    }

    public function money()
    {
        return $this->money;
    }
}
