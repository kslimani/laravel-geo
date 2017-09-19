<?php

namespace Sk\Geo\Console;

use Sk\Geo\Locale;
use Illuminate\Console\Command;

class GeoList extends Command
{
    /**
     * @var string
     */
    protected $signature = 'geo:list';

    /**
     * @var string
     */
    protected $description = 'Display countries with default language and currency';

    /**
     * @var \Sk\Geo\Locale;
     */
    protected $locale;

    /**
     * Create a new command instance.
     *
     * @param  \Sk\Geo\Locale  $locale
     * @return void
     */
    public function __construct(Locale $locale)
    {
        $this->locale = $locale;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $countries = $this->locale->countries();
        foreach ($countries as $countryCode => $country) {
            $languageCode = $this->locale->countryLanguage($countryCode);
            $currencyCode = $this->locale->countryCurrency($countryCode);
            $lines[] = [
                $countryCode,
                $country,
                $languageCode,
                $this->locale->language($languageCode),
                $currencyCode,
                $this->locale->currency($currencyCode),
            ];
        }
        $this->table([
            'Country code',
            'Country name',
            'Language code',
            'Language name',
            'Currency code',
            'Currency name',
        ], $lines);
    }
}
