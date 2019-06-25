<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) Mayeul Akpovi. All Rights Reserved
 *
 * Email: mayeul.a@larapen.com
 * Website: http://larapen.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace Larapen\Settings;

use Backpack\Settings\SettingsServiceProvider as BackpackSettingsServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Backpack\Settings\app\Models\Setting as Setting;
use Config;

class SettingsServiceProvider extends BackpackSettingsServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // Check DB connection and catch it
        try {
            // only use the Settings package if the Settings table is present in the database
            if (count(DB::select("SHOW TABLES LIKE 'settings'"))) {
                // get all settings from the database
                $settings = Setting::all();
                
                // bind all settings to the Laravel config, so you can call them like
                // Config::get('settings.contact_email')
                foreach ($settings as $key => $setting) {
                    Config::set('settings.' . $setting->key, $setting->value);
                }
            }
        } catch (\Exception $e) {
            // Notify DB error
            Config::set('settings.error', true);
        }
        
        // publish the migrations and seeds
        $this->publishes([__DIR__ . '/database/migrations/' => database_path('migrations')], 'migrations');
        $this->publishes([__DIR__ . '/database/seeds/' => database_path('seeds')], 'seeds');
    }
    
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Larapen\Settings\app\Http\Controllers'], function ($router) {
            require __DIR__ . '/app/Http/routes.php';
        });
    }
}
