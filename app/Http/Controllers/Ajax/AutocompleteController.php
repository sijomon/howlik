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
use App\Larapen\Models\User;
use App\Http\Controllers\FrontController;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

class AutocompleteController extends FrontController
{
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
    }
    
    /**
     * Sub-Location => Cities
     * @param $code
     * @return mixed
     */
    public function getCities()
    {
        $query = Input::get('query');
		$region = Input::get('region');
		$langCode = Input::get('lc');
        $suggestions = [];
        
        if (strlen($query) > 0) {
			if($langCode=='ar'){
				$name = 'name';
			}else{
				$name = 'asciiname';
			}
			
			$region = SubAdmin1::where('code', 'LIKE', $this->country->get('code') . '.%')->where($name, $region)->orderBy($name)->get(['code', 'name', 'asciiname'])->first();//Region section added by vineeth
			if(isset($region->code) && trim($region->code)!=''){
				$rcodeA = explode('.', $region->code);
				$cities = Cache::remember(md5($this->country->get('code') . '-citiesStartWith-' . trim($rcodeA[1]).$name.$query), $this->cache_expire, function () use ($query, $rcodeA, $name) {
					return City::where('country_code', $this->country->get('code'))->where('subadmin1_code', trim($rcodeA[1]))->where(function ($sql) use ($query, $name) {
						$sql->where($name, 'LIKE', $query . '%');
						$sql->orWhere($name, 'LIKE', '%' . $query);
					})->orderBy($name)->get(['id as data', $name.' as value'])->take(25)->toArray();
				});
			}else{
				$cities = Cache::remember(md5($this->country->get('code') . '-citiesStartWith-' . $name.$query), $this->cache_expire, function () use ($query, $name) {
					return City::where('country_code', $this->country->get('code'))->where(function ($sql) use ($query, $name) {
						$sql->where($name, 'LIKE', $query . '%');
						$sql->orWhere($name, 'LIKE', '%' . $query);
					})->orderBy($name)->get(['id as data', $name.' as value'])->take(25)->toArray();
				});
			}
            
            if (!is_null($cities)) {
                $suggestions = $cities;
            }
        }
        $result = [
            'query' => $query,
            'suggestions' => $suggestions,
        ];
        
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
	
	public function searchUser()
	{
		$query = Input::get('query');
		$suggestions = [];
		
		if (strlen($query) > 0) {
		
			$users 	= User::where('name','LIKE','%'.$query.'%')->orderBy('name', 'asc')->get(['id as data', 'name as value', 'email as email'])->take(25)->toArray();
			
			if (!is_null($users)) {
				foreach($users as $key => $item) {
					unset($users[$key]['created_at_ta']);
				}
                $suggestions = $users;
            }
		}
        $result = [
            'query' => $query,
            'suggestions' => $suggestions,
        ];
        
        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
	}
}
