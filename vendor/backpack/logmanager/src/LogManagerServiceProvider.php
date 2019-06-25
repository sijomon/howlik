<?php

namespace Backpack\LogManager;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Route;

class LogManagerServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(realpath(__DIR__.'/resources/views'), 'logmanager');
        $this->loadTranslationsFrom(realpath(__DIR__.'/resources/lang'), 'backpack');

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
        $router->group(['namespace' => 'Backpack\LogManager\app\Http\Controllers'], function ($router) {
            // Admin Interface Routes
            Route::group(['middleware' => ['web', 'auth'], 'prefix' => config('backpack.base.route_prefix', 'admin')], function () {
                // Logs
                Route::get('log', 'LogController@index');
                Route::get('log/preview/{file_name}', 'LogController@preview');
                Route::get('log/download/{file_name}', 'LogController@download');
                Route::delete('log/delete/{file_name}', 'LogController@delete');
            });
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLogManager();
        $this->setupRoutes($this->app->router);
    }

    private function registerLogManager()
    {
        $this->app->bind('logmanager', function ($app) {
            return new LogManager($app);
        });
    }
}
