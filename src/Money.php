<?php

namespace Sk\Geo;

use Illuminate\Contracts\Config\Repository;
use Money\Converter;
use Money\Currency;
use Money\Exchange;
use Money\Currencies\ISOCurrencies;
use Money\Exchange\FixedExchange;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money as MoneyValue;
use NumberFormatter;

class Money
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @var \Money\Converter
     */
    protected $converter;

    /**
     * @var \Money\Exchange
     */
    protected $exchange;

    /**
     * @var \Money\Currencies\ISOCurrencies
     */
    protected $currencies;

    /**
     * Create new instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Money\Exchange  $exchange
     * @return void
     */
    public function __construct(Repository $config, Exchange $exchange)
    {
        $this->config = $config;
        $this->exchange = $exchange;
    }

    /**
     * Get or set exchange instance.
     *
     * @param  \Money\Exchange  $exchange
     * @return \Money\Exchange
     */
    public function exchange(Exchange $exchange = null)
    {
        if ($exchange) {
            $this->exchange = $exchange;
        }

        return $this->exchange;
    }

    /**
     * Replace Exchange instance by FixedExchange.
     *
     * @param  array  $list
     * @return \Money\Exchange
     */
    public function fixedExchange(array $list)
    {
        $this->exchange = new FixedExchange($list);

        return $this->exchange;
    }

    /**
     * Get Money ISO currencies.
     *
     * @return \Money\Currencies\ISOCurrencies
     */
    public function currencies()
    {
        if (! $this->currencies) {
            $this->currencies = new ISOCurrencies();
        }

        return $this->currencies;
    }

    /**
     * Convert money value to currency.
     *
     * @param  \Money\Money  $money
     * @param  string|\Money\Currency  $currency
     * @param  int  $roundingMode
     * @return \Money\Money
     * @throws MoneyException
     */
    public function convert(MoneyValue $money, $currency, $roundingMode = MoneyValue::ROUND_HALF_UP)
    {
        if (! $this->converter) {
            $this->converter = new Converter(
                $this->currencies(),
                $this->exchange
            );
        }
        try {
            return $this->converter->convert(
                $money,
                $this->currency($currency),
                $roundingMode
            );
        } catch (\Exception $e) {
            throw new MoneyException('Money convert', $e);
        }
    }

    /**
     * Format money value using "Intl" formatter.
     *
     * @param  \Money\Money  $money
     * @param  string  $locale
     * @return string
     * @throws MoneyException
     */
    public function format(MoneyValue $money, $locale = null)
    {
        try {
            if (! $locale) {
                $locale = $this->config->get('app.locale');
            }
            return (new IntlMoneyFormatter(
                new NumberFormatter($locale, NumberFormatter::CURRENCY),
                $this->currencies()
            ))->format($money);
        } catch (\Exception $e) {
            throw new MoneyException('Money Intl format', $e);
        }
    }

    /**
     * Format money value using "Decimal" formatter.
     *
     * @param  \Money\Money  $money
     * @return string
     * @throws MoneyException
     */
    public function formatDec(MoneyValue $money)
    {
        try {
            return (new DecimalMoneyFormatter($this->currencies()))
                ->format($money);
        } catch (\Exception $e) {
            throw new MoneyException('Money decimal format', $e);
        }
    }

    /**
     * Shortcut to create currency.
     *
     * @param  string|\Money\Currency  $code
     * @return \Money\Currency
     */
    public function currency($code)
    {
        if (is_string($code)) {
            return new Currency($code);
        }

        return $code;
    }

    /**
     * Parse a decimal money amount for currency.
     *
     * @param  string  $amount
     * @param  string  $currency
     * @return \Money\Money
     * @throws MoneyException
     */
    public function parse($amount, $currency)
    {
        try {
            return (new \Money\Parser\DecimalMoneyParser($this->currencies()))
                ->parse($amount, $this->currency($currency));
        } catch (\Exception $e) {
            throw new MoneyException('Money parse', $e);
        }
    }

    /**
     * Shortcut to make money value.
     * Amount MUST be expressed in the smallest units of currency.
     *
     * @param  int|string  $amount
     * @param  string|\Money\Currency  $currency
     * @return \Money\Money
     * @throws MoneyException
     */
    public function make($amount, $currency)
    {
        try {
            return new MoneyValue($amount, $this->currency($currency));
        } catch (\Exception $e) {
            throw new MoneyException('Money make', $e);
        }
    }

    /**
     * Decompose a money value.
     *
     * @param  \Money\Money  $money
     * @param  string  $locale
     * @return array
     */
    public function decompose(MoneyValue $money, $locale = null)
    {
        if (! $locale) {
            $locale = $this->config->get('app.locale');
        }

        $formatter = new NumberFormatter($locale, NumberFormatter::CURRENCY);
        $subUnit = $this->currencies()->subunitFor($money->getCurrency());
        $parts = explode('.', $this->formatDec($money->absolute()));

        $decomposed = [
            'locale' => $locale,
            'subunit' => $subUnit,
            'sign' => $money->isPositive() ? '+' : '-',
            'unsigned_part' => $parts[0],
            'decimal_part' => isset($parts[1]) ? $parts[1] : '',
            'grouping_separator' => $formatter->getSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL),
            'decimal_separator' => $subUnit > 0 ? $formatter->getSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL) : '',
        ];

        // Symbol workaround : https://github.com/moneyphp/money/issues/330#issuecomment-267295863

        // Prevent any extra spaces, etc. in formatted currency
        $formatter->setPattern('¤');

        // Prevent significant digits (e.g. cents) in formatted currency
        $formatter->setAttribute(NumberFormatter::MAX_SIGNIFICANT_DIGITS, 0);

        // Get the formatted price for '0'
        $formattedPrice = $formatter->formatCurrency(0, $money->getCurrency()->getCode());

        // Strip out the zero digit to get the currency symbol
        $zero = $formatter->getSymbol(NumberFormatter::ZERO_DIGIT_SYMBOL);
        $decomposed['symbol'] = str_replace($zero, '', $formattedPrice);

        return $decomposed;
    }
}
