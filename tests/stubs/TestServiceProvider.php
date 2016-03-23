<?php

namespace LaravelColors\tests\stubs;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        if (! $this->app->routesAreCached()) {
            require __DIR__.'/testRoute.php';
        }

        $this->app->router->group(['namespace' => 'LaravelColors\Http\Controllers'], function () {
            require __DIR__.'/testRoute.php';
        });

        $this->loadViewsFrom(__DIR__.'/../../src/resources/views', 'laravel-colors');

        $this->mergeConfigFrom(__DIR__.'/config.php', 'laravel-colors');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {

    }

}
