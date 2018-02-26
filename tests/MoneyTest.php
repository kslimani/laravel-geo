<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\CreatesConfig;
use Money\Exchange\SwapExchange;
use Money\Exchange\FixedExchange;
use Sk\Geo\Money;
use Swap\Builder;

class MoneyTest extends TestCase
{
    use CreatesConfig;

    protected $money;

    protected function setUp()
    {
        $swap = (new Builder())->add('fixer')->build();
        $exchange = new SwapExchange($swap);
        $this->money = new Money($this->CreateConfig(), $exchange);
    }

    public function test_it_provides_exchange()
    {
        $this->assertInstanceOf(
            \Money\Exchange::class,
            $this->money->exchange()
        );
    }

    public function test_it_can_set_exchange()
    {
        $custom = new FixedExchange([]);

        $this->assertNotInstanceOf(
            \Money\Exchange\FixedExchange::class,
            $this->money->exchange()
        );

        $this->money->exchange($custom);

        $this->assertInstanceOf(
            \Money\Exchange\FixedExchange::class,
            $this->money->exchange()
        );
    }

    public function test_it_can_replace_exchange_with_fixed_exchange()
    {
        $this->assertNotInstanceOf(
            \Money\Exchange\FixedExchange::class,
            $this->money->exchange()
        );

        $this->money->fixedExchange([
            'EUR' => [
                'USD' => 1.25
            ]
        ]);

        $this->assertInstanceOf(
            \Money\Exchange\FixedExchange::class,
            $this->money->exchange()
        );

        $amount = $this->money->make(500, 'EUR');

        $this->assertEquals(
            625,
            $this->money->convert($amount, 'USD')->getAmount()
        );
    }

    public function test_it_provides_iso_currencies()
    {
        $this->assertInstanceOf(
            \Money\Currencies\ISOCurrencies::class,
            $this->money->currencies()
        );
    }

    public function test_it_makes_money_amount()
    {
        $amount = $this->money->make(500, 'EUR');

        $this->assertInstanceOf(
            \Money\Money::class,
            $amount
        );
    }

    public function test_it_cannot_makes_invalid_money_amount()
    {
        $this->expectException(\Sk\Geo\MoneyException::class);
        $amount = $this->money->make(2.4, 'XOF');
    }

    public function test_it_makes_currency()
    {
        $currency = $this->money->currency('EUR');

        $this->assertInstanceOf(
            \Money\Currency::class,
            $currency
        );
    }

    public function test_it_parse_money_amount_for_currency()
    {
        $amount = $this->money->parse('12.75', 'EUR');

        $this->assertInstanceOf(
            \Money\Money::class,
            $amount
        );

        $this->assertEquals(
            1275,
            $amount->getAmount()
        );


        // BCEAO has no cents
        $amount = $this->money->parse('50', 'XOF');

        $this->assertInstanceOf(
            \Money\Money::class,
            $amount
        );

        $this->assertEquals(
            50,
            $amount->getAmount()
        );

        // BCEAO has no cents (value is troncated)
        $amount = $this->money->parse('50.30', 'XOF');

        $this->assertInstanceOf(
            \Money\Money::class,
            $amount
        );

        $this->assertEquals(
            50,
            $amount->getAmount()
        );
    }

    public function test_it_formats_money_amount()
    {
        $amount = $this->money->make(500, 'EUR');

        $formatted = $this->money->format($amount);
        $this->assertSame('€5.00', $formatted);

        $formatted = $this->money->format($amount, 'fr');
        $this->assertSame('5,00 €', $formatted);
    }

    public function test_it_converts_money_amount()
    {
        $amount = $this->money->make(500, 'EUR');
        $converted = $this->money->convert($amount, 'RON');

        $this->assertInstanceOf(
            \Money\Money::class,
            $converted
        );

        $this->assertGreaterThan(
            $amount->getAmount(),
            $converted->getAmount()
        );

        $this->assertSame('RON', $converted->getCurrency()->getCode());
    }
}
