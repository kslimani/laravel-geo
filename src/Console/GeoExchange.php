<?php

namespace Sk\Geo\Console;

use Sk\Geo\Money;
use Illuminate\Console\Command;

class GeoExchange extends Command
{
    /**
     * @var string
     */
    protected $signature = 'geo:exchange
        {currency_from : The amount ISO4217 currency code}
        {currency_to : The target ISO4217 currency code}
        {amount=1 : The amount value}
    ';

    /**
     * @var string
     */
    protected $description = 'Simple currency converter';

    /**
     * @var \Sk\Geo\Money;
     */
    protected $money;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->money = app('geo.money');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $amount = $this->argument('amount');
        $amountCurrency = $this->argument('currency_from');
        $targetCurrency = $this->argument('currency_to');
        $amount = $this->money->parse($amount, $amountCurrency);
        $targetAmount = $this->money->convert($amount, $targetCurrency);

        $this->info(sprintf(
            '%s %s = %s %s',
            $this->money->formatDec($amount),
            $amount->getCurrency(),
            $this->money->formatDec($targetAmount),
            $targetAmount->getCurrency()
        ));
    }
}
