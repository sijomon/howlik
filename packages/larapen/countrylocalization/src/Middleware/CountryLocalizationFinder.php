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

namespace Larapen\CountryLocalization\Middleware;

use Closure;

class CountryLocalizationFinder
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        app('countrylocalization')->findCountry();
        app('countrylocalization')->setCountryParameters();
        app('countrylocalization')->varsToViews();
        
        // Share var in Controller
        $request->attributes->add([
            'mw_user' => app('countrylocalization')->user,
            'mw_country' => app('countrylocalization')->country,
            'mw_ip_country' => app('countrylocalization')->ip_country,
        ]);
        
        // Session : Set country code
        if (!app('countrylocalization')->country->isEmpty() and app('countrylocalization')->country->has('code')) {
            session(['country_code' => app('countrylocalization')->country->get('code')]);
        }
        // Session : Set timezome
        if (!app('countrylocalization')->country->isEmpty() and app('countrylocalization')->country->has('timezone')) {
            session(['time_zone' => app('countrylocalization')->country->get('timezone')->time_zone_id]);
        }
        
        return $next($request);
    }
}
