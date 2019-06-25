<?php 

namespace App\Http\Controllers\Business;

use App\Larapen\Helpers\Search;

use App\Larapen\Events\BusinessWasVisited;
//use App\Larapen\Events\MessageWasSent;
//use App\Larapen\Events\ReportAbuseWasSent;
use App\Larapen\Helpers\Rules;

use App\Larapen\Models\Business;
use App\Larapen\Models\Category;
use App\Larapen\Models\City;
use App\Larapen\Models\Message; 
use App\Larapen\Models\BusinessImage;
use App\Larapen\Models\BusinessInfo;
use App\Larapen\Models\BusinessLocation;
use App\Larapen\Models\ReportType;
use App\Larapen\Models\GiftCertificate;
use App\Larapen\Models\GiftRecipient;
use App\Larapen\Models\GiftPrice;
use App\Larapen\Models\User;
use App\Larapen\Models\PaypalLog;
use App\Larapen\Models\businessImageRequest;

use App\Http\Controllers\FrontController;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use Torann\LaravelMetaTags\Facades\MetaTag;
use Larapen\TextToImage\Facades\TextToImage;
use Illuminate\Http\Request as HttpRequest;
use Carbon\Carbon;
use Auth;
use Response;

use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;

class ExtraController extends FrontController
{
    public $msg = [];
    
    /**
     * Business expire time (in months)
     * @var int
     */
    public $expire_time = 3;
    
