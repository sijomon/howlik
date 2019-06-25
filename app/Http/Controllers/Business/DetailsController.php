<?php 

namespace App\Http\Controllers\Business;

use App\Larapen\Helpers\Search;
use App\Larapen\Helpers\Ip;

use App\Larapen\Events\BusinessWasVisited;
//use App\Larapen\Events\MessageWasSent;
//use App\Larapen\Events\ReportAbuseWasSent;
use App\Larapen\Helpers\Rules;
use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessScam;
use App\Larapen\Models\Category;
use App\Larapen\Models\City;
use App\Larapen\Models\Message;
use App\Larapen\Models\BusinessImage;
use App\Larapen\Models\BusinessInfo;
use App\Larapen\Models\BusinessBookingTmSettings;
use App\Larapen\Models\BusinessBookingTblSettings;
use App\Larapen\Models\ReportType;
use App\Larapen\Models\BusinessOffer;
use App\Larapen\Models\BusinessVisit;
use App\Larapen\Models\OfferType;
use App\Larapen\Models\GiftPrice;
use App\Larapen\Models\Review;
use App\Larapen\Models\BusinessClaim;
use App\Larapen\Models\Gender;

use App\Http\Controllers\FrontController;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Larapen\TextToImage\Facades\TextToImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Ajax;
use Illuminate\Support\Facades\Mail;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Auth;
use Session;

class DetailsController extends FrontController
{
    public $msg = [];
    
