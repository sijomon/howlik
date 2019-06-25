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

namespace App\Http\Controllers;

use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;

class RobotsController extends FrontController
{
    public function index()
    {
        error_reporting(0);
        $robots_txt = @file_get_contents('robots.txt');
        
        // Get countries list
        $countries = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
        
        // Sitemaps
        if (!$countries->isEmpty()) {
            foreach ($countries as $item) {
                $country = CountryLocalization::getCountryInfo($item->get('code'));
                $robots_txt .= "\n" . 'Sitemap: ' . url($country->get('lang')->get('abbr') . '/' . $country->get('icode') . '/sitemaps.xml');
            }
        }
        
        // Rending
        header("Content-Type:text/plain");
        echo $robots_txt;
    }
}