    /**
     * Show business listing's details.
     *
     * @return Response
    **/
    public function index(HttpRequest $request)
    {
		
        $data = array();
        
        $biz_id 	= 	Request::segment(3);
		$business	= 	DB::table('business')
						->select('business.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname')
						->leftjoin('cities', 'business.city_id', '=', 'cities.id')
						->where('business.country_code', $this->country->get('code'))
						->where('business.id', $biz_id)
						->first();
		
		if (!(is_numeric($biz_id) && isset($business->id))) {
            abort(404);
        }
        
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
        
        $data['prices']	=	GiftPrice::where('active', 1)->lists('price','id');
		
        // Business not found
        if (is_null($business)) {
            abort(404);
        }  
                
        $countries	 =	$this->country->get('currency');  
		if($countries != '') {
			
			$currency = $countries->html_entity;
			View::share('currency', $currency);
		}  
        
        // SEO
        $title = $business->title . ', ' . $business->city->name;
        $description = str_limit(str_strip($business->description), 200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        
        // echo "<pre>";print_r($this->msg);die;
		
        // Expiration Info
        $today_dt = Carbon::now($this->country->get('timezone')->time_zone_id);
        if ($today_dt->gt($business->created_at->addMonths($this->expire_time))) {
			if( count($this->msg) ) {
				flash()->error(t($this->msg['mail']['error']));
			}
        }

        // View
        return view('classified.business.details.create-certificates',$data);
    }
    
	public function postCertificate(HttpRequest $request)
	{
		
		$biz_id 	= $request->input('biz_id');
		
		$business	= 	DB::table('business')
						->select('business.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname')
						->leftjoin('cities', 'business.city_id', '=', 'cities.id')
						->where('business.country_code', $this->country->get('code'))
						->where('business.id', $biz_id)
						->first();
		
		if (!(is_numeric($biz_id) && isset($business->id))) {
			abort(404);
		}
        
        $rules 	= [
		
			'biz_id'			=>	'required',
			'gift_quantity'		=>	'required|numeric',
			'gift_amount'		=>	'required|numeric',
		];
		
		$messages = [
		
			'biz_id.required' => 'The Business is required.',
			'gift_quantity.required' => 'The Quantity is required.',
			'gift_quantity.numeric' => 'The Quantity must be a number.',
			'gift_amount.required' => 'The Price is required.',
			'gift_amount.numeric' => 'The Price must be a number.',
		];
		
		// Form validation
        $validator	=	Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

			return back()->withErrors($validation)->withInput($request->all());
		}
		
		// get location details from session if exist
		$biz_loc = '';
		if($this->lang->get('abbr') == 'ar') {
			
			$loc_biz = $business->ciname;
			$biz_ttl = $business->title_ar;
		}
		else {
			
			$loc_biz = $business->ciasciiname;
			$biz_ttl = $business->title;
		}
		if(Session::has('bizLocationNow')) {
			
			$biz_loc = Session::get('bizLocationNow');
			$locaton = unserialize($biz_loc);
			if($this->lang->get('abbr') == 'ar') {
			
				$loc_biz = $locaton->ciname;
			}
			else {
				
				$loc_biz = $locaton->ciasciiname;
			}
		}
		
        // Store New Gift Certificate
        if($biz_id != '' && $request->input('gift_quantity') != '' && $request->input('gift_amount') != '') {
			
			$newCertificate 				= new GiftCertificate();
			$newCertificate->biz_id			= $biz_id;
			$newCertificate->biz_loc		= $biz_loc;
			$newCertificate->total_quantity	= $request->input('gift_quantity');
			$newCertificate->each_price		= $request->input('gift_amount');
			$newCertificate->total_price	= $request->input('gift_quantity') * $request->input('gift_amount');
			$newCertificate->active			= 1;
			$newCertificate->save();
        
		}
        
		// Store New Gift Recipient
        if($request->input('sender_id') != '' && $request->input('gift_quantity') != '') {
			
			$sender = 	User::find($request->input('sender_id'))->toArray();
			$total	=	$request->input('gift_quantity');
			$idStr	=	'';
			if(!empty($total)) {
				
				for($i=0;$i<=$total-1;$i++) {
					
					$newRecipient  						= new GiftRecipient();
					$newRecipient->biz_id 				= $biz_id;
					$newRecipient->gift_id 				= $newCertificate->id;
					$newRecipient->gift_code			= getRandWord(8);
					$newRecipient->recipient_name		= $_POST['recipient_name'][$i];
					$newRecipient->recipient_email		= $_POST['recipient_email'][$i];
					$newRecipient->recipient_message	= $_POST['recipient_message'][$i];
					$newRecipient->sender_name			= $_POST['sender_name'][$i];
					$newRecipient->sender_id			= $request->input('sender_id');
					$newRecipient->active				= 1;
					$newRecipient->save();
					
					Mail::send('emails.certificate.sendCertificates', ['title' => $biz_ttl,'location' => $loc_biz,'businessimages' => $business->businessimages,'sender' => $newRecipient->sender_name,'recipient' => $newRecipient->recipient_name,'code' => $newRecipient->gift_code], function($message) use ($business,$newRecipient,$loc_biz,$biz_ttl) {
				
						$message->to($newRecipient->recipient_email);
						$message->subject('Howlik Gift Certificate');		
					});
				}
			}
		}
		flash()->success(t('Coupon Purchased Successfully!'));
        return redirect($this->lang->get('abbr').'/create/'.$business->id.'/certificate');
    }
    
	
    public function sendCertificate(HttpRequest $request) {
		
		$gif_id 	 =	Request::segment(3);
		
		$recipient	 =	GiftRecipient::where('id', $gif_id)->where('active', '1')->first();
		
        if (!(is_numeric($gif_id) && isset($recipient->id))) {
			
            abort(404);
        }
        
        View::share('recipient', $recipient);
        
		$certificate =	GiftCertificate::where('id', $recipient->gift_id)->where('active', '1')->first();
        $business	 =	Business::where('id', $certificate->biz_id)->where('active', '1')->first();
        
        View::share('business', $business);
		
        return view('emails.certificate.sendCertificate');
	}
	
