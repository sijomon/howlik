<?php
/*

* 	PendingPaymentAPI	- Pending Payment API
*	@Developers Team 	: Shrishti Info Solutions
*	@author				: vineeth.kk@shrishtionline.com
*	@date 				: 08/12/2016

*/

?>
<?php 
namespace App\Http\Controllers; 

use Illuminate\Support\Facades\View;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\DB;
use App\Larapen\Models\User;
use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessLocation;
use App\Larapen\Models\BusinessImage;
use App\Larapen\Models\Country as CountryModel;
use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\City;

use App\Larapen\Models\Category;
use App\Larapen\Models\CategoryGoogleTypeModel;
use Response;

class TestController extends FrontController
{
    function test_home(HttpRequest $request)
    {
		$data = array();
        
		if($this->lang->get('abbr')=='ar'){
			$langName = 'name';
		}else{
			$langName = 'asciiname';
		}
        // Get Categories
        $cats = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->orderBy('lft')->get();
        $data['cats'] = collect($cats)->keyBy('id');
        
        // SEO
        if (config('settings.app_slogan')) {
            $title = config('settings.app_slogan');
        } else {
            $title = t('Free local classified ads in :location', ['location' => $this->country->get('name')]);
        }
        $description = str_limit(str_strip(t('Sell and Buy products and services on :app_name in Minutes',
                ['app_name' => mb_ucfirst(config('settings.app_name'))]) . ' ' . $this->country->get('name') . '. ' . t('Free ads in :location',
                ['location' => $this->country->get('name')]) . '. ' . t('Looking for a product or service') . ' - ' . $this->country->get('name')),
            200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        
        // Open Graph
        $this->og->title($title)->description($description);
        View::share('og', $this->og);
        
		$gotoweb = false;
		if($request->session()->has('set_goto_web') && $request->session()->get('set_goto_web')=='gotoweb') {
			//$request->session()->forget('set_goto_web');
			$gotoweb = true;
		}
		$data['gotoweb'] = $gotoweb;
		
		return view('classified.home.welcome_test', $data);
    }
	
	public function setGotoweb(HttpRequest $request){
		$request->session()->put('set_goto_web', 'gotoweb');
		//return Response::json(array('status'=>'success'));
		return json_encode(array('status'=>'success'));
	}
	
	function latlngupdate(HttpRequest $request){
		echo "<pre>";
		$gKey = 'AIzaSyDrl_Ol85Qy2B-heR2VkRKr_lbKtFQAoVg';
		$countries = CountryModel::where('active', 1)->get();
		foreach($countries as $key => $country){
			$address = $country->asciiname;
			/*$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=$gKey&address=".urlencode($address)."&sensor=false");
			$json = json_decode($json);
			if(isset($json->results[0]->geometry->location->lat)){
				$c_lat = trim($json->results[0]->geometry->location->lat);
				$c_lng = trim($json->results[0]->geometry->location->lng);
				$country->c_latitude  = $c_lat;
				$country->c_longitude = $c_lng;
				$country->save();
			}*/
			$subA = array();
			$sub1 = SubAdmin1::where('code', 'LIKE', $country->code.'.%')->get();
			foreach($sub1 as $skey => $sub){
				$subcode = str_replace($country->code.'.', '', $sub->code);
				$subA[$subcode] = $sub->asciiname;
				$address = $sub->asciiname.','.$country->asciiname;
				/*$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=$gKey&address=".urlencode($address)."&sensor=false");
				$json = json_decode($json);
				if(isset($json->results[0]->geometry->location->lat)){
					$s_lat = trim($json->results[0]->geometry->location->lat);
					$s_lng = trim($json->results[0]->geometry->location->lng);
					$sub->s_latitude  = $s_lat;
					$sub->s_longitude = $s_lng;
					$sub->save();
				}*/
			}
			
			$cities = City::where('country_code', $country->code)->where('latitude',NULL)->get();
			print_r($subA);
			print_r($cities->toArray());
			foreach($cities as $ckey => $city){
				$address = $city->asciiname;
				$subcode = str_replace($country->code.'.', '', $city->subadmin1_code);
				if(isset($subA[$subcode]) && trim($subA[$subcode])!=''){
					$address .= ','.trim($subA[$subcode]);
				}
				$address .= ','.$country->asciiname;
				echo "<br />".$address;
				/*$json = file_get_contents("https://maps.google.com/maps/api/geocode/json?key=$gKey&address=".urlencode($address));
				$json = json_decode($json);
				if(isset($json->results[0]->geometry->location->lat)){
					$lat = trim($json->results[0]->geometry->location->lat);
					$lng = trim($json->results[0]->geometry->location->lng);
					$city->latitude  = $lat;
					$city->longitude = $lng;
					$city->save();
				}*/
			}
			
			/*echo "<pre>";
			print_r($sub1);
			exit;*/
		}
		//echo "<pre>";
		//print_r($countries);
		exit;
	}

	function ins_keyword(HttpRequest $request){
		//Update Subadmin Code
		/*
		$countries = CountryModel::select('code')->where('active', '1')->orderBy('code')->get();
		if(count($countries) > 0){
			foreach($countries as $key => $value){
				$code = $value->code;
				$cities = City::select('id', 'subadmin1_code')->where('active', '1')->where('country_code', $code)->get();
				if(count($cities) > 0){
					foreach($cities as $ckey => $cvalue){
						$subadmin1_code = str_replace($code.'.', '', $cvalue->subadmin1_code);//to make unique
						$cvalue->subadmin1_code = $subadmin1_code;
						$cvalue->save();
					}
				}
			}
		}
		exit;
		*/
		
		// Insert Google Type
		/*$kewords = '';
		$kewordsA = explode(',', $kewords);
		echo "<pre>";
		$category_id = 873;
		foreach($kewordsA as $key => $keword){
			$tCat = CategoryGoogleTypeModel::where('category_id', $category_id)->where('google_type', trim(strtolower($keword)))->first();
			if(isset($tCat->id) && $tCat->id>0){
				echo '<br />Already Exists! '.$keword;
			}else{
				$cat_info = array(
									'category_id' => $category_id,
									'google_type' => trim(strtolower($keword))
								);
				$category = new CategoryGoogleTypeModel($cat_info);
				//$category->save();
			}
		}*/
		echo "<pre>"; 
		/*$bizA = Business::where('country_code', 'KW')->where('id', 9510)->get();
		if(count($bizA) > 0){
			foreach($bizA as $key => $value){
				$cityA = \DB::select("SELECT cities.*, (
										3959 * acos (
										  cos ( radians(".$value->lat.") )
										  * cos( radians( latitude ) )
										  * cos( radians( longitude ) - radians(".$value->lon.") )
										  + sin ( radians(".$value->lat.") )
										  * sin( radians( latitude ) )
										)
									  ) AS distance 
									  FROM cities 
									  WHERE active='1' AND country_code='KW'
									  HAVING distance < 1 ORDER BY distance LIMIT 1");
				print_r($cityA);
			}
		}
									  
		exit;*/
		
		$gKey = 'AIzaSyDrl_Ol85Qy2B-heR2VkRKr_lbKtFQAoVg';//Verified
		//$gKey = 'AIzaSyAPHJSZW2HT2YXPFpfEOfPOO3LV-4tpEf4';//Not Verified
		//Fix business address
		//2019-05-02 11:15:44 ->whereDate('updated_at', '<', '2019-05-02 11:15:44')
		$bizA = Business::where('country_code', 'KW')->where('id', 9510)->get();
		if(count($bizA) > 0){
			foreach($bizA as $key => $value){
				//print_r($value->toArray());
				
				$url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$gKey.'&language=en&latlng='.trim($value->lat).','.trim($value->lon).'&sensor=true';
				$json = @file_get_contents($url);
				$data=json_decode($json);
				
				$value->activation_token = 1;
				
				if(isset($data->results[0]->address_components)){
					$sublocality 	= '';
					$locality 		= '';
					$subadmin1_code = '';
					$city 			= '';
					$city_id 		= '';
					$subadmin1		= '';
					$address_components = array_reverse($data->results[0]->address_components);
					foreach($address_components as $aKey => $aVal){
						if(isset($aVal->types) && is_array($aVal->types) && in_array('sublocality', $aVal->types)){
							if(trim($sublocality)=='')
							$sublocality 	  = trim($aVal->long_name);
						}
						if(isset($aVal->types) && is_array($aVal->types) && in_array('locality', $aVal->types)){
							if(trim($locality)=='')
							$locality = trim($aVal->long_name);
						}
						if(isset($aVal->types) && is_array($aVal->types) && in_array('administrative_area_level_1', $aVal->types)){
							$subadmin1 = trim($aVal->long_name);
						}
					}
					if(trim($locality)!=''){
						$city = trim($locality);
					}elseif(trim($sublocality)!=''){
						$city = trim($sublocality);
					}
					echo "<br /><br />".$url;
					echo "<br />".$value->asciiname. '-' .$city;
					
					$code = '';
					$SubAdmin1A = SubAdmin1::where('code', 'LIKE', $value->country_code.'.%')->where('asciiname', $subadmin1)->first();
					if(isset($SubAdmin1A->asciiname)){
						echo "<br />Yes".$SubAdmin1A->asciiname;
						$code = str_replace($value->country_code.'.', '', $SubAdmin1A->code);
					}else{
						
						$cot = SubAdmin1::select('code')->where('code', 'LIKE', $value->country_code.'.%')->orderBy('code', 'DESC')->first();
						if(!empty($cot)){
							$code1 = explode('.', $cot->code, 2);
							$code2 = $code1[1];
						}else{
							$code2 ='00';
						}
						
						$subadmin_code = $code2 + 01;
						$code = str_pad($subadmin_code,  2, "0",STR_PAD_LEFT);
						$subadmin_code1 = $value->country_code.".".$code;
						echo "<br />No ".$subadmin_code1.'-'.$subadmin1;
						
						$tQry = new SubAdmin1();
						$tQry->code 	 = $subadmin_code1;
						$tQry->name 	 = $subadmin1;
						$tQry->asciiname = $subadmin1;
						$tQry->active 	 = 1;
						$tQry->save();
			
					}
					
					if(!(strlen($city) != mb_strlen($city, 'utf-8')) && trim($city)!=''){
						echo "<br />Code= ".$code;
						$cityA = City::where('country_code', $value->country_code)->where('asciiname', $city)->first();
						if(isset($cityA->asciiname)){
							$city_id	= $cityA->id;
							if(trim($cityA->subadmin1_code)==''){
								$cityA->subadmin1_code 	 = $code;
								$cityA->save();
							}
							$code  = $cityA->subadmin1_code;
						}else{
							$time_zone = '';
							$city1 = City::where('country_code', $value->country_code)->where('time_zone', '!=', '')->first();
							if(isset($city1->time_zone)){
								$time_zone = $city1->time_zone;
							}
							$cityA = new City();
							$cityA->country_code = $value->country_code;
							$cityA->name 		 = $city;
							$cityA->asciiname 	 = $city;
							$cityA->latitude 	 = trim($value->lat);
							$cityA->longitude 	 = trim($value->lon);
							$cityA->subadmin1_code 	 = $code;
							$cityA->time_zone 	 = $time_zone;
							$cityA->active 	 	 = 1;
							$cityA->save();
							$city_id	= $cityA->id;
						}
					}
					
					if($city_id>0){
						$value->subadmin1_code	= $code;
						$value->city_id			= $city_id;
					}else{
						echo "<br />=============".$value->googleId.'-'.$value->id.'-'.$city.'-'.$code;
					}
					print_r($address_components);
					
				}
				$value->save();				
			}
		}
		exit;
		/*
		//Fix Cities
		$cityA = City::where('country_code', 'KW')->get();
		if(count($cityA) > 0){
			echo "<pre>";
			foreach($cityA as $key => $value){
				$url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$gKey.'&latlng='.trim($value->latitude).','.trim($value->longitude).'&sensor=true';
				$json = @file_get_contents($url);
				$data=json_decode($json);
				
				if(isset($data->results[0]->address_components)){
					$sublocality 	= '';
					$locality 		= '';
					$subadmin1_code = '';
					$city 			= '';
					$city_id 		= '';
					$subadmin1		= '';
					$address_components = array_reverse($data->results[0]->address_components);
					foreach($address_components as $aKey => $aVal){
						if(isset($aVal->types) && is_array($aVal->types) && in_array('sublocality', $aVal->types)){
							if(trim($sublocality)=='')
							$sublocality 	  = trim($aVal->long_name);
						}
						if(isset($aVal->types) && is_array($aVal->types) && in_array('locality', $aVal->types)){
							if(trim($locality)=='')
							$locality = trim($aVal->long_name);
						}
						if(isset($aVal->types) && is_array($aVal->types) && in_array('administrative_area_level_1', $aVal->types)){
							$subadmin1 = trim($aVal->long_name);
						}
					}
					if(trim($locality)!=''){
						$city = trim($locality);
					}elseif(trim($sublocality)!=''){
						$city = trim($sublocality);
					}
					echo "<br /><br />".$url;
					echo "<br />".$value->asciiname. '-' .$city;
					if(!(strlen($city) != mb_strlen($city, 'utf-8')) && trim($city)!=''){
						$value->asciiname 	= trim($city);
						//$value->save();
					}
					
					$value->subadmin1_code = '';
					$SubAdmin1A = SubAdmin1::where('code', 'LIKE', $value->country_code.'.%')->where('asciiname', $subadmin1)->first();
					if(isset($SubAdmin1A->asciiname)){
						echo "<br />Yes".$SubAdmin1A->asciiname;
						$code = str_replace($value->country_code.'.', '', $SubAdmin1A->code);
						$value->subadmin1_code = $code;
					}else{
						echo "<br />No".$subadmin1;
					}
					$value->save();
					print_r($address_components);
					
				} 
			}
		}
		exit;*/
		
		//Fix Subadmin
		/*$SubAdmin1A = SubAdmin1::where('code', 'LIKE', 'KW.%')->get();
		if(count($SubAdmin1A) > 0){
			echo "<pre>";
			
			foreach($SubAdmin1A as $key => $value){
				$url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$gKey.'&latlng='.trim($value->s_latitude).','.trim($value->s_longitude).'&sensor=true';
				$json = @file_get_contents($url);
				$data=json_decode($json);
				
				if(isset($data->results[0]->address_components)){
					$country_code 	= '';
					$address1 		= '';
					$address2 		= '';
					$zip 			= '';
					$subadmin1_code = '';
					$city 			= '';
					$city_id 		= '';
					$subadmin1		= '';
					$address_components = array_reverse($data->results[0]->address_components);
					foreach($address_components as $aKey => $aVal){
						if(isset($aVal->types) && is_array($aVal->types) && in_array('administrative_area_level_1', $aVal->types)){
							$subadmin1 = trim($aVal->long_name);
						}
					}
					echo "<br />".$value->asciiname;
					$value->asciiname 	= $subadmin1;
					
					print_r($address_components);
					print_r($value->toArray());
					$value->save();
				} 
			}
		}
		exit;*/
		
		//Update Missing address
		/*$gKey = 'AIzaSyDrl_Ol85Qy2B-heR2VkRKr_lbKtFQAoVg';
		$biz = Business::where('googleId', '!=', '')->where('city_id', 0)->orderBy('id')->get();
		$t = 1;
		if(count($biz) > 0){
			echo "<pre>";
			
			foreach($biz as $key => $value){
				///maps/api/geocode/json?sensor=true&key=AIzaSyDrl_Ol85Qy2B-heR2VkRKr_lbKtFQAoVg&
				$url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$gKey.'&latlng='.trim($value->lat).','.trim($value->lon).'&sensor=true';
				$json = @file_get_contents($url);
				//$json = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?placeid=".$value->googleId."&fields=address_component&key=$gKey");//&fields=photo,user_ratings_total,formatted_phone_number,opening_hours,website,rating,review
				$data=json_decode($json);
				
				if(isset($data->results[0]->address_components)){
					$country_code 	= '';
					$address1 		= '';
					$address2 		= '';
					$zip 			= '';
					$subadmin1_code = '';
					$city 			= '';
					$city_id 		= '';
					$address_components = array_reverse($data->results[0]->address_components);
					foreach($address_components as $aKey => $aVal){
						//address_1 	address_2 	phone 	country_id 	location_id 	city_id 	zip_code
						//country_code address1	address2	zip	subadmin1_code	city_id
						if(isset($aVal->types) && is_array($aVal->types) && in_array('premise', $aVal->types)){
							$address1 = trim($aVal->long_name);
						}
						if(isset($aVal->types) && is_array($aVal->types) && in_array('sublocality', $aVal->types)){
							$address2 = trim($aVal->long_name);
							$city 	  = trim($aVal->long_name);
						}
						if(isset($aVal->types) && is_array($aVal->types) && in_array('country', $aVal->types)){
							$country_code = trim($aVal->short_name);
						}
						if(isset($aVal->types) && is_array($aVal->types) && in_array('locality', $aVal->types)){
							$city = trim($aVal->long_name);
						}
						
						$cityM = City::where('asciiname', $city)->where('country_code', $country_code )->first();
						if(isset($cityM->id) && $cityM->id>0){
							$city_id = $cityM->id;
							$subadmin1_code = $cityM->subadmin1_code;
							$subadmin1_code = str_replace($country_code.'.','',$subadmin1_code);//to make unique
							$subadmin1_code = $country_code.'.'.$subadmin1_code;
						}else{
							if(isset($aVal->types) && is_array($aVal->types) && in_array('administrative_area_level_1', $aVal->types)){
								$subadmin1 = trim($aVal->long_name);
								echo $subadmin1.$country_code;
								$subAfminMdl = SubAdmin1::where('asciiname', $subadmin1)->where('code', 'LIKE', $country_code.'.%')->first();
								if(isset($subAfminMdl->id)){
									print_r($subAfminMdl->toArray());
								}
							}
						}
					}
					$value->address1 	= $address1;
					$value->city_id 	= $city_id;
					$value->subadmin1_code  = $subadmin1_code;
					$value->country_code 	= $country_code;
					
					print_r($address_components);
					print_r($value->toArray());
					exit;
					//$value->save();
					
					$locationMdl = BusinessLocation::where('biz_id', $value->id)->first();
					if(isset($locationMdl->id) && $locationMdl->id>0){
						$locationMdl->address_1 	= $address1;
						$locationMdl->city_id 		= $city_id;
						$locationMdl->location_id  	= $subadmin1_code;
						$locationMdl->country_id 	= $country_code;
						$locationMdl->save();
					}
					
					//print_r($data->result->address_components);
					//echo "<br />".$data->results[0]->formatted_address;
					echo "<br />".$address1.' - '.$address2.' - '.$city.' - '.$city_id.' - '.$subadmin1_code.' - '.$country_code;
				} 
				echo "<br /> $t) ".$value->id.' - '.$value->title .' - '. $value->lat.' - '. $value->lon.' - '. $value->googleId;
				$t++;
			}
		}
		*/
		
		/*
		//Update subadmin with country code
		$biz = Business::where('googleId', '!=', '')->where()->orderBy('id')->get();
		$t = 1;
		if(count($biz) > 0){
			foreach($biz as $key => $value){
				$subadmin1_code = $value->subadmin1_code;
				$country_code 	= $value->country_code;
				if($subadmin1_code!=''){
					$subadmin1_code = str_replace($country_code.'.','',$subadmin1_code);//to make unique
					$subadmin1_code = $country_code.'.'.$subadmin1_code;
					$value->subadmin1_code = $subadmin1_code;
					$value->save();
				}
				
				echo "<br /> $t) ".$value->id.' - '.$country_code .' - '. $subadmin1_code.' - '. $value->city_id;
				$t++;
			}
		}
		exit;
		*/
		
		/*
		//Update category from keywords
		$biz = Business::where('googleId', '!=', '')->where('category_id', 0)->orderBy('id')->limit(200)->get();
		$t = 1;
		if(count($biz) > 0){
			foreach($biz as $key => $value){
				//googlefetchdetails($value->id);
				$google_keywords = $value->keywordsgoogle;
				$gKeywords = array_filter(array_unique(explode(',', $google_keywords)));
				$cat_id = 0;
				if(is_array($gKeywords) && count($gKeywords)>0){
					$cat_id = get_cat_from_key($gKeywords);
				}
				$value->category_id = $cat_id;
				$value->save();
				echo "<br /> $t) ".$value->id.' - '.$cat_id .' - '. $value->keywordsgoogle.' - '.$value->title;
				$t++;
			}
		} 
		exit;
		*/
		
		//For inserting google keywords.
		/*$parent_id = 873;
		$kewords = '';
		$kewordsA = explode(',', $kewords);
		echo "<pre>";
		foreach($kewordsA as $key => $keword){
			$tCat = Category::where('parent_id', $parent_id)->where('name', trim(strtolower($keword)))->where('translation_lang', 'en')->first();
			if(isset($tCat->id) && $tCat->id>0){
				$tCat->active = 1;
				$tCat->save();
				echo "<br />".trim(strtolower($keword));	
			}else{
				$cat_info = array(
									'translation_lang' => 'en',
									'parent_id' => $parent_id,
									'name' => trim(strtolower($keword)),
									'slug' => slugify(trim(strtolower($keword))),
									'description' => trim(strtolower($keword)),
									'active' => 1,
								);
				$category = new Category($cat_info);
				$category->save();
				$category->translation_of = $category->id;
				$category->save();
				//print_r($cat_info);
			}
		}*/
		
		//Remove Duplicate
		/*echo "<pre>";
		$biz = \DB::select("SELECT MAX(id) as bid, COUNT(id) as cid, googleId FROM `business` WHERE googleId!='' GROUP BY googleId ORDER BY cid DESC");
		foreach($biz as $key => $value){
			if($value->cid>1){
				Business::where('id', $value->bid)->delete();
				BusinessLocation::where('biz_id', $value->bid)->delete();
				BusinessImage::where('biz_id', $value->bid)->delete();
			}
		}
		exit;*/
	}
	
	function vdet(HttpRequest $request){
		
		/*echo "<pre>";
		$cat = Category::where('parent_id', 0)->where('active', 1)->where('translation_lang', 'en')->orderBy('name')->get();
		foreach($cat as $key => $value){
			echo "<br />".$value->name;
		}
		exit;
		
		$biz = Business::where('googleId', '!=', '')->where('category_id', 0)->orderBy('id')->limit(200)->get();
		
		$t = 1;
		if(count($biz) > 0){
			foreach($biz as $key => $value){
				$google_keywords = $value->keywordsgoogle;
				$gKeywords = array_filter(array_unique(explode(',', $google_keywords)));
				$cat_id = 0;
				if(is_array($gKeywords) && count($gKeywords)>0){
					$cat_id = get_cat_from_key($gKeywords);
				}
				echo "<br /> $t) ".$value->id.' - '.$cat_id .' - '. $value->keywordsgoogle;
				$t++;
			}
		} 
		exit;*/
		echo "<pre>";
		$gKey = 'AIzaSyDrl_Ol85Qy2B-heR2VkRKr_lbKtFQAoVg';
		$gKey = 'AIzaSyC-7PxJuZIVZMQOteUn24i8wylaFyn6OEA';
		$googleId = 'ChIJgfVVImIcLz4RG6HMk3RvQIA';//,scope,name,photo,formatted_address
		if(isset($_GET['id'])){
			$googleId = trim($_GET['id']);
		}
		$json = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?key=$gKey&placeid=".$googleId."&fields=photo,user_ratings_total,formatted_phone_number,opening_hours,website,rating,review,price_level");//
		$json = json_decode($json);
		print_r($json);
		exit;
		$bizHoursA = array();
		if(isset($json->result->opening_hours->periods) && is_array($json->result->opening_hours->periods) && count($json->result->opening_hours->periods)>0){
			$tA = array();
			$sortA = array();
			foreach($json->result->opening_hours->periods as $key => $opening_hours){
				if(isset($opening_hours->open->time) && isset($opening_hours->close->time)){
					$openH = ceil($opening_hours->open->time / 100);
					$openM = ($opening_hours->open->time % 100);
					$open  = sprintf('%02d', $openH).'.'.sprintf('%02d', $openM);
					
					$closeH = ceil($opening_hours->close->time / 100);
					$closeM = ($opening_hours->close->time % 100);
					$close  = sprintf('%02d', $closeH).'.'.sprintf('%02d', $closeM);
					
					$bizHourStr = $opening_hours->open->day.' '.$open.' '.$close;
					
					$bizhrsA = explode(' ', $bizHourStr);
					if(isset($tA[$bizhrsA[0]]))
						$tsize = count($tA[$bizhrsA[0]]);
					else
						$tsize =0;
					$tA[$bizhrsA[0]][$tsize] = $bizhrsA;
					$sortA[$bizhrsA[0]][$tsize] = $bizhrsA[1];
				}elseif(isset($opening_hours->open->time)){
					$openH = ceil($opening_hours->open->time / 100);
					$openM = ($opening_hours->open->time % 100);
					$open  = sprintf('%02d', $openH).'.'.sprintf('%02d', $openM);
					
					$closeH = ceil(0000 / 100);
					$closeM = (0000 % 100);
					$close  = sprintf('%02d', $closeH).'.'.sprintf('%02d', $closeM);
					
					for($i = $opening_hours->open->day; $i<=6; $i++){
						$bizHourStr = $i.' '.$open.' '.$close;
						
						$bizhrsA = explode(' ', $bizHourStr);
						if(isset($tA[$bizhrsA[0]]))
							$tsize = count($tA[$bizhrsA[0]]);
						else
							$tsize =0;
						$tA[$bizhrsA[0]][$tsize] = $bizhrsA;
						$sortA[$bizhrsA[0]][$tsize] = $bizhrsA[1];
					}
				}
			}
			
			foreach($tA as $key => $value){
				array_multisort($sortA[$key], SORT_ASC, $value);
				foreach($value as $key1 => $value1){
					$bizHoursA[] = implode(' ', $value1);
				}
			}
		}
		exit;
	}
	
	function vtest(HttpRequest $request){
		if(isset($request->id) && $request->id>0){
			$gSearch = \DB::select("SELECT url FROM `businessGoogleSearch` WHERE id='".$request->id."'");
			if(isset($gSearch[0]->url) && trim($gSearch[0]->url)!=''){
				$url = trim($gSearch[0]->url);
				echo "<br />".$url."<br />";
				$url = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=AIzaSyC-7PxJuZIVZMQOteUn24i8wylaFyn6OEA&radius=5000&location=29.33451528980282+48.08431273909204&type=&keword=Airport';
				echo "<br />".$url."<br />";
				$result = curl_fetch($url);
				$resA = json_decode($result);
				echo "<pre>"; 
				print_r($resA); 
				exit;
			}
		}
	}
}