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

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Prologue\Alerts\Facades\Alert;

class Admin
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            if (!Auth::guard($guard)->user()->is_admin) {
                Auth::logout();
                //Alert::error("Permission Denied.")->flash();
                flash()->error("Permission Denied.");
                return redirect()->guest('login');
            }
        } else {
            if ($request->path() != 'admin/login') {
             //   Alert::error("Permission Denied.")->flash();
                
                return redirect()->guest('admin/login');
            }
        }
        
        return $next($request);
    }
}
