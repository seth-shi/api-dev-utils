<?php

namespace SethShi\ApiDevUtils;

use Illuminate\Support\ServiceProvider;

class ApiDevUtilsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__.'/../config/utils.php' => config_path('utils.php')], 'config');
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
