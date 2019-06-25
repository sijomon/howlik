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

// All BackPack routes are placed under the 'admin' prefix, to minimize possible conflicts with your application.
// This means your login/logout/register urls are also under the 'admin' prefix, so you can have separate logins for users and admins.
Route::group(['middleware' => 'web', 'prefix' => 'admin'], function () {
    // Admin authentication routes
    Route::auth();
    
    // Other Backpack\Base routes
    Route::get('/', 'AdminController@dashboard');
	Route::get('/dashboard', 'AdminController@dashboard');
});