	public function sendCertificateMail(HttpRequest $request) {
		
		$pay_id		=	$request->segment(3);
		
		$paypal		=	PaypalLog::where('id', $pay_id)->where('pl_status', '1')->first();
		
		// Unserialize the details
		if(count($paypal) > 0) {
			
			$data		=	unserialize($paypal['pl_details']);
		}
		
		// Business the details
		if(count($data) > 0) 
		{
			$business	=	DB::table('business')
							->select('business.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname')
							->leftjoin('cities', 'business.city_id', '=', 'cities.id')
							->where('business.id', $data['biz_id'])
							->first();
		}
		
		// get location details from session if exist
		$biz_loc = '';
		$loc_biz = '';
		$biz_ttl = '';
		if($this->lang->get('abbr') == 'ar') {
			
			$loc_biz = $business->ciname;
			$biz_ttl = $business->title_ar;
		}
		else {
			
			$loc_biz = $business->ciasciiname;
			$biz_ttl = $business->title;
		}
		if(Session::has('bizLocationNow')) {
			
			$biz_loc = Session::get('bizLocationNow');
			$locaton = unserialize($biz_loc);
			if($this->lang->get('abbr') == 'ar') {
			
				$loc_biz = $locaton->ciname;
			}
			else {
				
				$loc_biz = $locaton->ciasciiname;
			}
		}
		
		// Store New Gift Certificate
        if(count($data) > 0) {
			
			$newCertificate 				= new GiftCertificate();
			$newCertificate->biz_id			= $data['biz_id'];
			$newCertificate->biz_loc		= $biz_loc;
			$newCertificate->pay_id			= $pay_id;
			$newCertificate->user_id		= $data['sender_id'];
			$newCertificate->total_quantity	= $data['gift_quantity'];
			$newCertificate->each_price		= $data['gift_amount'];
			$newCertificate->total_price	= $data['gift_quantity'] * $data['gift_amount'];
			$newCertificate->active			= 1;
			$newCertificate->save();
		}
		
		// Store New Gift Recipient
        if(count($data) > 0) {
			
			$total	=	$data['gift_quantity'];
			
			if(!empty($total)) {
				
				for($i=0;$i<=$total-1;$i++) {
					
					$newRecipient  						= new GiftRecipient();
					$newRecipient->biz_id 				= $data['biz_id'];
					$newRecipient->pay_id				= $pay_id;
					$newRecipient->gift_id 				= $newCertificate->id;
					$newRecipient->gift_code			= getRandWord(8);
					$newRecipient->recipient_name		= $data['recipient_name'][$i];
					$newRecipient->recipient_email		= $data['recipient_email'][$i];
					$newRecipient->recipient_message	= $data['recipient_message'][$i];
					$newRecipient->sender_name			= $data['sender_name'][$i];
					$newRecipient->sender_id			= $data['sender_id'];
					$newRecipient->active				= 1;
					$newRecipient->save();
					
					Mail::send('emails.certificate.sendCertificates', ['title' => $biz_ttl,'location' => $loc_biz,'biz' => $newRecipient->biz_id,'sender' => $newRecipient->sender_name,'recipient' => $newRecipient->recipient_name,'code' => $newRecipient->gift_code], function($message) use ($business,$newRecipient,$loc_biz,$biz_ttl) {
				
						$message->to($newRecipient->recipient_email);
						$message->subject('Howlik Gift Certificate');		
					});
					
				}
			}
		}
	}
	
	public function viewCertificate(HttpRequest $request) 
	{
		
		$data	=	[];
		
		$biz_id 	=	Request::segment(5);
		
		$business	= DB::table('business')
						->select('business.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname')
						->leftjoin('cities', 'business.city_id', '=', 'cities.id')
						->where('business.country_code', $this->country->get('code'))
						->where('business.id', $biz_id)
						->first();
		
		
		$countries	 =	$this->country->get('currency');
		if($countries != '') {
			
			$business->currency = $countries->html_entity;
		}
		
		if (!(is_numeric($biz_id) && isset($business->id))) {
			abort(404);
		}
		View::share('business', $business);
		
		$certificates	=	GiftCertificate::where('biz_id', $biz_id)
							->where('active', '1')
							->orderBy('created_at', 'desc')
							->paginate(12);
		
		//echo "<pre>";print_r($certificates);die;
		
		if(count($certificates) > 0) {
			
			$data['certificate']	=	$certificates;
		}
		
		if ($request->ajax()) {
			
           return view('classified.business.details.inc.view-certificates-ajax', $data);
        }
		return view('classified.business.details.view-certificates',$data);
	}
	
