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
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Larapen\CountryLocalization\LanguageLocalization;

class LanguageLocalizationFinder
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
        // Init. language
        $obj = new LanguageLocalization();
        
        // Detect Language
        $obj->lang = $obj->findLang();
        View::share('lang', $obj->lang);
        App::setLocale($obj->lang->get('abbr'));
        
        // Share var in Controller
        $request->attributes->add([
            'mw_lang' => $obj->lang,
        ]);
        
        // Save in session
        if (!$obj->lang->isEmpty()) {
            //Session::forget('language_code');
            session(['language_code' => $obj->lang->get('abbr')]);
        }
        
        return $next($request);
    }
}
