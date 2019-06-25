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

use App\Larapen\Models\Category;
use App\Larapen\Models\City;
use Torann\LaravelMetaTags\Facades\MetaTag;

class SitemapController extends FrontController
{
    public function index()
    {
        $data = array();
        
        // Get Categories
        $cats = Category::where('translation_lang', $this->lang->get('abbr'))->orderBy('lft')->get();
        $cats = collect($cats)->keyBy('translation_of');
        $cats = $sub_cats = $cats->groupBy('parent_id');
        
        $col = round($cats->get(0)->count() / 3, 0, PHP_ROUND_HALF_EVEN);
        $col = ($col > 0) ? $col : 1;
        $data['cats'] = $cats->get(0)->chunk($col);
        $data['sub_cats'] = $sub_cats->forget(0);
        
        // Location sitemap
        $limit = 100;
        $cities = City::where('country_code', $this->country->get('code'))->take($limit)->orderBy('population', 'DESC')->get();
        
        $col = round($cities->count() / 4, 0, PHP_ROUND_HALF_EVEN);
        $col = ($col > 0) ? $col : 1;
        $data['cities'] = $cities->chunk($col);
        
        // Meta Tags
        MetaTag::set('title', t('Sitemap :country', ['country' => $this->country->get('name')]));
        MetaTag::set('description',
            t('Sitemap :domain - :country. 100% Free Ads Classified', ['domain' => getDomain(), 'country' => $this->country->get('name')]));
        
        return view('classified.sitemap.index', $data);
    }
}
