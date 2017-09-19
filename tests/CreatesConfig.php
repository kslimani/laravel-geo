<?php

namespace Tests;

use Illuminate\Config\Repository;

trait CreatesConfig
{
    /**
     * Creates config.
     *
     * @return \Illuminate\Config\Repository
     */
    public function createConfig()
    {
        $config = new Repository([
            'geo' => include(dirname(__FILE__)."/../config/geo.php"),
            'app' => [
                'locale' => 'en',
                'fallback_locale' => 'en',
            ],
        ]);

        return $config;
    }
}
