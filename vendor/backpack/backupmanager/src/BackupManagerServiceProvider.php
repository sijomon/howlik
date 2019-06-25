<?php

namespace Backpack\BackupManager;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class BackupManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // use the vendor configuration file as fallback
        $this->mergeConfigFrom(
            __DIR__.'/config/laravel-backup.php', 'backpack.backupmanager'
        );

        // use this if your package has views
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'backupmanager');

        // publish config file
        $this->publishes([__DIR__.'/config/laravel-backup.php' => config_path('laravel-backup.php')], 'config');
        // publish lang files
        $this->publishes([__DIR__.'/resources/lang' => resource_path('lang/vendor/backpack')], 'lang');
    }

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Backpack\BackupManager\app\Http\Controllers'], function ($router) {
            require __DIR__.'/app/Http/routes.php';
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBackupManager();
        $this->setupRoutes($this->app->router);

        // use this if your package has a config file
        config([
                'config/laravel-backup.php',
        ]);
    }

    private function registerBackupManager()
    {
        $this->app->bind('backupmanager', function ($app) {
            return new BackupManager($app);
        });
    }
}