	public function findBusiness(HttpRequest $request)
	{
		$data = array();
		
		 // Get cat id
        $cat = Category::where('translation_lang', $this->lang->get('abbr'))->first();
        
        $cat_id = ($cat) ? $cat->tid : 0;
        if (!isset($cat_id) or $cat_id <= 0 or !is_numeric($cat_id)) {
            abort(404);
        }
		
		$search = new Search($request, $this->country, $this->lang);
        $data = $search->setCategory($cat_id)->setRequestFilters()->getCityRegion()->getImage()->fetch();
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
        return view('classified.business.find.index', $data);
	}
	
	public function getBusinessLocation(HttpRequest $request) {
		
		$data 		= 	array();
		$id 		=	Request::segment('5');
		
		$business	=	Business::where('id', $id)->first();
		if(is_null($business)) {
            abort(404);
		}
						
		$location	=	DB::table('businessLocations')
						->select('businessLocations.*', 'businessLocations.zip_code as zip', 'cities.name as ciname', 'cities.asciiname as ciasciiname', 'subadmin1.name as loname', 'subadmin1.asciiname as loasciiname', 'countries.name as coname', 'countries.asciiname as coasciiname')
						->leftjoin('cities', 'businessLocations.city_id', '=', 'cities.id')
						->leftjoin('subadmin1', 'businessLocations.location_id', '=', 'subadmin1.code')
						->leftjoin('countries', 'businessLocations.country_id', '=', 'countries.code')
						->where('businessLocations.biz_id', $id)
						->orderBy('created_at', 'asc')
						->paginate(4);
		
		$data['business']	=	$business;
		$data['location']	=	$location;
		
		if ($request->ajax()) {
            return view('classified.business.locations.loadajax', $data);  
        }
		return view('classified.business.locations.index', $data);
	}
	
	public function createBusinessLocation(HttpRequest $request) {
		
		$data 		= 	array();
		$id 		=	Request::segment('6');
		$business	=	Business::where('id', $id)->first();
		if(is_null($business)) {
            abort(404);
        }
		$data['business']	=	$business;
		$data['countries']	=	Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'))->lists('name', 'code');
		
		return view('classified.business.locations.create', $data);
	}
	
	public function createBusinessLocationPost(HttpRequest $request) {
		
		//echo "<pre>";print_r($_POST);die;
		
		$data	= array();
		$input 	= Input::all();
		
		$rules	= array(
		    'address1' => 'required',
		    'phone' => 'required',
		    'country' => 'required',
		    'city' => 'required',
		);
		$message = array(
		    'address1.required' => 'The Address 1 field id required.',
		    'phone' => 'The Phone Number field id required.',
		    'country' => 'The Country field id required.',
		    'city' => 'The City field id required.',
		);
		$validation = Validator::make($input, $rules, $message);
		if ($validation->fails())
		{
			return back()->withErrors($validation)->withInput($request->all());
		}
		$locations 		= City::select('subadmin1_code')->where('id', $request->input('city'))->first();
		
		$business_location = array(
		
            'biz_id' => $request->input('biz_id'),
            'address_1' => $request->input('address1'),
            'address_2' => $request->input('address2'),
            'phone' => $request->input('phone'),
			'country_id' => $request->input('country'),
			'location_id' => $request->input('country').'.'.$locations->subadmin1_code,
            'city_id' => $request->input('city'),
            'zip_code' => $request->input('zip'),
            'lat' => $request->input('lat1'),
            'lon' => $request->input('lon1'),
            'active' => 1,
            'base' => 0,
        );
		
		// Save Business to database
        $locationTbl = new BusinessLocation($business_location);
        $locationTbl->save();
		
		flash()->success(t('Your Business Location Created Successfully.'));
		return redirect('/account/business/location/create/'.$request->input('biz_id'))->with(['success' => 1]);
	}
	
	public function updateBusinessLocation(HttpRequest $request) {
		
		$data 		= 	array();
		$id 		=	Request::segment('6');
		$location	=	DB::table('businessLocations')
						->select('businessLocations.*', 'businessLocations.zip_code as zip', 'business.title', 'business.title_ar')
						->leftjoin('business', 'businessLocations.biz_id', '=', 'business.id')
						->where('businessLocations.id', $id)
						->first();
						
		if(empty($location)) {
            abort(404);
        }
		
		$data['locations']	=	$location;
		$data['countries']	=	Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'))->lists('name', 'code');
		
		return view('classified.business.locations.update', $data);
	}
	
