<?php

namespace TechGenies\MM\Providers;

use Illuminate\Support\ServiceProvider;
use TechGenies\MM\Api\PayTraceApi;

class MMServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/mm.php', 'mm');
        $this->app->bind('payTraceApi', function($app) {
            return new PayTraceApi();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/mm.php' => config_path('mm.php'),
        ], 'mm-config');
    }
}
