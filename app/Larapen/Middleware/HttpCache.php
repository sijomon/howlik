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

use Carbon\Carbon;
use Closure;

class HttpCache
{
    public function handle($request, Closure $next, $cache = 'yes')
    {
        $response = $next($request);
        
        // Don't minify the HTML in development environment
        if (config('settings.activation_http_cache') == 0) {
            return $response;
        }
        
        // Security Headers
        $response->header("X-Content-Type-Options", "nosniff");
        $response->header("X-Frame-Options", "DENY");
        
        if (isset($_SERVER['SCRIPT_FILENAME'])) {
            // Get the last-modified-date of this very file
            $lastModified = filemtime($_SERVER['SCRIPT_FILENAME']);
            // Get a unique hash of this file (etag)
            $etagFile = md5_file($_SERVER['SCRIPT_FILENAME']);
            // Get the HTTP_IF_MODIFIED_SINCE header if set
            $ifModifiedSince = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
            // Get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
            $etagHeader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? trim($_SERVER['HTTP_IF_NONE_MATCH']) : false);
            
            // Set last-modified header
            $response->header("Last-Modified", gmdate("D, d M Y H:i:s", $lastModified) . " GMT");
            $response->header("Etag", "$etagFile");
            $response->header('Cache-Control', 'public');
            $response->header("Pragma", "cache"); //HTTP 1.0
            
            // Check if page has changed. If not, send 304 and exit
            if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) || isset($_SERVER['HTTP_IF_NONE_MATCH'])) {
                if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $lastModified || $etagHeader == $etagFile) {
                    $response->header('HTTP/1.1', '304 Not Modified');
                    exit();
                }
            }
            
        } else {
            $response->header("Cache-Control", "max-age=86400, public, s-maxage=86400"); //HTTP 1.1
            $response->header("Pragma", "cache"); //HTTP 1.0
            $response->header("Expires", Carbon::now()->addDay()->format('D, d M Y H:i:s') . ' GMT'); // Date in the future or now
        }
        
        /*
        // No caching for pages
        $response->header("Cache-Control", "no-store, no-cache, must-revalidate, max-age=0");
        //$response->header("Pragma", "no-cache");
        $response->header("Expires"," Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
        */
        
        return $response;
    }
}
