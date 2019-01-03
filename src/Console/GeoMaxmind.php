<?php

namespace Sk\Geo\Console;

use Sk\Geo\Locale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GeoMaxmind extends Command
{
    /**
     * @var string
     */
    protected $signature = 'geo:maxmind';

    /**
     * @var string
     */
    protected $description = 'Display Maxmind DB countries with matched geo country name';

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
        $countries = Cache::remember('geo-maxmind-countries', 60, function () {
            $lines = explode("\n", file_get_contents(
                'https://dev.maxmind.com/static/csv/codes/iso3166.csv'
            ));

            $result = [];

            foreach ($lines as $line) {
                $row = str_getcsv($line);

                if (count($row) !== 2) {
                    continue;
                }

                list($code, $name) = $row;
                $result[$code] = $name;
            }

            return $result;
        });

        $misses = [];
        $lines = [];

        foreach ($countries as $countryCode => $country) {
            $countryName = $this->locale->country($countryCode);
            if (! $countryName) {
                // Country name should be NULL for 'A1', 'A2', 'O1', 'EU' and 'AP'
                // See: https://dev.maxmind.com/geoip/legacy/codes/iso3166/
                // Country name is NULL for 'BV' : Bouvet Island (uninhabited)
                // Country name is NULL for 'HM' : Heard Island and McDonald Islands (no permanent human habitation)
                $misses[] = $countryCode;
            }
            $lines[] = [
                $countryCode,
                $countryName,
                $country,
            ];
        }

        $this->table([
            'Country code',
            'Country name',
            'Maxmind country name',
        ], $lines);

        $this->warn('Missing country codes are [\''.implode('\', \'', $misses).'\']');
    }
}
