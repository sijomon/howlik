<?php

namespace App\Http\Controllers;

use App\Larapen\Helpers\Arr;
use App\Larapen\Helpers\Search;
//use App\Larapen\Models\Ad;
use App\Larapen\Models\Business;
use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\SubAdmin2;
//use App\Larapen\Models\AdType;
use App\Larapen\Models\Category;
use App\Larapen\Models\City;
use App\Larapen\Models\Language;
use App\Larapen\Models\GoogleSearchModel;
use App\Larapen\Models\GoogleSearchIdsModel;
use App\Larapen\Models\CategoryGoogleTypeModel;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;
use Larapen\LaravelLocalization\Facades\LaravelLocalization;
use Torann\LaravelMetaTags\Facades\MetaTag;

class SearchController extends FrontController
{
    protected $city = null; 
    
    /**
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        try {
            // Check Country URL for SEO
            $countries = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
            View::share('countries', $countries);
            
            $url_has_country = $countries->contains(function ($key, $value) {
                return slugify($value->get('name')) == Request::segment(3);
            });
            if ($url_has_country) {
                if (slugify($this->country->get('name')) != Request::segment(3)) {
                    $goodUrl = str_replace(Request::segment(3), slugify($this->country->get('name')), Request::url());
                    header('Location: ' . $goodUrl);
                    exit();
                }
            }
            // CATEGORIES COLLECTION
            $cats = Category::where('translation_lang', $this->lang->get('abbr'))->orderBy('lft')->get();
			//$cats = Category::where('translation_lang', 'EN')->orderBy('lft')->get();
            if (!is_null($cats)) {
                $cats = collect($cats)->keyBy('translation_of');
            }
			
            View::share('cats', $cats);
            
            // COUNT CATEGORIES ADS COLLECTION
            $sql = 'SELECT sc.id, c.parent_id, count(*) as total
                    FROM ' . DB::getTablePrefix() . 'business as a
                    INNER JOIN ' . DB::getTablePrefix() . 'categories as sc ON sc.id=a.category_id AND sc.active=1
				    INNER JOIN ' . DB::getTablePrefix() . 'categories as c ON c.id=sc.parent_id AND c.active=1
                    WHERE a.country_code = :country_code AND a.active=1 AND a.deleted_at IS NULL
                    GROUP BY sc.id';
            $bindings = ['country_code' => $this->country->get('code')];
            $count_sub_cat_biz = DB::select(DB::raw($sql), $bindings);
            $count_sub_cat_biz = collect($count_sub_cat_biz)->keyBy('id');
            View::share('count_sub_cat_biz', $count_sub_cat_biz);
            
            // COUNT PARENT CATEGORIES ADS COLLECTION
            $sql = 'SELECT c.id, count(*) as total
                    FROM ' . DB::getTablePrefix() . 'business as a
                    INNER JOIN ' . DB::getTablePrefix() . 'categories as sc ON sc.id=a.category_id AND sc.active=1
				    INNER JOIN ' . DB::getTablePrefix() . 'categories as c ON c.id=sc.parent_id AND c.active=1
                    WHERE a.country_code = :country_code AND a.active=1 AND a.deleted_at IS NULL
                    GROUP BY c.id';
            $bindings = ['country_code' => $this->country->get('code')];
            $count_cat_biz = DB::select(DB::raw($sql), $bindings);
            $count_cat_biz = collect($count_cat_biz)->keyBy('id');
            View::share('count_cat_biz', $count_cat_biz);
             
            
            // CATEGORY SELECTED
            $cat = null;
            // @todo: Fix country translation problem with $this->country->get('name')
            if (Input::has('c') or Request::segment(3) == slugify($this->country->get('name')) or (Request::segment(5) != '' and Request::segment(3) != trans('routes.t-search') and Request::segment(3) != trans('routes.t-search-location') and Request::segment(4) != 'user')) {
			    if (Input::has('c')) {
					if($this->lang->get('abbr')=='ar'){
						$arCat = Category::where('id',(int)Input::get('c'))->orderBy('lft')->first();
						$cat = $cats->get((int)$arCat->translation_of);
					}else{
						$cat = $cats->get((int)Input::get('c'));
					}
                } else {
                    $cat_slug = Request::segment(4);
                    if (Request::segment(5) == '') {
                        $cat = $cats->where('slug', $cat_slug)->flatten()->get(0);
                    } else {
                        $sub_cat_slug = Request::segment(5);
                        $cat = $cats->where('slug', $cat_slug)->flatten()->get(0);
                        $sub_cat = $cats->where('slug', $sub_cat_slug)->flatten()->get(0);
                        View::share('sub_cat', $sub_cat);
                    }
                }
                
				
                if (!isset($cat) or count($cat) <= 0) {
                    abort(404);
                }
                $this->cat = $cat;
                View::share('cat', $cat);
            }
            
            
            // CITIES COLLECTION
            $cities = City::where('country_code', '=', $this->country->get('code'))->take(100)->orderBy('population',
                'DESC')->orderBy('name')->get();
            View::share('cities', $cities);
            
            
            // ADTYPE COLLECTION
            /*$ad_types = AdType::orderBy('name')->get();
            View::share('ad_types', $ad_types);*/
          
            
            // CITY SELECTED
            if (Input::has('l') or Request::segment(3) == trans('routes.t-search-location') or Input::has('r')) {
                if (Input::has('r')) {
                    // NOTE: city = SubAdmin1 (Just for Search result page title)
                    $region = rawurldecode(Input::get('r'));
                    $city = SubAdmin2::where('code', 'LIKE', $this->country->get('code') . '.%')->where('name', 'LIKE',
                        $region . '%')->orderBy('name')->first();
                    if (is_null($city)) {
                        $city = SubAdmin1::where('code', 'LIKE', $this->country->get('code') . '.%')->where('name', 'LIKE',
                            $region . '%')->orderBy('name')->first();
                    }
                    if (is_null($city)) {
                        $tmp = preg_split('#(-| )+#', $region);
                        usort($tmp, function ($a, $b) {
                            return strlen($b) - strlen($a);
                        });
                        foreach ($tmp as $p_region) {
                            $city = SubAdmin2::where('code', 'LIKE', $this->country->get('code') . '.%')->where('name', 'LIKE',
                                '%' . $p_region . '%')->orderBy('name')->first();
                            if ($city) {
                                break;
                            }
                        }
                        if (is_null($city)) {
                            foreach ($tmp as $p_region) {
                                $city = SubAdmin1::where('code', 'LIKE', $this->country->get('code') . '.%')->where('name', 'LIKE',
                                    '%' . $p_region . '%')->orderBy('name')->first();
                                if ($city) {
                                    break;
                                }
                            }
                        }
                    }
                    
                    // If empty... then return collection of URL parameters
                    if (is_null($city)) {
                        $city = Arr::toObject(['name' => $region . ' (-)', 'subadmin1_code' => 0]);
                    }
                } else {
                    if (Input::has('l')) {
                        $city = City::find(Input::get('l'));
                    } else {
                        // Get City by Id
                        $city = City::find((int)Request::segment(5));
                        
                        // Get City by (raw) Name
                        if (is_null($city)) {
                            $city = City::where('country_code', $this->country->get('code'))->where('name', 'LIKE',
                                rawurldecode(Request::segment(4)))->first();
                            // Check helper 'core.php'
                            if (is_null($city)) {
                                $city = City::where('country_code', $this->country->get('code'))->where('name', 'LIKE',
                                    '% ' . rawurldecode(Request::segment(4)))->first();
                                if (is_null($city)) {
                                    $city = City::where('country_code', $this->country->get('code'))->where('name', 'LIKE',
                                        rawurldecode(Request::segment(4)) . ' %')->first();
                                }
                            }
                        }
                    }
                }
                
                if (!isset($city) or count($city) <= 0) {
                    abort(404);
                }
                $this->city = $city;
                View::share('city', $city);
            }
            
