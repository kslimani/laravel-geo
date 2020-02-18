<?php

namespace Sk\Geo;

use Sk\Geo\Geo;
use Sk\Geo\Locale;
use Sk\Geo\Location\MaxmindLocation;
use Sk\Geo\Money;
use Illuminate\Support\ServiceProvider;
use Money\Exchange\SwapExchange;
use Swap\Laravel\SwapServiceProvider;

class GeoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/geo.php' => $this->app->configPath().'/geo.php',
        ], 'config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\GeoExchange::class,
                Console\GeoInfo::class,
                Console\GeoList::class,
                Console\GeoMaxmind::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register Swap service provider
        $this->app->register(SwapServiceProvider::class);

        $this->app->singleton('geo.locale', function ($app) {
            return new Locale($app->make('config'));
        });

        $this->app->singleton('geo.money.exchange', function ($app) {
            return new SwapExchange($app->make('swap'));
        });

        $this->app->singleton('geo.money', function ($app) {
            return new Money(
                $app->make('config'),
                $app->make('geo.money.exchange')
            );
        });

        $this->app->singleton('geo.location', function ($app) {
            return $app->make(
                $app->make('config')
                    ->get('geo.defaults.location', MaxmindLocation::class)
            );
        });

        $this->app->singleton('geo', function ($app) {
            return new Geo(
                $app->make('geo.locale'),
                $app->make('geo.location'),
                $app->make('geo.money')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'geo.locale',
            'geo.money.exchange',
            'geo.money',
            'geo.location',
            'geo',
        ];
    }
}
