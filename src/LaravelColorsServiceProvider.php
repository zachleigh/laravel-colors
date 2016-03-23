<?php

namespace LaravelColors;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class LaravelColorsServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot(DispatcherContract $events)
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__.'/Http/routes.php';
        }

        $this->app->router->group(['namespace' => 'LaravelColors\Http\Controllers'], function () {
            require __DIR__.'/Http/routes.php';
        });

        $this->loadViewsFrom(__DIR__.'/resources/views', 'laravel-colors');

        $this->publishes([
            __DIR__.'/config.php' => config_path('laravel-colors.php'),
        ]);

        $this->publishes([
            __DIR__.'/resources/assets/public' => public_path('vendor/laravel-colors'),
        ], 'public');

        $this->publishes([
            __DIR__.'/2016_03_15_220300_create_color_schemes_table.php' => database_path('migrations/2016_03_15_220300_create_color_schemes_table.php'),
        ], 'migrations');
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
    }
}
