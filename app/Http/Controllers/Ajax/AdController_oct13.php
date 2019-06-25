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

namespace App\Http\Controllers\Ajax;

use App\Larapen\Models\Ad;
use App\Larapen\Models\City;
use App\Http\Controllers\FrontController;
use App\Larapen\Models\Language;
use App\Larapen\Models\SavedAd;
use App\Larapen\Models\SavedSearch;
use Auth;
use Illuminate\Http\Request as HttpRequest;
use Larapen\TextToImage\Facades\TextToImage;

class AdController extends FrontController
{
    /**
     * @param HttpRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAd(HttpRequest $request)
    {
        $ad_id = $request->input('ad_id');
        
        $status = 0;
        if (Auth::check()) {
            $user = Auth::user();
            
            $saved_ad = SavedAd::where('user_id', $user->id)->where('ad_id', $ad_id);
            if ($saved_ad->count() > 0) {
                // Delete Save Ads
                $saved_ad->delete();
            } else {
                // Store Save Ads
                $saved_ad = new SavedAd(array(
                    'user_id' => $user->id,
                    'ad_id' => $ad_id,
                ));
                $saved_ad->save();
                $status = 1;
            }
        }
        
        $result = [
            'logged' => (Auth::check()) ? $user->id : 0,
            'adId' => $ad_id,
            'status' => $status,
            'loginUrl' => url($this->lang->get('abbr') . '/' . trans('routes.login')),
        ];
        
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    public function saveSearch(HttpRequest $request)
    {
        $query_url = $request->input('url');
        $tmp = parse_url($query_url);
        $query = $tmp['query'];
        parse_str($query, $tab);
        $keyword = $tab['q'];
        $count_ads = $request->input('count_ads');
        if ($keyword == '') {
            return response()->json([], 200, [], JSON_UNESCAPED_UNICODE);
        }
        
        $status = 0;
        if (Auth::check()) {
            $user = Auth::user();
            
            $saveSearch = SavedSearch::where('user_id', $user->id)->where('keyword', $keyword)->where('query', $query);
            if ($saveSearch->count() > 0) {
                // Delete Save Search
                $saveSearch->delete();
            } else {
                // Store Save Ads
                $saveSearch = new SavedSearch(array(
                    'user_id' => $user->id,
                    'keyword' => $keyword,
                    'query' => $query,
                    'count' => $count_ads,
                ));
                $saveSearch->save();
                $status = 1;
            }
        }
        
        $result = [
            'logged' => (Auth::check()) ? $user->id : 0,
            'query' => $query,
            'status' => $status,
            'loginUrl' => url($this->lang->get('abbr') . '/' . trans('routes.login')),
        ];
        
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * @param $ad_id
     * @return mixed
     */
    public function getPhone(HttpRequest $request)
    {
        $ad_id = $request->input('ad_id', 0);
        
        $ad = Ad::active()->where('id', $ad_id)->first();
        
        if (is_null($ad)) {
            return response()->json(['error' => ['message' => "Error. Please select other location.",], 404]);
        }
        
        $ad->seller_phone = TextToImage::make($ad->seller_phone, IMAGETYPE_PNG, ['color' => '#FFFFFF']);
        
        return response()->json(['phone' => $ad->seller_phone], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