    /**
     * Business expire time (in months)
     * @var int
     */
    public $expire_time = 3;
    
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        
        /*
         * Messages
         */
        $this->msg['message']['success'] = "Your message has send successfully to :seller_name.";
        $this->msg['report']['success'] = "Your report has send successfully to us. Thank you!";
        $this->msg['mail']['error'] = "The sending messages is not enabled. Please check the SMTP settings in the admin.";
    }
    
    /**
     * Show business listing's details.
     *
     * @return Response
    **/
    public function index(HttpRequest $request)
    {
		
        $dat		= array();		
        $biz_id		= getAdId(Request::segment(3));//->where('country_code', $this->country->get('code'))
		//if($biz_id==10486){
			googlefetchdetails($biz_id);
		//}
		$business	= Business::where('id', $biz_id)->with(['user', 'city', 'businessimages'])->first();
		
        if (!(is_numeric($biz_id) && isset($business->id))) {
            abort(404);
        }
        
		// Increment Business visits counter
		Event::fire(new BusinessWasVisited($business));
		
        // GET Business Listing INFO
        if (Auth::check()) {
            $business = Business::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->where('id', $biz_id)->with(['user', 'city', 'businessimages'])->first();
            // Unselect non-self business listing
            if (Auth::user()->id != $business->user_id) {
                $business = Business::where('id', $biz_id)->with(['user', 'city', 'businessimages'])->first();
            }
        }
        // Preview Business after activation
        if (Input::has('preview') and Input::get('preview')==1) {
            $business = Business::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->where('id', $biz_id)->with(['user', 'city', 'businessimages'])->first();
        }
        
        View::share('business', $business);
        
        // Business not found
        if (is_null($business)) {
            abort(404);
        }
        
        // GET Business Listing's CATEGORY
        $cat = Category::transById($business->category_id, $this->lang->get('abbr'));

        View::share('cat', $cat);
        
        // Business's Category not found
        if (is_null($cat)) {
            abort(404);
        }
        
        // GET PARENT CATEGORY
        if ($cat->parent_id == 0) {
            $parent_cat = $cat;
        } else {
            $parent_cat = Category::transById($cat->parent_id, $this->lang->get('abbr'));
        }
        View::share('parent_cat', $parent_cat);
        
        // GET SIMILAR BUSINESS IN SAME CATEGORY
        $keywords	=	DB::table('business')
						->select('business.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname')
						->leftjoin('cities', 'business.city_id', '=', 'cities.id')
						->where('business.category_id', 'like', $business->category_id)
						->where('business.country_code', $this->country->get('code'))
						->where('business.active', 1)
						->whereNotIn('business.id', [$business->id])
						->inRandomOrder()
						->limit(20)
						->get();
		$data['keywords'] = $keywords;	
        
        // REPORT ABUSE TYPE COLLECTION
        $report_types 	=	ReportType::where('translation_lang', $this->lang->get('abbr'))->get();
        View::share('report_types', $report_types);
        
        //echo "<pre>";print_r($business);die;
        // SEO
		if(!empty($business->city)) {
			$title = $business->title . ', ' . $business->city->name;
		} else {
			$title = $business->title;
		}
        $description = str_limit(str_strip($business->description), 200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        
        // Open Graph
        $this->og->title($title)->description($description)->type('article')->article(['author' => config('settings.facebook_page_url')])->article(['publisher' => config('settings.facebook_page_url')]);
        if (!$business->businessimages->isEmpty()) {
            if ($this->og->has('image')) {
                $this->og->forget('image')->forget('image:width')->forget('image:height');
            }
            foreach ($business->businessimages as $picture) {
                $this->og->image(url('pic/x/cache/large/' . $picture->filename), [
                    'width' => 600,
                    'height' => 600
                ]);
            }
        }
        View::share('og', $this->og);
        
        // Expiration Info
        $today_dt = Carbon::now($this->country->get('timezone')->time_zone_id);
        /*if ($today_dt->gt($business->created_at->addMonths($this->expire_time))) {
            flash()->error(t($this->msg['mail']['error']));
        }*/
        
        
        // Maintenance - Clean the Business's storage folders (pictures & resumes) /=======================================
        if (is_numeric($business->id)) {
            $picture_path = public_path() . '/uploads/';
            // for Pictures
            if ($business->businessimages->isEmpty()) {
                if (File::exists($picture_path . 'pictures/' . strtolower($business->country_code) . '/' . $business->id)) {
                    File::deleteDirectory($picture_path . 'pictures/' . strtolower($business->country_code) . '/' . $business->id);
                }
            }
            // for Resumes
            if (is_null($business->resume) or empty($business->resume)) {
                if (File::exists($picture_path . 'resumes/' . strtolower($business->country_code) . '/' . $business->id)) {
                    File::deleteDirectory($picture_path . 'resumes/' . strtolower($business->country_code) . '/' . $business->id);
                }
            }
        }
        
        //to print extra information
        $busInfoS 			= BusinessInfo::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->get();
        
		$infovalues 		= unserialize( $business->more_info );
		
		$data['informations'] 	= $busInfoS;
		
		$busInfoA = [];
		
		foreach($busInfoS as $key=>$val) {
			
			if(isset($infovalues[$val['translation_of']]) && trim($infovalues[$val['translation_of']]) != '') {
			
				$infoValsA = unserialize($val->info_vals);
				
				if(isset($infoValsA[$infovalues[$val['translation_of']]]) && $val['info_type'] != '1'){
					
					$tval = $infoValsA[$infovalues[$val['translation_of']]];
					
				}else{
					
					$tval = trim($infovalues[$val['translation_of']]);
				}
				
				$busInfoA[] = array('id' => $val['translation_of'],'label' => $val['info_title'], 'value' => $tval);
			}
		}
		View::share('busInfoA', $busInfoA);
		
		$offersS			=	BusinessOffer::withoutGlobalScopes([ActiveScope::class])->where('biz_id', $biz_id)->get();
		$data['offers']		=	$offersS;
		$offerty 			= 	OfferType::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->lists('title','translation_of');
		$data['offertype']	=	$offerty;
		
		        
        $countries	 =	$this->country->get('currency');  
		if($countries != '') {
			
			$currency = $countries->html_entity;
			View::share('currency', $currency);
		}
		
		if(isset($this->user->id)) {
			
			$review = Review::where('biz_id', $biz_id)->where('user_id', $this->user->id)->first();
			if(count($review) > 0) {  View::share('reviews', $review); }
		}
		
		$data['reviewArr'] 	=	Review::where('biz_id',$business->id)->orderBy('created_at', 'DESC')->get();
									
		$today_dt = Carbon::today($this->country->get('timezone')->time_zone_id);
		$tomorrow_dt = Carbon::tomorrow($this->country->get('timezone')->time_zone_id);
		
		//$bbtminfo = BusinessBookingTmSettings::where("biz_id", $biz_id)->orderBy('tm_from')->get();
		$bbtminfo = DB::select( DB::raw("SELECT bbs.*,
		(SELECT COUNT(id) as booking FROM businessTimeslotBooking btb WHERE btb.time_id=bbs.id AND created_at BETWEEN '$today_dt' AND '$tomorrow_dt') as booking
		FROM businessBookingTmSettings bbs WHERE bbs.biz_id = '$biz_id' ORDER BY bbs.tm_from") );
		
		// echo "<pre>";print_r($bbtminfo);die;
		
		// retrive max and min from business booking
		$data['rangesTbl'] = BusinessBookingTblSettings::select(DB::raw('min(tbl_from) as min_time, max(tbl_to) as max_time, min(seat_min) as min_seat, max(seat_max) as max_seat'))->where('biz_id', $business->id)->get();
		
		$data['locationArr']	=	DB::table('businessLocations')
									->select('businessLocations.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname', 'subadmin1.name as loname', 'subadmin1.asciiname as loasciiname', 'countries.name as coname', 'countries.asciiname as coasciiname', 'countries.phone as tele')
									->leftjoin('cities', 'businessLocations.city_id', '=', 'cities.id')
									->leftjoin('subadmin1', 'businessLocations.location_id', '=', 'subadmin1.code')
									->leftjoin('countries', 'businessLocations.country_id', '=', 'countries.code')
									->where('businessLocations.biz_id', $biz_id)
									->where('businessLocations.active', 1)
									->orderBy('businessLocations.created_at', 'asc')
									->get();
	
		// set current location details to session if have only one location	
		if(count($data['locationArr']) == 1) {
			
			if(Session::has('bizLocationNow')) {
				
				Session::forget('bizLocationNow');
			}
			Session::set('bizLocationNow', serialize($data['locationArr'][0]));
		}
		
		if(Auth::user()) {
			$user_id = Auth::user()->id;
			$bScam = BusinessScam::where('biz_id', $biz_id)->where('user_id', $user_id)->first();
		}else{
			$ip_addr  = Ip::get();
			$bScam = BusinessScam::where('biz_id', $biz_id)->where('ip_addr', $ip_addr)->whereDate('created_at', '=', date('Y-m-d'))->first();
		}	
		$bscamFlag = 0;
		if(isset($bScam->id)){
			$bscamFlag = 1;
		}
		View::share('bscamFlag', $bscamFlag);
		
		View::share('bbtminfo', $bbtminfo);
		View::share('hdr_datepicker', 1);
		View::share('hdr_rating', 1);
		View::share('hdr_dropzone', 1);
		View::share('hdr_socialsharejs', 1);
		
		$countryCode	=	DB::table('business')
							->where('id', $biz_id )
							->pluck('country_code');
											
		$timeZone	=	DB::table('time_zones')
						->where('country_code', $countryCode )
						->pluck('time_zone_id');
		
		$timeNoww = Carbon::now($timeZone[0])->format('H:i a');
		//echo $timeNow ; exit();
		//$timeNow = '05:43'; 
		//$timeNow = '17:43';
		//$timeNow = '03:43';
		
		View::share('timeNoww', $timeNoww);
        //===========================================================================================================
        // View
		//echo '<pre>';print_r($data);die;
		//echo '<pre>';
		//print_r($business->biz_hours);
		//echo $business->biz_hours; 
		//exit();
        return view('classified.business.details.index',$data);
    }
	
	public function bizLocAjax(HttpRequest $request){
		
		// unset current location details from session if have session value
		if(Session::has('bizLocationNow')) {
			
			Session::forget('bizLocationNow');
		}
		
		$content		=	'';
		$citynam		=	'';
		
		if(Request::has('id')){
			
			$id			=	Request::get('id');
			
			$location	=	DB::table('businessLocations')
							->select('businessLocations.*', 'business.web', 'cities.name as ciname', 'cities.asciiname as ciasciiname', 'subadmin1.name as loname', 'subadmin1.asciiname as loasciiname', 'countries.name as coname', 'countries.asciiname as coasciiname', 'countries.phone as tele')
							->leftjoin('business', 'businessLocations.biz_id', '=', 'business.id')
							->leftjoin('cities', 'businessLocations.city_id', '=', 'cities.id')
							->leftjoin('subadmin1', 'businessLocations.location_id', '=', 'subadmin1.code')
							->leftjoin('countries', 'businessLocations.country_id', '=', 'countries.code')
							->where('businessLocations.id', $id)
							->first();
			
			if(!empty($location)) {
				
				// set current location details to session if didn't have session value
				Session::set('bizLocationNow', serialize($location));
				
				if(Request::segment('1') == 'ar') {
					$citynam	=	$location->ciname;
				}
				else {
					$citynam	=	$location->ciasciiname;
				}
				
				$content	=	'<div class="col-md-4 col-sm-4">
									<div class="row">
										<iframe width="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q='.$location->lat.','.$location->lon.'&amp;key=AIzaSyAPHJSZW2HT2YXPFpfEOfPOO3LV-4tpEf4"></iframe>
									</div>
								</div>
								<div class="col-md-4">
									<div class="d-box1">
										<div class="d-box-div1 location-toggle"> <img src="http://www.howlik.com/assets/frontend/images/placeholder.svg" /> </div>
										<div class="d-box-div2">
											<p class="span1">'.$location->address_1.'</p>
											<p class="span2">'.$citynam.'</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="d-box1">
										<div class="d-box-div1"> <img src="http://www.howlik.com/assets/frontend/images/phone.svg"> </div>
										<div class="d-box-div2">
											<p class="span3">'.$location->phone.'</p>
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="d-box2">
										<div class="d-box-div1"> <img src="http://www.howlik.com/assets/frontend/images/direction.svg"> </div>
										<div class="d-box-div2"> <a href="#" class="span3" data-toggle="modal" data-target="#myModal"> '.t("Get Direction").' </a> </div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="d-box2">
										<div class="d-box-div1"> <img src="http://www.howlik.com/assets/frontend/images/web.svg"> </div>
										<div class="d-box-div2"> <a href="http://'.$location->web.'" target="_blank" class="span3"> '.$location->web.' </a> </div>
									</div>
								</div>';
			}
			
		}
		echo json_encode(array( 'content' => $content, 'cityname' => $citynam,'success' => 1));
	}
	
	function setBack(HttpRequest $request){
		if($request->has('action')){
			if($request->input('action')=='business'){
				$biz_id = $request->input('biz_id');
				$business = Business::select('title')->where('id', $biz_id)->first();
				if(count($business)>0){
					$link    =   "/".str_replace(' ', '-', $business->title)."/".$biz_id.".html";
				}else{
					$link    =   "/account";
				}
				session(['url.intended' => $link]);
			}
		}
		$reply['status'] = 'success';
		return json_encode($reply);
	}
    
	public function map(HttpRequest $request)
	{
		$data = array();
		
		$biz_id = getAdId(Request::segment(3));//->where('country_code', $this->country->get('code'))
		$business = Business::where('id', $biz_id)->with(['city', 'location'])->where('active', '1')->first();
		if (!(is_numeric($biz_id) && isset($business->id))) {
			abort(404);
		}
		
		View::share('business', $business);
		return view('classified.business.details.map');
	}
	
	public function claim(HttpRequest $request)
	{
		if(Auth::user()) {
			
			if($this->user->user_type_id != 2) {
				return '
					<div class="error-page" style="margin: 100px 0; text-align:center">
						<h2 class="headline text-center" style="font-size: 30px; float: none;"> You didn\'t have the permission to access this page. <br> Please login as a business user right now! </h2>
					</div>';
			}
			else {
				$data = array();
		
				$biz_id = getAdId(Request::segment(3));//->where('country_code', $this->country->get('code'))
				$business = Business::where('id', $biz_id)->with(['city', 'location'])->where('active', '1')->first();
				if (!(is_numeric($biz_id) && isset($business->id))) {
					abort(404);
				}
				
				$user_id = 0;
				if(isset(Auth::user()->id)){
					$user_id = Auth::user()->id;
					$busClaim = BusinessClaim::where('biz_id', $biz_id)->where('user_id',$user_id)->first();
				}
				
				$title = $business->title;
				$city = $business->city->asciiname;
				//echo '<pre>';
				//print_r($city); exit();
				if(isset($business->location->asciiname)){
					$location = $business->location->asciiname;
				}
				else{
					$location = null;
				}
				//echo '<pre>';
				//print_r($location); exit();
				
				if(strtolower($this->lang->get('abbr'))=='ar'){
					$title = $business->title_ar;
					$city = $business->city->name;
					$location = $business->location->name;
				}
				
				
				
				$details['biz_id'] = $business->id; 
				$details['title'] = $title;
				$details['city'] = $city;
				$details['location'] = $location;
				$details['country_code'] = $business->country_code;
				$details['claim_id'] = 0;
				if(isset($busClaim->id) && $busClaim->id>0){
					$details['cat'] = $busClaim->category_id;
					$details['phone'] = $busClaim->phone;
					$details['email'] = $busClaim->email;
					$details['address1'] = $busClaim->address1;
					$details['address2'] = $busClaim->address2;
					$details['zip'] = $busClaim->zip;
					$details['location_id'] = $busClaim->subadmin1_code;
					$details['city_id'] = $busClaim->city_id;
					$details['lat'] = $busClaim->lat;
					$details['lon'] = $busClaim->lon;
					$details['claim_id'] = $busClaim->id;
					$details['btn'] = 'Update this claim';
					$details['status'] = $busClaim->status; 
					$details['status_msg'] = $busClaim->status_msg;
				}else{
					$details['cat'] = $business->category_id;
					$details['phone'] = $business->phone;
					$details['email'] = $business->biz_email;
					$details['address1'] = $business->address1;
					$details['address2'] = $business->address2;
					$details['zip'] = $business->zip;
					$details['location_id'] = $business->subadmin1_code;
					$details['city_id'] = $business->city_id;
					$details['lat'] = $business->lat;
					$details['lon'] = $business->lon;
					$details['btn'] = 'Claim this business';
				}
				$categories = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->with([
					'children' => function ($query) {
						$query->where('translation_lang', $this->lang->get('abbr'));
					}
				])->orderBy('lft')->get();
				
				View::share('categories', $categories);
				
				$genders 	= Gender::where('translation_lang', $this->lang->get('abbr'))->get();
				View::share('genders', $genders);
				View::share('details', $details);
				return view('classified.business.details.claim');
			}
		}
	}
	
	public function claimpost(HttpRequest $request)
	{
		$reply['status'] = 'error';
		$reply['statusMsg'] = t('Unfortunately your request cannot be processed, Please contact Admin.');
		
		$user_id = 0;
		if(isset(Auth::user()->id)){
			$user_id = Auth::user()->id;
		}
		
		if ($request->has('biz_id')) {
			$category_id = $request->input('category_id');
			$biz_id = $request->input('biz_id');
			$phone = $request->input('phone');
			$email = $request->input('email');
			$address = $request->input('address');
			$address2 = $request->input('address2');
			$zip = $request->input('zip');
			$city = $request->input('city');
			$location = $request->input('location');
			$lat = $request->input('lat');
			$lon = $request->input('lon');
			
			$extraA['gender'] = $request->input('gender');
			$extraA['pemail'] = $request->input('pemail');
			$extraA['name'] = $request->input('name');
			$extraA['password'] = $request->input('password');
			
			$biz = Business::where('id', $biz_id)->where('user_id','<', 2)->first();
			if(isset($biz->id) && $biz->id>0){
				
				if($user_id>0){
					$busClaim = BusinessClaim::where('biz_id', $biz_id)->where('user_id',$user_id)->first();
				}
				
				if(!(isset($busClaim->id) && $busClaim->id>0)){
					$busClaim = new BusinessClaim();
				}
				$busClaim->category_id = $category_id;
				$busClaim->biz_id = $biz_id;
				$busClaim->user_id = $user_id;
				$busClaim->phone = $phone;
				$busClaim->email = $email;
				$busClaim->address1 = $address;
				$busClaim->address2 = $address2;
				$busClaim->zip = $zip;
				$busClaim->subadmin1_code = $location;
				$busClaim->city_id = $city;
				$busClaim->lat = $lat;
				$busClaim->lon = $lon;
				$busClaim->extra_details = serialize($extraA);
				$busClaim->save();
				$reply['status'] = 'success';
				$reply['statusMsg'] = t('Thank you for claiming this business, We will contact you back as soon as possible!');
				
				$msDet['subject'] = "Business claim request '".str_limit($biz->title, 50)."'";
				$business['title'] = $biz->title;
				$business['username'] = '';
				Mail::send('emails.business.claim', ['business' => $business], function ($m) use ($msDet) {
					$m->to(config('settings.app_email'), mb_ucfirst(config('settings.app_name')))->subject($msDet['subject']);
				});
			}
		}
		return json_encode($reply);
	}
	
	public function plist(HttpRequest $request) 
    { 
        $data = array();
		$slug = trim(str_replace('.html', '', Request::segment(3)));
		
		 // Get cat id
        $cat = Category::where('translation_lang', $this->lang->get('abbr'))->where('slug', 'LIKE', $slug)->where('parent_id', 0)->first();
        
        $cat_id = ($cat) ? $cat->tid : 0;
        if (!isset($cat_id) or $cat_id <= 0 or !is_numeric($cat_id)) {
            abort(404);
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
		
		$search	= new Search($request, $this->country, $this->lang);
        $data 	= $search->setCategory($cat_id)->setRequestFilters()->setOrder($order)->getCityRegion()->getImage()->getReview()->fetch();
		// echo "<pre>";print_r($data);die;
		
		$data['cat'] = $cat;
		
		$cats = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->orderBy('lft')->get();
        $data['cats'] = collect($cats)->keyBy('id');
		
		// SEO
        $title = $cat->name . ' - ' . t('Free ads :category in :location', ['category' => $cat->name, 'location' => $this->country->get('name')]);
        $description = str_limit(t('Free ads :category in :location', [
                'category' => $cat->name,
                'location' => $this->country->get('name')
            ]) . '. ' . t('Looking for a product or service') . ' - ' . $this->country->get('name'), 200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
		
		// View
		if ($request->ajax() && $request->has('sort')) {
            return view('classified.business.details.inc.prodlistpro', $data)->render();   
        }
        return view('classified.business.details.prodlist', $data);
	}
	
	public function productList(HttpRequest $request) {
		
        $products = Business::paginate(10);
		
        if ($request->ajax()) {
            return view('classified.business.details.test.presult', compact('products'));
        }
        return view('classified.business.details.test.productlist',compact('products'));
    }
	
    public function sendMessage(HttpRequest $request)
    {
        // Form validation
        $validator = Validator::make($request->all(), Rules::Message($request));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Get Business ID (input hidden from modal form)
        $biz_id = $request->input('business');
        if (!is_numeric($biz_id)) {
            abort(404);
        }
        
        // Get Business
        $business = Business::find($biz_id);
        if (is_null($business)) {
            abort(404);
        }
        
        // Store Message
        $message = new Message(array(
            'biz_id' => $biz_id,
            'name' => $request->input('sender_name'),
            'email' => $request->input('sender_email'),
            'phone' => $request->input('sender_phone'),
            'message' => $request->input('message'),
            'filename' => $request->input('filename'),
        ));
        $message->save();
        
        // Send a message to publisher
        Event::fire(new MessageWasSent($business, $message));
        
        // Success message
        if (!session('flash_notification')) {
            flash()->success(t($this->msg['message']['success'], ['seller_name' => $business->seller_name]));
        }
        
        return redirect($this->lang->get('abbr') . '/' . slugify($business->title) . '/' . $business->id . '.html');
    }
    
    public function sendReport(HttpRequest $request)
    {
        // Form validation
        $validator = Validator::make($request->all(), Rules::Report($request));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Get Business ID (input hidden from modal form)
        $biz_id = $request->input('business');
        if (!is_numeric($biz_id)) {
            abort(404);
        }
        
        // Get Business
        $business = Business::find($biz_id);
        if (is_null($business)) {
            abort(404);
        }
        
        // Store Report
        $report = [
            'biz_id' => $biz_id,
            'report_type_id' => $request->input('report_type'),
            'email' => $request->input('report_sender_email'),
            'message' => $request->input('report_message'),
        ];
        
        // Send Abus Report to admin
        Event::fire(new ReportAbuseWasSent($business, $report));
        
        // Success message
        if (!session('flash_notification')) {
            flash()->success(t($this->msg['report']['success']));
        }
        
        return redirect($this->lang->get('abbr') . '/' . slugify($business->title) . '/' . $business->id . '.html');
    }
	
	public function postReviews(HttpRequest $request)
	{
		//echo "<pre>";print_r($_POST);die;
		
		// Get Business
        $business = Business::find($request->biz_id);
		
        if (is_null($business)) {
            abort(404);
        }
		
		$rules 	= [
			'biz_id'	=>	'required',
			'usr_id'	=>	'required',
			'rating'	=>	'required',
			'review'	=>	'required',
			'expense'	=>	'required',
		];
		
		$messages = [
			'biz_id.required' => 'The Business is Not Found.',
			'usr_id.required' => 'The User is  Not Found.',
			'rating.required' => 'The Rating Field is required.',
			'review.required' => 'The Comments Field is required.',
			'expense.required' => 'The Expense Field is required.',
		];
		
		// Form validation
        $validator	=	Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

			return back()->withErrors($validator)->withInput();
		}
		
        // Store New Review
        if($request->biz_id != '' && $request->input('rating') != '' && $request->input('review') != '') {
			
			$addReview 				= new Review();
			$addReview->biz_id		= $request->input('biz_id');
			$addReview->user_id		= $request->input('usr_id');
			$addReview->user_name	= $request->input('usr_nm');
			$addReview->review		= $request->input('review');
			$addReview->rating		= $request->input('rating');
			$addReview->expense		= $request->input('expense');
			$addReview->save();
        
		}
		flash()->success(t('Your Review Placed Successfully.'));
        return redirect($this->lang->get('abbr') . '/' . slugify($business->title) . '/' . $business->id . '.html');
	}
}
