<?php

namespace Tests;

use Tests\CreatesConfig;
use Sk\Geo\Locale;

class LocaleTest extends \PHPUnit_Framework_TestCase
{
    use CreatesConfig;

    protected $locale;

    protected function setUp()
    {
        $basePath = realpath(__DIR__.'/../');
        $this->locale = new Locale($this->CreateConfig(), $basePath);
    }

    public function test_it_load_countries()
    {
        $countries = $this->locale->countries();

        $this->assertNotCount(0, $countries);

        foreach ($countries as $code => $name) {
            $this->assertSame($name, $this->locale->country($code));
        }
    }

    public function test_it_load_languages()
    {
        $languages = $this->locale->languages();

        $this->assertNotCount(0, $languages);

        foreach ($languages as $code => $name) {
            $this->assertSame($name, $this->locale->language($code));
        }
    }

    public function test_it_load_currencies()
    {
        $currencies = $this->locale->currencies();

        $this->assertNotCount(0, $currencies);

        foreach ($currencies as $code => $name) {
            $this->assertSame($name, $this->locale->currency($code));
        }
    }

    public function test_it_resolve_country_locale()
    {
        $this->assertSame('fr_FR', $this->locale->countryLocale('FR'));
        $this->assertSame('en_US', $this->locale->countryLocale('US'));
    }

    public function test_it_resolve_country_language()
    {
        $this->assertSame('fr', $this->locale->countryLanguage('FR'));
        $this->assertSame('en', $this->locale->countryLanguage('US'));
    }

    public function test_it_resolve_country_currency()
    {
        $this->assertSame('EUR', $this->locale->countryCurrency('FR'));
        $this->assertSame('USD', $this->locale->countryCurrency('US'));
    }
}
