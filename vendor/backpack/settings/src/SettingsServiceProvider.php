<?php namespace Backpack\Settings;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Backpack\Settings\app\Models\Setting as Setting;
use Config;

class SettingsServiceProvider extends ServiceProvider
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
        // only use the Settings package if the Settings table is present in the database
        if (count(DB::select("SHOW TABLES LIKE 'settings'")))
        {
            // get all settings from the database
            $settings = Setting::all();

            // bind all settings to the Laravel config, so you can call them like
            // Config::get('settings.contact_email')
            foreach ($settings as $key => $setting) {
                Config::set('settings.'.$setting->key, $setting->value);
            }
        }

        // publish the migrations and seeds
        $this->publishes([ __DIR__.'/database/migrations/' => database_path('migrations') ], 'migrations');
        $this->publishes([ __DIR__.'/database/seeds/' => database_path('seeds') ], 'seeds');
    }
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Backpack\Settings\app\Http\Controllers'], function($router)
        {
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
        $this->registerSettings();
        $this->setupRoutes($this->app->router);

        // use this if your package has a config file
        // config([
        //         'config/Settings.php',
        // ]);
    }
    private function registerSettings()
    {
        $this->app->bind('settings',function($app){
            return new Settings($app);
        });
    }
}