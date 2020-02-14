<?php

namespace Sk\Geo\Location;

use Illuminate\Contracts\Config\Repository;
use MaxMind\Db\Reader;

class MaxmindLocation implements Location
{
    /**
     * See 'geo:maxmind' artisan command
     *
     * @var array
     */
    const FILTER = ['A1', 'A2', 'O1', 'AP', 'BV', 'EU', 'HM'];

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var array
     */
    protected $readers;

    /**
     * Create new instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @return void
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Get DB reader.
     *
     * @param  string  $name
     * @return \MaxMind\Db\Reader|null
     * @throws \MaxMind\Db\Reader\InvalidDatabaseException
     */
    protected function reader($name)
    {
        if (empty($this->readers[$name])) {
            $readers = $this->config->get('geo.location.maxmind');
            if (empty($readers[$name])
                || ! file_exists($readers[$name])) {
                return null;
            }

            $this->readers[$name] = new Reader($readers[$name]);
        }

        return $this->readers[$name];
    }

    /**
     * Looks up the ip address in the DB reader.
     *
     * @param  string  $name
     * @param  string  $ip
     * @return array|null
     * @throws \InvalidArgumentException
     */
    public function get($name, $ip)
    {
        if (! $reader = $this->reader($name)) {
            return null;
        }

        return $reader->get($ip);
    }

    /**
     * Close DB reader.
     *
     * @param  string  $name
     * @return void
     */
    public function close($name)
    {
        if (isset($this->readers[$name])) {
            $this->readers[$name]->close();
            unset($this->readers[$name]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function ipCountry($ip)
    {
        $data = $this->get('country', $ip);

        if (! isset($data['country']['iso_code'])) {
            return null;
        }

        if (in_array($data['country']['iso_code'], self::FILTER)) {
            return null;
        }

        return $data['country']['iso_code'];
    }

    /**
     * Get city name from ip address.
     *
     * @param  string  $ip
     * @param  string  $locale
     * @return string|null
     */
    public function city($ip, $locale = 'en')
    {
        $data = $this->get('city', $ip);

        if (! empty($data['city']['names'][$locale])) {
            return $data['city']['names'][$locale];
        } elseif (! empty($data['city']['names']['en'])) {
            return $data['city']['names']['en'];
        }

        return null;
    }

    /**
     * Get ISP name from ip address.
     *
     * @param  string  $ip
     * @return string|null
     */
    public function isp($ip)
    {
        $data = $this->get('isp', $ip);

        if (isset($data['isp'])) {
            return $data['isp'];
        }

        // Fallback to AS organization
        return isset($data['autonomous_system_organization'])
            ? $data['autonomous_system_organization']
            : null;
    }

    /**
     * Get AS number from ip address.
     *
     * @param  string  $ip
     * @return int|null
     */
    public function asn($ip)
    {
        $data = $this->get('isp', $ip);

        return isset($data['autonomous_system_number'])
            ? $data['autonomous_system_number']
            : null;
    }
}
