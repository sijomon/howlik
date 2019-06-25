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

use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\City;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;

class StateCitiesController extends FrontController
{
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
    }
    
    /**
     * @param $parentId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities(HttpRequest $request)
    {
        $language_code = $request->input('language_code');
        $sub_admin1_code = $request->input('full_state_code');
        $tmp = explode('.', $sub_admin1_code);
        $state_id = end($tmp);
        $curr_search = unserialize(base64_decode($request->input('curr_search')));
        $_token = $request->input('_token');
        
        $state = SubAdmin1::find($sub_admin1_code);
        $cities = City::where('country_code', '=', $this->country->get('code'))->where('subadmin1_code', '=', $state_id)->orderBy('name')->get();
        
        if (!isset($state) or !isset($cities)) {
            return response()->json([], 200, [], JSON_UNESCAPED_UNICODE);
        }
        
        $col = round($cities->count() / 3, 0, PHP_ROUND_HALF_EVEN); // count + 1 (All Cities)
        $col = ($col > 0) ? $col : 1;
        
        $cities = $cities->chunk($col);
        
        $html = '';
        $i = 0;
        foreach ($cities as $col) {
            $html .= '<div class="col-md-4">';
            $html .= '<ul class="list-link list-unstyled">';
            $j = 0;
            foreach ($col as $city) {
                if ($i == 0 and $j == 0) {
                    $html .= '<li> <a href="">' . t('All Cities', [], 'global', $language_code) . '</a> </li>';
                }
                $html .= '<li> <a href="' . qsurl($language_code . '/' . $this->country->get('icode') . '/' . t('t-search', [], 'routes',
                            $language_code), array_merge($curr_search, [
                        'l' => $city->id,
                        '_token' => $_token
                    ])) . '" title="' . $city->name . '">' . $city->name . '</a> </li>';
                $j++;
            }
            $html .= '</ul>';
            $html .= '</div>';
            $i++;
        }
        
        $result = [
            'selectState' => $state->name,
            'stateCities' => $html,
        ];
        
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
}
