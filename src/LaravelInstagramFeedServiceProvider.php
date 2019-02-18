<?php

namespace RalphMorris\LaravelInstagramFeed;

use Illuminate\Support\ServiceProvider;

class LaravelInstagramFeedServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-instagram.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/create_instagram_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_instagram_table.php'),
            ], 'migrations');

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-instagram');

        // Register the main class to use with the facade
        $this->app->singleton('instagram', function () {
            return new Instagram;
        });
    }
}
