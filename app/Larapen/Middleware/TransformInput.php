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

namespace App\Larapen\Middleware;

use Closure;

class TransformInput
{
    public function handle($request, Closure $next)
    {
        if (in_array(strtolower($request->method()), ['post', 'put', 'patch'])) {
            $this->proccessBeforeValidation($request);
        }
        
        return $next($request);
    }
    
    public function proccessBeforeValidation($request)
    {
        $input = $request->all();
        
        // Format
        if ($request->has('description')) {
            $input['description'] = str_clean($request->input('description'));
        }
        if ($request->has('price')) {
            $input['price'] = preg_replace('/[^0-9\.]/', '', $request->input('price'));
        }
        if ($request->has('seller_phone')) {
            // Keep only numeric characters
            $input['seller_phone'] = preg_replace('/[^0-9]/', '', $request->input('seller_phone'));
        }
        
        if ($request->has('phone')) {
            // Keep only numeric characters
            $input['phone'] = preg_replace('/[^0-9]/', '', $request->input('phone'));
        }
        
        $request->replace($input);
    }
}
