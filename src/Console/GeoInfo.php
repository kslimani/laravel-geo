<?php

namespace Sk\Geo\Console;

use Sk\Geo\Locale;
use Sk\Geo\Location\MaxmindLocation as Location;
use Illuminate\Console\Command;

class GeoInfo extends Command
{
    /**
     * @var string
     */
    protected $signature = 'geo:info {ip}';

    /**
     * @var string
     */
    protected $description = 'Display geo data for ip address';

    /**
     * @var \Sk\Geo\Locale
     */
    protected $locale;

    /**
     * @var \Sk\Geo\Location\Location
     */
    protected $location;

    /**
     * Create a new command instance.
     *
     * @param  \Sk\Geo\Locale  $locale
     * @param  \Sk\Geo\Location\Location  $location
     * @return void
     */
    public function __construct(Locale $locale, Location $location)
    {
        $this->locale = $locale;
        $this->location = $location;
        parent::__construct();
    }

    protected function withIsp()
    {
        return method_exists($this->location, 'asn')
            && method_exists($this->location, 'isp');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ip = $this->argument('ip');
        $countryCode = $this->location->ipCountry($ip);
        $languageCode = $this->locale->countryLanguage($countryCode);
        $currencyCode = $this->locale->countryCurrency($countryCode);
        $this->table([
            'Country code',
            'Country name',
            'Language code',
            'Language name',
            'Currency code',
            'Currency name',
            'ISP ASN',
            'ISP name',
        ], [[
            $countryCode,
            $this->locale->country($countryCode),
            $languageCode,
            $this->locale->language($languageCode),
            $currencyCode,
            $this->locale->currency($currencyCode),
            $this->withIsp() ? $this->location->asn($ip) : null,
            $this->withIsp() ? $this->location->isp($ip) : null,
        ]]);
    }
}
