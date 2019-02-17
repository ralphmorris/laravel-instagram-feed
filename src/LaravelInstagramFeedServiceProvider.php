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
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-instagram');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-instagram');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-instagram.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../database/migrations/create_instagram_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_instagram_table.php'),
            ], 'migrations');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-instagram'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-instagram'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-instagram'),
            ], 'lang');*/

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