            // STATES COLLECTION => MODAL
            $states = SubAdmin1::where('code', 'LIKE', $this->country->get('code') . '.%')->orderBy('name')->get(['code', 'name'])->keyBy('code');
            View::share('states', $states);
        } catch (\ErrorException $e) {
            //echo "Error. Please try later. " . $e; exit();
			abort(404);
        }
    }
    
	public function index(HttpRequest $request)
    {
		$bTitle = 'title';
		if($request->session()->has('locale')){
			if($request->session()->get('locale')=='ar'){
				$bTitle = 'title_ar';
			}
		}
		
		if(Request::has('sort')) {
			if(Request::get('sort') == 'date') {
				$order	= 'date';
			} else if(Request::get('sort') == 'rating') {
				$order	= 'rating';
			} else {
				$order	= 'expense';
			}
		} else {
			$order	= 'date';
		}
		//?cn=KW&l=11231858&location=Al+Jaber&c=775&q=burger
		//country_code, city_code, language_code, latitude, longitude
        //$search = new Search($request, $this->country, $this->lang);
        //data = $search->setOrder($order)->getCityRegion()->getAddress()->getImage()->fechAll();
		$country_code = $request->session()->get('country_code');
		$lat = 0;
		if($this->country->has('c_latitude')){
			$lat = $this->country->get('c_latitude');
		}
		$lng = 0;
		if($this->country->has('c_longitude')){
			$lng = $this->country->get('c_longitude');
		}
		$tCode = 'X';
		if($this->country->has('code')){
			$tCode = $this->country->get('code');
		}
		if($request->session()->has('vin_geo_country_code')){
			if($request->session()->get('vin_geo_country_code')==$tCode){
				if($request->session()->has('vin_geo_latitude')){
					$lat = $request->session()->get('vin_geo_latitude');
				}
				if($request->session()->has('vin_geo_longitude')){
					$lng = $request->session()->get('vin_geo_longitude');
				}
			}
		}
		
		if(isset($this->city->latitude) && trim($this->city->latitude)!='') {
			$lat	= $this->city->latitude;
		}
		if(isset($this->city->longitude) && trim($this->city->longitude)!='') {
			$lng	= $this->city->longitude;
		}
		$srhWhere = '';
		$city_id = '';
		$city_name = '';
		if(isset($this->city->id)) {
			//$srhWhere .= " AND city_id='".$this->city->id."'";
			$city_id = $this->city->id;
			if($bTitle == 'title_ar'){
				$city_name = $this->city->name;
			}else{
				$city_name = $this->city->asciiname;
			} 	
		}elseif($request->session()->has('vin_geo_region')){
			$geo_region = $request->session()->get('vin_geo_region');
			$cityMdl = City::where(function ($query) use($geo_region){
				$query->where('name', $geo_region)->orWhere('asciiname',$geo_region);
			})->where('country_code', $tCode)->where('active', 1)->first();
			if(isset($cityMdl->id) && $cityMdl->id>0){
				$city_id = $cityMdl->id;
				//$srhWhere .= " AND city_id='".$city_id."'";
				if($bTitle == 'title_ar'){
					$city_name = $cityMdl->name;
				}else{
					$city_name = $cityMdl->asciiname;
				} 	
			}
		}	
		$sCat = '';
		$sCatId = '';
		if(isset($this->cat->name) && trim($this->cat->name)!='') {
			$sCat = trim($this->cat->name);
			$sCatId = $this->cat->id;
			$srhWhere .= " AND category_id='".$this->cat->id."'";
		}
		
		$gData['lat'] = $lat;
		$gData['lng'] = $lng;
		$gData['c_code'] = $country_code;
		$gData['cat'] = $sCat;
		$gData['cat_id'] = $sCatId;
		$gData['city_id'] = $city_id;
		$gData['img'] = 'yes';
		if((isset($request->q) && trim($request->q)!='') || $sCatId>0){
			$gData['keyword'] = trim($request->q);
			
			$searchId = 0;
			$gKeyword = array();
			$searchIdA = array();
			if($gData['keyword']=='' && $sCatId>0){
				$gTypes = CategoryGoogleTypeModel::where('category_id', $sCatId)->get();
				if(count($gTypes)>0){
					foreach($gTypes as $tkey => $tvalue){
						$gKeyword[] 	= trim($tvalue->google_type);
						$gData['type'] 	= trim($tvalue->google_type);
						$searchIdA[] 	= googlefetch($gData);
					}
				}
			}else{
				$searchId = googlefetch($gData);
				$gKeyword[] 	= trim($keyword);
			}
			$gKeyword = array_filter(array_unique($gKeyword));
			$searchIdA = array_filter(array_unique($searchIdA));
			
			$sKeyword 		  = addslashes(trim($request->q));
			$keyCatA = array();
			if($gData['keyword']!==''){
				$vCat = Category::select('id','translation_of')->where('name', $sKeyword)->get();
				if(count($vCat)>0){
					$keyCatA = array_column($vCat->toArray(), 'translation_of');
					$keyCatA = array_filter(array_unique($keyCatA));
				}
			}
						
			$srhWhere .= " AND (";
			$srhWhere .= $bTitle." LIKE '".$sKeyword."%' OR ".$bTitle." LIKE '%".$sKeyword."' OR ".$bTitle." LIKE '%".$sKeyword."%' ";
			//$srhWhere .= " OR keywordsgoogle LIKE '%".$sKeyword."%' ";
			if(count($gKeyword)>0){
				$srhWhere .= ' OR CONCAT(",", `keywordsgoogle`, ",") REGEXP ",('.implode('|', $gKeyword).')," ';
			}
			if(count($keyCatA)>0){
				$srhWhere .= ' OR CONCAT(",", `keywords`, ",") REGEXP ",('.implode('|', $keyCatA).')," ';
			}
			$srhWhere .= " ) ";
			View::share('sterm', $gData['keyword']);
			//print_r($gData);
		}
		
		View::share('scityid', $gData['city_id']);
		View::share('scity', $city_name);
		View::share('scat', $gData['cat_id']);
		
		if(count($searchIdA)>0 || $searchId>0){
			//$searchId = googlefetch($gData);
			//echo $searchId;
			if(is_array($searchIdA) && count($searchIdA)>0){
				$gIds = GoogleSearchIdsModel::select('googleId')->whereIn('searchId', $searchIdA)->get()->toArray();
			}else{
				$gIds = GoogleSearchIdsModel::select('googleId')->where('searchId', $searchId)->get()->toArray();
			}
			$gIdsA = array_column($gIds, 'googleId');
			if(count($gIdsA)>0){
				$srhWhere .= " OR (active='1' AND country_code='".$tCode."' AND googleId IN ('".implode("','", $gIdsA)."')) ";
			}
			
			$bizCnt = \DB::select("SELECT (
										3959 * acos (
										  cos ( radians(".$gData['lat'].") )
										  * cos( radians( lat ) )
										  * cos( radians( lon ) - radians(".$gData['lng'].") )
										  + sin ( radians(".$gData['lat'].") )
										  * sin( radians( lat ) )
										)
									  ) AS distance 
									  FROM business 
									  WHERE active='1' AND country_code='".$tCode."' ".$srhWhere." 
									  HAVING distance < 10 ");
									  
			$total = count($bizCnt);
			//$total = GoogleSearchIdsModel::where('searchId', $searchId)->count();
			$count['all'] = $total;
			$count['b'] = $total;
			$count['p'] = $count['all'] - $count['b'];
			
			$dcount = collect($count);
			
			$per_page = 10;
			$current_page = (Input::get('page') < 0) ? 0 : (int)Input::get('page');
			$sql_curr_limit = ($current_page <= 1) ? 0 : $per_page * ($current_page - 1);
			
			$biz = \DB::select("SELECT business.*, (
										3959 * acos (
										  cos ( radians(".$gData['lat'].") )
										  * cos( radians( lat ) )
										  * cos( radians( lon ) - radians(".$gData['lng'].") )
										  + sin ( radians(".$gData['lat'].") )
										  * sin( radians( lat ) )
										)
									  ) AS distance, 
									  (SELECT bi.filename FROM businessImages as bi WHERE bi.biz_id=business.id AND bi.active=1 LIMIT 1) as biz_image								  
									  FROM business 
									  WHERE active='1' AND country_code='".$tCode."' ".$srhWhere." 
									  HAVING distance < 10 ORDER BY distance LIMIT ".$sql_curr_limit.", ".$per_page);
									  
			$biz = new LengthAwarePaginator($biz, $total, $per_page, $current_page);
			$biz->setPath(Request::url());
			
			View::share('count', $dcount);
			View::share('biz', $biz);
        
        }else{
			$total = 0;
			$count['all'] = $total;
			$count['b'] = $total;
			$count['p'] = $count['all'] - $count['b'];
			
			$dcount = collect($count);
			
			
			$biz = new LengthAwarePaginator(null, 0, 10, 1);
			$biz->setPath(Request::url());
			
			View::share('count', $dcount);
			View::share('biz', $biz);	
		}
        // HEAD: BUILD TITLE & DESCRIPTION
        if (Request::segment(3) == trans('routes.t-search')) {
            $title = t('Search for') . ' ';
            if (Input::has('q') and Input::has('c') and Input::has('l')) {
                $title .= Input::get('q') . ' ' . $this->cat->name . ' - ' . $this->city->name;
            } else {
                if (Input::has('q') and Input::has('c') and !Input::has('l')) {
                    $title .= Input::get('q') . ' ' . $this->cat->name;
                } else {
                    if (Input::has('q') and !Input::has('c') and Input::has('l')) {
                        $title .= Input::get('q') . ' - ' . $this->city->name;
                    } else {
                        if (!Input::has('q') and Input::has('c') and Input::has('l')) {
                            $title .= $this->cat->name . ' - ' . $this->city->name;
                        } else {
                            if (Input::has('q') and !Input::has('c') and !Input::has('l')) {
                                $title .= Input::get('q');
                            } else {
                                if (!Input::has('q') and Input::has('c') and !Input::has('l')) {
                                    $title .= t('free business') . ' ' . $this->cat->name;
                                } else {
                                    if (!Input::has('q') and !Input::has('c') and Input::has('l')) {
                                        $title .= t('free business in') . ' - ' . $this->city->name;
                                    } else {
                                        if (Input::has('r')) {
                                            $title .= t('free business in') . ' ' . $this->city->name;
                                        } else {
                                            if (!Input::has('q') and !Input::has('c') and !Input::has('l') and !Input::has('r')) {
                                                $title = t('Latest free business');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $title = t('Free business in');
            if (Request::segment(3) == slugify($this->country->get('name'))) {
                $title .= ' ' . $this->cat->name;
            } else {
                if (Request::segment(3) == trans('routes.t-search-location')) {
                    $title .= ' ' . $this->city->name;
                }
            }
        }
        // Meta Tags
        MetaTag::set('title', $title . ', ' . $this->country->get('name'));
        MetaTag::set('description', $title);
        
		/*echo "<pre>";
		print_r($_SERVER);
		exit;*/
		if ($request->ajax() && $request->has('sort')) {
            return view('classified.search.inc.business');  
        }
        return view('classified.search.serp');
    }
	
    public function indexOld(HttpRequest $request)
    {
		if(Request::has('sort')) {
			if(Request::get('sort') == 'date') {
				$order	= 'date';
			} else if(Request::get('sort') == 'rating') {
				$order	= 'rating';
			} else {
				$order	= 'expense';
			}
		} else {
			$order	= 'date';
		}
		//?cn=KW&l=11231858&location=Al+Jaber&c=775&q=burger
		//country_code, city_code, language_code, latitude, longitude
        $search = new Search($request, $this->country, $this->lang);
        $data = $search->setOrder($order)->getCityRegion()->getAddress()->getImage()->fechAll();
		
		//echo "<pre>";print_r($data['biz']);die;
		
        View::share('count', $data['count']);
        View::share('biz', $data['biz']);
        
        
        // HEAD: BUILD TITLE & DESCRIPTION
        if (Request::segment(3) == trans('routes.t-search')) {
            $title = t('Search for') . ' ';
            if (Input::has('q') and Input::has('c') and Input::has('l')) {
                $title .= Input::get('q') . ' ' . $this->cat->name . ' - ' . $this->city->name;
            } else {
                if (Input::has('q') and Input::has('c') and !Input::has('l')) {
                    $title .= Input::get('q') . ' ' . $this->cat->name;
                } else {
                    if (Input::has('q') and !Input::has('c') and Input::has('l')) {
                        $title .= Input::get('q') . ' - ' . $this->city->name;
                    } else {
                        if (!Input::has('q') and Input::has('c') and Input::has('l')) {
                            $title .= $this->cat->name . ' - ' . $this->city->name;
                        } else {
                            if (Input::has('q') and !Input::has('c') and !Input::has('l')) {
                                $title .= Input::get('q');
                            } else {
                                if (!Input::has('q') and Input::has('c') and !Input::has('l')) {
                                    $title .= t('free business') . ' ' . $this->cat->name;
                                } else {
                                    if (!Input::has('q') and !Input::has('c') and Input::has('l')) {
                                        $title .= t('free business in') . ' - ' . $this->city->name;
                                    } else {
                                        if (Input::has('r')) {
                                            $title .= t('free business in') . ' ' . $this->city->name;
                                        } else {
                                            if (!Input::has('q') and !Input::has('c') and !Input::has('l') and !Input::has('r')) {
                                                $title = t('Latest free business');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            $title = t('Free business in');
            if (Request::segment(3) == slugify($this->country->get('name'))) {
                $title .= ' ' . $this->cat->name;
            } else {
                if (Request::segment(3) == trans('routes.t-search-location')) {
                    $title .= ' ' . $this->city->name;
                }
            }
        }
        // Meta Tags
        MetaTag::set('title', $title . ', ' . $this->country->get('name'));
        MetaTag::set('description', $title);
        
		/*echo "<pre>";
		print_r($_SERVER);
		exit;*/
		if ($request->ajax() && $request->has('sort')) {
            return view('classified.search.inc.business');  
        }
        return view('classified.search.serp');
    }
    
    public function category(HttpRequest $request)
    {
        // Get cat id
        $cat = Category::where('translation_lang', $this->lang->get('abbr'))->where('slug', 'LIKE', Request::segment(4))->first();
        
        $cat_id = ($cat) ? $cat->tid : 0;
        if (!isset($cat_id) or $cat_id <= 0 or !is_numeric($cat_id)) {
            abort(404);
        }
        
        $search = new Search($request, $this->country, $this->lang);
        $data = $search->setCategory($cat_id)->setRequestFilters()->fetch();
        
        // SEO
        $title = $cat->name . ' - ' . t('Free business :category in :location', ['category' => $cat->name, 'location' => $this->country->get('name')]);
        $description = str_limit(t('Free business :category in :location', [
                'category' => $cat->name,
                'location' => $this->country->get('name')
            ]) . '. ' . t('Looking for a product or service') . ' - ' . $this->country->get('name'), 200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        
        // Open Graph
        $this->og->title($title)->description($description)->type('website');
        if ($data['count']->get('all') > 0) {
            $filtered = $data['biz']->getCollection();
            if ($this->og->has('image')) {
                $this->og->forget('image')->forget('image:width')->forget('image:height');
            }
            /*
            foreach($pictures->get() as $picture) {
                $this->og->image(url('pic/x/cache/large/' . $picture->filename),
                    [
                        'width'     => 600,
                        'height'    => 600
                    ]);
            }
            */
        }
        View::share('og', $this->og);
        
        return view('classified.search.serp', $data);
    }
    
    public function subCategory(HttpRequest $request)
    {
        // Get sub-cat id
        $cat = Category::where('translation_lang', $this->lang->get('abbr'))->where('slug', 'LIKE', Request::segment(4))->with([
            'children' => function ($query) {
                $query->where('translation_lang', '=', $this->lang->get('abbr'))->where('slug', 'LIKE', Request::segment(5));
            }
        ])->first();
        $sub_cat_id = ($cat and count($cat->children) > 0) ? $cat->children->get(0)->tid : 0;
        
        
        if (!isset($sub_cat_id) or $sub_cat_id <= 0 or !is_numeric($sub_cat_id)) {
            if (!is_null($cat)) {
                return redirect($this->lang->get('abbr') . '/' . $this->country->get('icode') . '/' . slugify($this->country->get('name')) . '/' . $cat->slug);
            } else {
                abort(404);
            }
        }
        
        $search = new Search($request, $this->country, $this->lang);
        $data = $search->setSubCategory($sub_cat_id)->setRequestFilters()->fetch();
        
        // Meta Tags
        MetaTag::set('title', $cat->children->get(0)->name . ' - ' . t('Free business :category in :location',
                ['category' => $cat->name, 'location' => $this->country->get('name')]));
        MetaTag::set('description', t('Free business :category in :location', [
                'category' => $cat->children->get(0)->name,
                'location' => $this->country->get('name')
            ]) . '. ' . t('Looking for a product or service') . ' - ' . $this->country->get('name'));
        
        return view('classified.search.serp', $data);
    }
    
    public function location(HttpRequest $request)
    {
        $location = $this->city;
        if (is_null($location)) {
            abort(404);
        }
        
        $search = new Search($request, $this->country, $this->lang);
        $data = $search->setLocation($location->latitude, $location->longitude)->setRequestFilters()->fetch();
        
        // Meta Tags
        MetaTag::set('title',
            $location->name . ' - ' . t('Free business in :location', ['location' => $location->name]) . ', ' . $this->country->get('name'));
        MetaTag::set('description', t('Free business in :location',
                ['location' => $location->name]) . ', ' . $this->country->get('name') . '. ' . t('Looking for a product or service') . ' - ' . $location->name . ', ' . $this->country->get('name'));
        
        return view('classified.search/serp', $data);
    }
    
    public function user(HttpRequest $request)
    {
        $search = new Search($request, $this->country, $this->lang);
        $data = $search->setUser(Request::segment(5))->setRequestFilters()->fetch();
        
        return view('classified.search.serp', $data);
    }
}
