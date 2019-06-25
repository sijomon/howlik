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
use App\Larapen\Models\SubAdmin2;
use App\Larapen\Models\City;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Response;

class PlacesController extends FrontController
{
    public function getCountries()
    {
        // return response()->json(['data' => $data], 200, [], JSON_UNESCAPED_UNICODE);
        return $this->countries->toJson();
    }
    
    /**
     * Country => Locations
     * @param $code
     * @return mixed
     */
    public function getLocations($code)
    {
        $admin1_rows = SubAdmin1::where('code', 'LIKE', $code . '.%')->orderBy('name')->get(['code', 'name']);
        if ($admin1_rows->count() == 0) {
            return response()->json(['error' => ['message' => "Error. Please select other Country.",], 404]);
        }
        
        return response()->json(['data' => $admin1_rows], 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Location => Sub-Locations or Cities
     * @param $code
     * @return mixed
     */
    public function getSubLocations($code)
    {
        $code_tab = explode('.', $code);
        $country_code = current($code_tab);
        $admin_code = end($code_tab);
        
        $checker = SubAdmin2::where('code', 'LIKE', $code . '.%')->first();
        
        if ($checker) {
            $checker_code_tab = explode('.', $checker->code);
            $checker_code = end($checker_code_tab);
            
            $count_admin2_cities = City::where('country_code', $country_code)->where('subadmin2_code', $checker_code)->get()->count();
        } else {
            $count_admin2_cities = 0;
        }
        
        
        if ($count_admin2_cities == 0) {
            $admin1_cities = City::where('country_code', $country_code)->where('subadmin1_code', $admin_code)->orderBy('population',
                'desc')->get(['id as code', 'name']);
            if ($admin1_cities->count() == 0) {
                return response()->json(['error' => ['message' => "Error. Please select other location.",], 404]);
            }
            
            return response()->json(['data' => $admin1_cities, 'hasChildren' => 'no'], 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            $admin2_rows = SubAdmin2::where('code', 'LIKE', $code . '.%')->orderBy('name')->get(['code', 'name']);
            if ($admin2_rows->count() == 0) {
                return response()->json(['error' => ['message' => "Error. Please select other location.",], 404]);
            }
            
            return response()->json(['data' => $admin2_rows, 'hasChildren' => 'yes'], 200, [], JSON_UNESCAPED_UNICODE);
        }
    }
    
    /**
     * Sub-Location => Cities
     * @param $code
     * @return mixed
     */
    public function getCities($code)
    {
        $code_tab = explode('.', $code);
        $country_code = current($code_tab);
        $admin_code = end($code_tab);
        
        $admin2_cities = City::where('country_code', $country_code)->where('subadmin2_code', $admin_code)->orderBy('population',
            'desc')->get(['id as code', 'name']);
        if ($admin2_cities->count() == 0) {
            return response()->json(['error' => ['message' => "Error. Please select other location.",], 404]);
        }
        
        return response()->json(['data' => $admin2_cities], 200, [], JSON_UNESCAPED_UNICODE);
    }
}
