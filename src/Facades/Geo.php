<?php

namespace Sk\Geo\Facades;

use Illuminate\Support\Facades\Facade;

class Geo extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return 'geo';
    }
}
