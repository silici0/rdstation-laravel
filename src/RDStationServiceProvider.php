<?php

namespace silici0\RDStation;

use Illuminate\Support\ServiceProvider;

class RDStationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->make('silici0\RDStation\RdstationController');
        $this->app->singleton('rdstation', function($app) {
            return new RDStation();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->publishes([__DIR__.'/config/rdstation.php' => config_path('rdstation.php'),]);
        $this->loadViewsFrom(__DIR__.'/resources/views', 'rdstationview');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    public function provides()
    {
        return ['RDStation'];
    }
}
