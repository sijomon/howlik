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

namespace App\Larapen\Providers;

use Illuminate\Support\ServiceProvider;
use App\Larapen\Helpers\Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app['validator']->extend('whitelist_domain', function ($attribute, $value) {
            return Validator::checkDomain($value);
        });
        
        $this->app['validator']->extend('whitelist_email', function ($attribute, $value) {
            return Validator::checkEmail($value);
        });
        
        $this->app['validator']->extend('whitelist_word', function ($attribute, $value) {
            return Validator::checkWord($value);
        });
        
        $this->app['validator']->extend('whitelist_word_title', function ($attribute, $value) {
            return Validator::checkTitle($value);
        });
        
        $this->app['validator']->extend('mb_between', function ($attribute, $value, $parameters, $validator) {
            return Validator::mbBetween($value, $parameters);
        });
    }
    
    public function register()
    {
        //
    }
}