	public function updateBusinessLocationPost(HttpRequest $request) {
		
		$data	= array();
		$input 	= Input::all();
		
		$rules	= array(
		    'address1' => 'required',
		    'phone' => 'required',
		    'country' => 'required',
		    'city' => 'required',
		);
		$message = array(
		    'address1.required' => 'The Address 1 field id required.',
		    'phone' => 'The Phone Number field id required.',
		    'country' => 'The Country field id required.',
		    'city' => 'The City field id required.',
		);
		$validation = Validator::make($input, $rules, $message);
		if ($validation->fails())
		{
			return back()->withErrors($validation)->withInput($request->all());
		}
		$locations	= BusinessLocation::where('id', $request->input('id'))->first();
		
		if(empty($locations)) {
            abort(404);
        }
		$business	= Business::where('id', $locations->biz_id)->first();
		$location	= City::select('subadmin1_code')->where('id', $request->input('city'))->first();
		
		if($locations->base == 1) {
			
			// update the values in business table
			$businessTbl = array(
			
				'address1' => $request->input('address1'),
				'address2' => $request->input('address2'),
				'phone' => $request->input('phone'),
				'country_code' => $request->input('country'),
				'subadmin1_code' => $request->input('country').'.'.$location->subadmin1_code,
				'city_id' => $request->input('city'),
				'zip' => $request->input('zip'),
				'lat' => $request->input('lat1'),
				'lon' => $request->input('lon1'),
			);
			$business->update($businessTbl);
		}
		
		// update the values in business locations table
		$businessLocationTbl = array(
		
            'address_1' => $request->input('address1'),
            'address_2' => $request->input('address2'),
            'phone' => $request->input('phone'),
			'country_id' => $request->input('country'),
			'location_id' => $request->input('country').'.'.$location->subadmin1_code,
            'city_id' => $request->input('city'),
            'zip' => $request->input('zip'),
            'lat' => $request->input('lat1'),
            'lon' => $request->input('lon1'),
        );
        $locations->update($businessLocationTbl);
		
		flash()->success(t('Your Business Location Updated Successfully.'));
		return redirect('/account/business/location/update/'.$request->input('id'))->with(['success' => 1]);
	}
	
	public function deleteBusinessLocation(HttpRequest $request) {
		
		$business	= DB::table('businessLocations')->where('id', Request::get('id'))->delete();
		
		if($business) {
			return response()->json('success', 200);
        } 
		else {
			return response()->json('error', 400);
        }
	}
	
	public function imgaction(HttpRequest $request)
	{
		echo "dsdss";exit;
		/*$id = 0; $status = 0; 
		if($request->has('id')){
			$id = $request->get('id');
		}
		if($request->has('status')){
			$status = $request->get('status');
		}
		
        $entries = businessImageRequest::where('id', $id)->first();
		if(!empty($entries)){
			if($status==1){
				$businessImage = new businessImage();
				$businessImage->biz_id 	  	= $entries->biz_id;
				$businessImage->filename  	= $entries->filename;
				$businessImage->posted_by 	= $entries->posted_by;
				$businessImage->active 	  	= $entries->active;
				$businessImage->created_at 	= $entries->created_at;
				$businessImage->save();
			}
			$entries->delete();
		}
		echo json_encode (array( 'res' => $entries ));*/
	}
	
	/* public function transferBus(HttpRequest $request) {
		
		$business = DB::table('business')->orderBy('id', 'asc')->get();
		
		if(!empty($business)) {
			
			foreach($business as $biz) {
				
				$business_location = array(
				
					'biz_id' => $biz->id,
					'address_1' => $biz->address1,
					'address_2' => $biz->address2,
					'phone' => $biz->phone,
					'country_id' => $biz->country_code,
					'location_id' => $biz->subadmin1_code,
					'city_id' => $biz->city_id,
					'zip_code' => $biz->zip,
					'lat' => $biz->lat,
					'lon' => $biz->lon,
					'active' => 1,
				);
				
				$locationTbl = new BusinessLocation($business_location);
				$locationTbl->save();
			}
		}
	} */
}
