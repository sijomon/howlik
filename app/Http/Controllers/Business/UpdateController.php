<?php
namespace App\Http\Controllers\Business;

use App\Larapen\Helpers\Ip;
use App\Larapen\Helpers\Rules;

use App\Larapen\Models\Business;
use App\Larapen\Models\Category;
use App\Larapen\Models\City;
use App\Larapen\Models\BusinessImage;
use App\Larapen\Models\BusinessImageRequest;
use App\Larapen\Models\User;
use App\Larapen\Models\BusinessInfo;
use App\Larapen\Models\BusinessBooking;
use App\Larapen\Models\BusinessBookingTmSettings;
use App\Larapen\Models\BusinessBookingTblSettings;
use App\Larapen\Models\BusinessBookingOrder;
use App\Larapen\Models\BusinessTableBooking;
use App\Larapen\Models\BusinessLocation;
use App\Larapen\Models\Language;
use App\Larapen\Models\BusinessOffer;
use App\Larapen\Models\OfferType;
use App\Larapen\Models\GiftPrice;

use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;

use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request as Request;
use App\Http\Controllers\FrontController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Intervention\Image\Facades\Image;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;

use Input;
use Session;
use Carbon\Carbon;

class UpdateController extends FrontController
{
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        
        /*
         * References
         */
        $this->countries = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
        view()->share('countries', $this->countries);
    }
    
    /**
     * Show the form the create a new business listing post.
     *
     * @return Response
     */
    public function getForm()
    {
        $data = array();
        
        $biz_id = Request::segment(4);
        if (!is_numeric($biz_id)) {
            abort(404);
        }
        
		
		
        // Get Business
        // GET Business INFO
        $business = Business::withoutGlobalScopes([ActiveScope::class])->where('user_id', $this->user->id)->where('id', $biz_id)->with([
            'user',
            'country',
            'category',
            'city',
			'location',
            'businessimages'
        ])->first();
		
        //echo "<pre>";print_r($business);die;
		
        if (is_null($business)) {
			
            abort(404);
        }
		
        $countries	 =	$this->country->get('currency');
		if($countries != '') {
			$business->currency = $countries->code;
		}
        View::share('business', $business);
        
		$keyA = explode(',', $business->keywords);
		$data['keywords'] = Category::whereIn('id', $keyA)->where('active', 1)->get()->all();
        
        /*
         * References
         */
        $data['categories'] = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->with([
            'children' => function ($query) {
                $query->where('translation_lang', $this->lang->get('abbr'));
            }
        ])->orderBy('lft')->get();
        
        $data['states'] = City::where('country_code', $this->country->get('code'))->where('feature_code', 'ADM1')->get()->all();
        
        //$data['busInfo'] 	= BusinessInfo::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->get();
        
        $busInfoS 			= BusinessInfo::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->get();
        
		$infovalues 		= unserialize( $business->more_info );
		
		$data['busInfo'] 	= $busInfoS;
		
		$busInfoA = [];
		
		foreach($busInfoS as $key=>$val) {
			
			if(isset($infovalues[$val['translation_of']]) && trim($infovalues[$val['translation_of']]) != '') {
			
				$infoValsA = unserialize($val->info_vals);
				
				if(isset($infoValsA[$infovalues[$val['translation_of']]]) && $val['info_type'] != '1'){
					$tval = $infoValsA[$infovalues[$val['translation_of']]];
				}else{
					$tval = trim($infovalues[$val['translation_of']]);
				}
				$busInfoA[] = array('label'=>$val['info_title'], 'value'=>$tval);
			}
		}
		View::share('busInfoA', $busInfoA);
		
		$offersS			=	BusinessOffer::withoutGlobalScopes([ActiveScope::class])->where('biz_id', $biz_id)->get();
		$data['offers']		=	$offersS;
		$data['offertype'] 	= 	OfferType::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->lists('title','translation_of');
		
		$bookings			=	BusinessBooking::where('translation_lang', $this->lang->get('abbr'))->where('active', 1)->get();
		$data['bookings']	=	$bookings;
		
		$data['bookTmSettings']		=	BusinessBookingTmSettings::where('biz_id', $biz_id)->orderBy('tm_from')->get();
		$data['bookTblSettings']	=	BusinessBookingTblSettings::where('biz_id', $biz_id)->orderBy('tbl_from')->get();
		
		$giftPrice =	GiftPrice::where('country', $this->country->get('code'))->where('active', 1)->lists('price','id');
		if(!(sizeof($giftPrice)>0)){
			$giftPrice =	GiftPrice::where('country', 'DEFLT')->where('active', 1)->lists('price','id');
		}
		$data['giftPrice']	= $giftPrice;
		
        // Meta Tags
        MetaTag::set('title', t('Update My Business Listing'));
        MetaTag::set('description', t('Update My Business Listing'));
        
        return view('classified.business.update.index', $data);
    }
    
	
	/**
     * Show the form the create a new business listing post.
     *
     * @return Response
     */
    public function getInfoForm()
    {
        $data = array();
        
        $biz_id = Request::segment(4);
        if (!is_numeric($biz_id)) {
            abort(404);
        }
        
        // Get Business
        // GET Business INFO
        $business = Business::withoutGlobalScopes([ActiveScope::class])
							->where('user_id', $this->user->id)->where('id', $biz_id)->with([
									'user',
									'country',
									'category',
									'city',
									'location',
									'businessimages'
								])->first();
        
        if (is_null($business)) {
            abort(404);
        }
        View::share('business', $business);
        
		$keyA = explode(',', $business->keywords);
		$data['keywords'] = Category::whereIn('id', $keyA)->where('active', 1)->get()->all();
        
        /*
         * References
         */
        $data['categories'] = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->with([
            'children' => function ($query) {
                $query->where('translation_lang', $this->lang->get('abbr'));
            }
        ])->orderBy('lft')->get();
        $data['states'] = City::where('country_code', $this->country->get('code'))->where('feature_code', 'ADM1')->get()->all();
        
        // Debug
        //echo '<pre>'; print_r($data['categories']->toArray()); echo '</pre><hr>'; exit();
        
        // Meta Tags
        MetaTag::set('title', t('Update My Business Listing'));
        MetaTag::set('description', t('Update My Business Listing'));
        
        return view('classified.business.update.updateinfo', $data);
    }
	
    /**
     * Store a new business listing post.
     *
     * @param  Request $request
     * @return Response
     */
    public function postForm(HttpRequest $request)
    {	
		if (Auth::check()) {
            $user = $this->user;
        } 
	
		$biz_id = $request->input('biz_id');
		$business = Business::withoutGlobalScopes([ActiveScope::class])->where('user_id', $this->user->id)->where('id', $biz_id)->first();
		
        if (!(count($business)>0)) {
            abort(404);
        }
		// Form validation
        $validator = Validator::make($request->all(), Rules::Business($request, 'POST'));
        if ($validator->fails()) {
            // BugFix with : $request->except('pictures')
            return back()->withErrors($validator)->withInput($request->except('pictures'));
        }
        
        // Get city infos
        if ($request->has('city')) {
            $city = City::find($request->input('city'));
            if (is_null($city)) {
                flash()->error(t("Post Business listings has currently deactivate. Please try later. Thank you."));
                
                return back();
            }
        }
		
		$subadmin1_code = '';
		if ($request->has('location')) {
            //$tmp = explode('.', $request->input('location'));
			//$subadmin1_code = end($tmp);
			$subadmin1_code = $request->input('location');
        }
        
        // Business listing data
        $business_info = array(
            'category_id' => $request->input('category_id'),
            'keywords' => implode(',',$request->input('keywords')),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'biz_hours' => serialize($request->input('biz_hours')),
            'phone' => $request->input('phone'),
            'web' => $request->input('web'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'zip' => $request->input('zip'),
            'city_id' => $request->input('city'),
            'subadmin1_code' => $subadmin1_code,
            'lat' => $request->input('lat1'),
            'lon' => $request->input('lon1'),
        );
        
        // Save Business to database
        $business->update($business_info);
		
		$locationTbl = BusinessLocation::where('biz_id', $biz_id)->first();
		if(!empty($locationTbl)) {
			
			// Save a reference of this Business to database table businessLocations
			$business_location = array(
			
				'address_1' => $request->input('address1'),
				'address_2' => $request->input('address2'),
				'phone' => $request->input('phone'),
				'location_id' => $subadmin1_code,
				'city_id' => $request->input('city'),
				'zip_code' => $request->input('zip'),
				'lat' => $request->input('lat1'),
				'lon' => $request->input('lon1'),
				'active' => 1,
			);
			$locationTbl->update($business_location);
		}
        
        // Init. result
        return redirect($this->lang->get('abbr') . '/account/bizinfo/'.$biz_id);
	}
    
    public function success()
    {
        if (!session('success')) {
            return redirect($this->lang->get('abbr') . '/account/mybusinesslistings');
        }
        
        return view('classified.business.update.success');
    }
	
	public function postInfoForm(HttpRequest $request)
    {	
		if (Auth::check()) {
            $user = $this->user;
        } 
		
		$bizInfoA = array();
		if ($request->has('biz_info')) {
			$biz_info = $request->input('biz_info');
			foreach($biz_info as $key => $value){
				$busInfo = BusinessInfo::where('translation_of', $key)->get();
				foreach($busInfo as $key1 => $value1){
					if($value1->info_type==1){
						$bizInfoA[$value1->translation_lang][$key] = array('label'=>$value1->info_title, 'value'=>$value);
					}else{
						$infoValsA = unserialize($value1->info_vals);
						$bizInfoA[$value1->translation_lang][$key] = array('label'=>$value1->info_title, 'value'=>$infoValsA[$value]);
					}
				}
			}
		}
	
		$biz_id = $request->input('business');
		$business = Business::withoutGlobalScopes([ActiveScope::class])->where('user_id', $this->user->id)->where('id', $biz_id)->first();
		
        if (!(count($business)>0)) {
            abort(404);
        }
		$business->more_info = serialize($bizInfoA);
		$business->save();
        
        // Init. result
        return redirect($this->lang->get('abbr') . '/account/bizinfo/'.$biz_id);
	}
	
	/**
     * Show the form to upload new business images
     *
     * @return Response
     */
    public function upImages()
    {
        $data = array();
        
        $biz_id = Request::segment(4);
        if (!is_numeric($biz_id)) {
            abort(404);
        }
        
        // Get Business
        // GET Business INFO
        $business = Business::withoutGlobalScopes([ActiveScope::class])->where('user_id', $this->user->id)->where('id', $biz_id)->with([
            'user',
            'country',
            'category',
            'city',
			'location',
            'businessimages'
        ])->first();
        
        if (is_null($business)) {
            abort(404);
        }
        View::share('business', $business);
        
		$keyA = explode(',', $business->keywords);
		$data['keywords'] = Category::whereIn('id', $keyA)->where('active', 1)->get()->all();
        
        /*
         * References
         */
        $data['categories'] = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->with([
            'children' => function ($query) {
                $query->where('translation_lang', $this->lang->get('abbr'));
            }
        ])->orderBy('lft')->get();
        $data['states'] = City::where('country_code', $this->country->get('code'))->where('feature_code', 'ADM1')->get()->all();
        
        // Debug
        //echo '<pre>'; print_r($data['categories']->toArray()); echo '</pre><hr>'; exit();
        
        // Meta Tags
        MetaTag::set('title', t('Update My Business Images'));
        MetaTag::set('description', t('Update My Business Images'));
        $data['hdr_dropzone'] = 1;
        return view('classified.business.imageupload', $data);
    }
	
	public function postImages(HttpRequest $request){
		
		$input = Input::all();
		$biz_id = $request->input('biz_id');
		
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
			return Response::make($validation->errors->first(), 400);
		}
		$file = Input::file('file');
				
		$destinationPath = 'uploads/pictures/business'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = time() . '.' . $extension; // renameing image
        $upload_success = Input::file('file')->move( public_path().'/'.$destinationPath, $fileName); // uploading file to given path
		
        if( $upload_success ) {
			$picture = new BusinessImage;
			$picture->biz_id	= $biz_id;
			$picture->filename	= $destinationPath.'/'.$fileName;
			$picture->active	= 1;
			$picture->save();
			
			echo $fileName;
        	return Response::json( $fileName, 200);
        } else {
			echo 'fail';
        	return Response::json('error', 400);
        }
	}
	
	public function delImages(HttpRequest $request){
		$biz_id = $request->input('biz_id');
		$fileName = $request->input('fileName');
		
		$destinationPath = 'uploads/pictures/business/'; // upload path
		if(is_file( public_path().'/'.$destinationPath.$fileName)){
			unlink($destinationPath.$fileName);
		}
		
		$picture = BusinessImage::where('filename', $destinationPath.$fileName)->get()->first();
		
		if (!is_null($picture)) {
			// Delete old file
			$picture->delete($picture->id);
		}
	}
	
	public function postRequestImages(HttpRequest $request){
		
		$input = Input::all();
		
		$biz_id = $request->input('biz_id');
		$usr_id = $request->input('usr_id');
		
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
			return Response::make($validation->errors->first(), 400);
		}
		$file = Input::file('file');
				
		$destinationPath = 'uploads/pictures/business'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName  = time() . '.' . $extension; // renameing image
        $upload_success = Input::file('file')->move( public_path().'/'.$destinationPath, $fileName); // uploading file to given path
		
        if( $upload_success ) {
			
			$business	= Business::where('id', $biz_id)->where('user_id', $usr_id)->get()->first();
			if (!is_null($business)) {
				$picture = new BusinessImage;
				$picture->biz_id	= $biz_id;
				$picture->filename	= $destinationPath.'/'.$fileName;
				$picture->active	= 1;
				$picture->save();
				
			} else {
				$picture = new BusinessImageRequest;
				$picture->biz_id	= $biz_id;
				$picture->filename	= $destinationPath.'/'.$fileName;
				$picture->posted_by	= $usr_id;
				$picture->active	= 1;
				$picture->save();
			}
			echo $fileName;
			return Response::json( $fileName, 200);
				
        } else {
			echo 'fail';
        	return Response::json('error', 400);
        }
	}
	
	public function delRequestImages(HttpRequest $request){
		
		$biz_id = $request->input('biz_id');
		$usr_id = $request->input('usr_id');
		$fileName = $request->input('fileName');
		
		$destinationPath = 'uploads/pictures/business/'; // upload path
		if(is_file( public_path().'/'.$destinationPath.$fileName)){
			unlink($destinationPath.$fileName);
		}
		
		$business	= Business::where('id', $biz_id)->where('user_id', $usr_id)->get()->first();
		if (!is_null($business)) {
			$picture	= BusinessImage::where('filename', $destinationPath.$fileName)->get()->first();
		} else {
			$picture	= BusinessImageRequest::where('filename', $destinationPath.$fileName)->get()->first();
		}
		
		if (!is_null($picture)) {
			// Delete old file
			$picture->delete($picture->id);
		}
	}
	
	/**
     * Edit an existing business additional information.
     *
     * @param  Request $request
     * @return Response
     */
     
	public function getAdditionalForm(HttpRequest $request) {
		
		$data	= array();
        
        $biz_id	= Request::segment(4);
        
        if (!is_numeric($biz_id)) {
			
            abort(404);
        }
        
        // GET Business INFO
        $business	=	Business::withoutGlobalScopes([ActiveScope::class]) 
						->where('user_id', $this->user->id)
						->where('id', $biz_id)
						->with([
							'user',
							'country',
							'category',
							'city',
							'location',
							'businessimages'
							])
						->first();
        
        if (is_null($business)) {
			
            abort(404);
        }
        
        View::share('business', $business);
        
        /*
         * References
         */
        
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
        
        //echo "<pre>";print_r($busInfoA);die;
        
		// Meta Tags
        MetaTag::set('title', t('Update My Business Additional Informations'));
        MetaTag::set('description', t('Update My Business Additional Informations'));
        
        return view('classified.business.update.updatedetailinfo', $data);
	}
	
	public function postAdditionalForm(HttpRequest $request) {
		
		//echo '<pre>';print_r($_POST);die;
		//echo serialize($request->input('biz_info'));die;
		
		if (Auth::check()) {
            $user = $this->user;
        }
        
		$biz_id 	= $request->input('biz_id');
		 
        $business 	= Business::withoutGlobalScopes([ActiveScope::class])->where('user_id', $this->user->id)->where('id', $biz_id)->first();
		
        if (!(count($business)>0)) {
			
            abort(404);
        }
        
        // Business listing data
        $business_info = array(
        
            'more_info' => serialize($request->input('biz_info')),
        );
        
        // Save Business to database
        $business->update($business_info);
		
		return redirect($this->lang->get('abbr') . '/account/bizinfo/'.$biz_id);
	}
	
	/**
     * Add a new business offer information.
     *
     * @param  Request $request
     * @return Response
     */
     
	public function addOfferInfo(HttpRequest $request) {
		
		$data	= array();
        
        $data['offertype'] 	= OfferType::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->lists('title','translation_of');
        
        $biz_id	= Request::segment(4);
        
        if (!is_numeric($biz_id)) {
			
            abort(404);
        }
        
        View::share('biz_id', $biz_id);
        
        $offertypes 	= OfferType::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->get();
        
        $countries	 =	$this->country->get('currency');
		if($countries != '') {
			
			$offertypes->currency = $countries->html_entity;
		}
		
        View::share('offertypes', $offertypes);
         
		// Meta Tags
        MetaTag::set('title', t('Create My Business Offer Informations'));
        MetaTag::set('description', t('Create My Business Offer Informations'));
        
        return view('classified.business.update.addofferinfo', $data);
	}
	
	/**
     * Edit an existing business offer information.
     *
     * @param  Request $request
     * @return Response
     */
     
	public function editOfferInfo(HttpRequest $request) {
		
		$data	= array();
        
        $data['offertype'] 	= OfferType::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->lists('title','translation_of');
        
        $off_id	= Request::segment(4);
        
        if (!is_numeric($off_id)) {
			
            abort(404);
        }
        View::share('off_id', $off_id);
        
        // GET OFFER INFO
        $offers	=	BusinessOffer::withoutGlobalScopes([ActiveScope::class])->where('id', $off_id)->first();
        
        $countries	 =	$this->country->get('currency');
		if($countries != '') {
			
			$offers->currency = $countries->html_entity;
		}
        View::share('offers', $offers);
        
		// Meta Tags
        MetaTag::set('title', t('Update My Business Offer Informations'));
        MetaTag::set('description', t('Update My Business Offer Informations'));
        
        return view('classified.business.update.updateofferinfo', $data);
	}
	
	public function postOfferInfo(HttpRequest $request) {
		
		if (Auth::check()) {
			
            $user = $this->user;
        }
        
		$off_id 	=	$request->input('off_id');
		$biz_id 	=	$request->input('biz_id');
		
		//Delete the offer if exist
		if($off_id != '')
		{
			$offers		=	BusinessOffer::withoutGlobalScopes([ActiveScope::class])->where('id', $off_id)->first(); 
		}
		
		$rules 	= [
		
			'biz_id'			=>	'required',
			'offer_type'		=>	'required|numeric',
			'offer_percent'		=>	'required|numeric|min:1',
			'offer_content'		=>	'required',
		];
		
		$messages = [
		
			'biz_id.required' => 'The Business is required.',
			'offer_type.required' => 'The Offer Type is required.',
			'offer_type.numeric' => 'The Offer Type is not found.',
			'offer_percent.required' => 'The Offer Percentage is required.',
			'offer_percent.numeric' => 'The Offer Percentage must be a number.',
			'offer_percent.min' => 'The Offer Percentage must be at least 1.',
			'offer_content.required' => 'The Offer Content is required.',
		];
		
		// Form validation
        $validator	=	Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

			return back()->withErrors($validator)->withInput();
		}
        
		// Save New Business Offer Details to database
		if($biz_id != '' && $off_id == '')
		{
			$offersNew				=	new BusinessOffer();
			$offersNew->biz_id		=	$request->input('biz_id');
			$offersNew->offertype 	= 	$request->input('offer_type');
			$offersNew->percent 	= 	$request->input('offer_percent');
			$offersNew->content 	= 	$request->input('offer_content');
			$offersNew->details 	= 	$request->input('offer_details');
			$offersNew->active 		= 	1;
			$offersNew->save();
		}
		// Update an Existing Business Offer Details in database
		else if($biz_id != '' && $off_id != '')
		{
			// Business listing data
			$offers_info = array(
			
				'offertype' => $request->input('offer_type'),
				'percent' 	=> $request->input('offer_percent'),
				'content' 	=> $request->input('offer_content'),
				'details' 	=> $request->input('offer_details'),
			);
			
			// Save Business to database
			$offers->update($offers_info);
		}
		
		return redirect($this->lang->get('abbr') . '/account/bizinfo/'.$biz_id);
	}
	
	public function deleteOffer(HttpRequest $request) {
		
		if (Auth::check()) {
			
            $user = $this->user;
        }
        
        $biz_id = Request::segment(3);
        $off_id = Request::segment(5);
        
        if (!is_numeric($off_id)) {
            abort(404);
        }
		
		$offers		=	BusinessOffer::withoutGlobalScopes([ActiveScope::class])->where('id', $off_id)->delete(); 
	
		return redirect($this->lang->get('abbr') . '/account/bizinfo/'.$biz_id);
	}
	
	function find_table(HttpRequest $request) {
		$sr_date = $request->input('sr_date');
		$sr_time = $request->input('sr_time');
		$sr_people = $request->input('sr_people');
		$biz_id = $request->input('biz_id');
		$request->session()->put('sr_date', $sr_date);
		$request->session()->put('sr_time', $sr_time);
		$request->session()->put('sr_people', $sr_people);
		
		$available = 0;
		$bbts = BusinessBookingTblSettings::select('id', 'tbl_table')->where('biz_id', $biz_id)->where('tbl_from', '<=', $sr_time)->where('tbl_to', '>=', $sr_time)->where('seat_min', '<=', $sr_people)->where('seat_max', '>=', $sr_people)->first();
		if(isset($bbts->id) && $bbts->id>0){
			$reply['setId'] = $bbts->id;
			$dt_from = $sr_date.' 00:00:00';
			$dt_to = $sr_date.' 23:59:59';
			$bookingCount = BusinessBookingOrder::where('settings_id', $bbts->id)->where('biz_id', $biz_id)->whereBetween('book_date', [$dt_from, $dt_to])->count();
			if($bookingCount<$bbts->tbl_table){
				$available = 1;
			}
		}
		$reply['status'] = $available;
		return json_encode($reply);
	}
	
	function book_timeslot(HttpRequest $request) {
		$tsbid = $request->input('tsbid');
		$tb_name = $request->input('tb_name');
		$tb_email = $request->input('tb_email');
		$tb_mobile = $request->input('tb_mobile');
		$tb_message = $request->input('tb_message');
		
		$cur = $this->country->get('currency');
		$curA = json_decode($cur); 
		$bbtsSettings = BusinessBookingTmSettings::where('id', $tsbid)->first();
		$extraInfoA['time'] = $bbtsSettings->tm_from.'-'.$bbtsSettings->tm_to;
		$extraInfoA['price'] = $bbtsSettings->price;
		$extraInfoA['cur'] = array('code'=>$curA->code, 'html'=>$curA->html_entity, 'symbol'=>$curA->symbol);
		$biz_id = $bbtsSettings->biz_id;
		
		// get location details from session if exist
		$biz_loc = '';
		if(Session::has('bizLocationNow')) {
			
			$biz_loc = Session::get('bizLocationNow');
		}
		
		$today_dt = Carbon::now($this->country->get('timezone')->time_zone_id);
		$bookOrder = new BusinessBookingOrder();
		$bookOrder->settings_id = $tsbid;
		$bookOrder->biz_id = $biz_id;
		$bookOrder->biz_loc = $biz_loc;
		$bookOrder->user_id = $this->user->id;
		$bookOrder->extraInfo = serialize($extraInfoA);
		$bookOrder->name = $tb_name;
		$bookOrder->email = $tb_email;
		$bookOrder->mobile = $tb_mobile;
		$bookOrder->notes = $tb_message;
		$bookOrder->book_date = $today_dt;
		$bookOrder->created_at = $today_dt;
		$bookOrder->save();
		
		/* BOF Get Time Slot select option */
		$today_dt = Carbon::today($this->country->get('timezone')->time_zone_id);
		$tomorrow_dt = Carbon::tomorrow($this->country->get('timezone')->time_zone_id);
		$bbHtml = '';
		$bbtminfos = DB::select( DB::raw("SELECT bbs.*,
		(SELECT COUNT(id) as booking FROM BusinessBookingOrder btb WHERE btb.settings_id=bbs.id AND book_date BETWEEN '$today_dt' AND '$tomorrow_dt') as booking
		FROM businessBookingTmSettings bbs WHERE bbs.biz_id = '$biz_id' ORDER BY bbs.tm_from") );
		if(count($bbtminfos)>0){
			foreach($bbtminfos as $key => $value){
				$timeNow = date('H.i', time());
				$status = 0;
				$clsBg = '';
				$price = $value->price;
				if($value->tm_from<=$timeNow){
					$status = 1;
					$clsBg = 'graybg';
					$price = t('Passed');
				}elseif($value->booking>=$value->slots){
					$status = 2;
					$clsBg = 'redbg';
				}
				$bbHtml .= '<div class="time-slot-row '.$clsBg.'">';
				$bbHtml .= '<div class="box-01"> <p>'.date("h:i A", strtotime($value->tm_from)).'</p> </div>';
				$bbHtml .= '<div class="box-02"> <p>'.date("h:i A", strtotime($value->tm_to)).'</p> </div>';
				$bbHtml .= '<div class="box-03">';
				$bbHtml .= '<p>'.$price;
				if($status == 0){
					$bbHtml .= '<a href="#" onclick="return bookTimeSlotNext('.$value->id.');"><span class="fa fa-plus-square span-action"></span></a>';
				}else{
					$bbHtml .= '<span class="fa fa-plus-square span-action"></span>';
				}
				$bbHtml .= '</p>';
				$bbHtml .= '</div>';
				$bbHtml .= '</div>';
			}
		}
		$reply['tmhtml'] = $bbHtml;
		/* EOF Get Time Slot select option */
		
		$reply['html'] = '<p>'.t('Your reservation has been sent for Approval, Please click')." <a href='".lurl('/account/mybusinessorders')."'> ".t('here')." </a> ".t('to know status.').'</p>';
		$reply['html'] .= '<p><button class="comment btn" onclick="closeInfoMsg();">'.t('Go Back').'</button></p>';
		
		/* BOF Notification email to business owner */
		$business = Business::where('id', $biz_id)->first();
		$biz_owner = User::select('name', 'email')->where('id', $business->user_id)->first();
		$subject = trans('mail.Howlik: New business reservation').' '.date('m/d/Y h:i A', time());
		$pass['subject'] = $subject;
		$pass['email'] = $biz_owner->email;
		$pass['name'] = $biz_owner->name;
		$link    =   "/".str_replace(' ', '-', $business->title)."/".$business->id.".html";
		
		$template['biz_owner'] = $biz_owner->name;
		$template['biz_link'] = "<a href='".lurl($link)."' target='_blank'>".$business->title."</a>";
		$template['your_orders'] = "<a href='".lurl('account/businessbooking/'.$business->id)."' target='_blank'>".trans('mail.Your Orders')."</a>";
		$template['site_url'] = "<a href='".lurl('/')."' target='_blank'>Howlik.com</a>";
		
		Mail::send('emails.business.bookinginfo', ['title' => $subject, 'template' => $template], function ($m) use ($pass) {
			$m->to($pass['email'], $pass['name'])->subject($pass['subject']);
		});
		/* EOF Notification email to business owner */
		
		return json_encode($reply);
	}
	
	function book_table(HttpRequest $request) {
		$tsbid 		= $request->input('tsbid');
		$tb_name 	= $request->input('tb_name');
		$tb_email 	= $request->input('tb_email');
		$tb_mobile 	= $request->input('tb_mobile');
		$tb_message = $request->input('tb_message');
		$sr_date 	= $request->session()->get('sr_date');
		$sr_time 	= $request->session()->get('sr_time');
		$sr_people 	= $request->session()->get('sr_people');
		
		$bbTblSettings = BusinessBookingTblSettings::where('id', $tsbid)->first();
		$extraInfoA['time'] = $bbTblSettings->tbl_from.'-'.$bbTblSettings->tbl_to;
		$extraInfoA['seat'] = $bbTblSettings->seat_min.'-'.$bbTblSettings->seat_max;
		$biz_id = $bbTblSettings->biz_id;
		
		$extraInfoA['sr_date'] 	 = $sr_date;
		$extraInfoA['sr_time'] 	 = $sr_time;
		$extraInfoA['sr_people'] = $sr_people;
		
		// get location details from session if exist
		$biz_loc = '';
		if(Session::has('bizLocationNow')) {
			
			$biz_loc = Session::get('bizLocationNow');
		}
		
		$today_dt 				= Carbon::now($this->country->get('timezone')->time_zone_id);
		$bookOrder 				= new BusinessBookingOrder();
		$bookOrder->settings_id = $tsbid;
		$bookOrder->biz_id 		= $biz_id;
		$bookOrder->biz_loc 	= $biz_loc;
		$bookOrder->book_type 	= 5;
		$bookOrder->user_id 	= $this->user->id;
		$bookOrder->extraInfo	= serialize($extraInfoA);
		$bookOrder->name 		= $tb_name;
		$bookOrder->email 		= $tb_email;
		$bookOrder->mobile 		= $tb_mobile;
		$bookOrder->notes 		= $tb_message;
		$bookOrder->book_date 	= $sr_date;
		$bookOrder->created_at 	= $today_dt;
		$bookOrder->save();
		
		$reply['html'] = '<p>'.t('Your reservation has been sent for Approval, Please click')." <a href='".lurl('/account/mybusinessorders')."'> ".t('here')." </a> ".t('to know status.').'</p>';
		$reply['html'] .= '<p><button class="comment btn" onclick="closeInfoMsgTbl();">'.t('Go Back').'</button></p>';
		
		/* BOF Notification email to business owner */
		$business = Business::where('id', $biz_id)->first();
		$biz_owner = User::select('name', 'email')->where('id', $business->user_id)->first();
		$subject = trans('mail.Howlik: New business reservation').' '.date('m/d/Y h:i A', time());
		$pass['subject'] = $subject;
		$pass['email'] = $biz_owner->email;
		$pass['name'] = $biz_owner->name;
		$link    =   "/".str_replace(' ', '-', $business->title)."/".$business->id.".html";
		
		$template['biz_owner'] = $biz_owner->name;
		$template['biz_link'] = "<a href='".lurl($link)."' target='_blank'>".$business->title."</a>";
		$template['your_orders'] = "<a href='".lurl('account/businessbooking/'.$business->id)."' target='_blank'>".trans('mail.Your Orders')."</a>";
		$template['site_url'] = "<a href='".lurl('/')."' target='_blank'>Howlik.com</a>";
		
		Mail::send('emails.business.bookinginfo', ['title' => $subject, 'template' => $template], function ($m) use ($pass) {
			$m->to($pass['email'], $pass['name'])->subject($pass['subject']);
		});
		/* EOF Notification email to business owner */
		
		return json_encode($reply);
	}
	
	function updateBooking(HttpRequest $request) {
		$biz_id = $request->input('biz_id');
		$booking = $request->input('booking');
		$booking_type = $request->input('booking_type');
		
		$business = \DB::table('business')->where('id', $biz_id)->where('user_id', $this->user->id)->first();
		if(count($business)){
			//$business->booking = $booking;
			//$business->booking_type = $booking_type;
			//$business->save();
			$business = \DB::table('business')->where('id', $biz_id)->where('user_id', $this->user->id)
			->update(['booking'=>$booking,'booking_type'=>$booking_type]);
			
			$chkBtype = '';
			if(isset($business->booking) && $business->booking==1){
				$chkTxt = t('Enabled');
				$bookings	=	BusinessBooking::where('translation_lang', $this->lang->get('abbr'))->where('id', $booking_type)->where('active', 1)->first();
				if(count($bookings)>0){
					$chkBtype = $bookings->title;
				}
			}else{	
				$chkTxt = t('Disabled');
			}
		}
		$statusInfo = '<strong>'.$chkTxt.'</strong>';
		if($chkBtype != '') $statusInfo .= '<span style="margin-left: 10px;"> '.$chkBtype.' </span>';
		
		$booking_settings = $request->input('booking_settings');
		$booking_settingsA = explode('V#V', $booking_settings);		
		foreach($booking_settingsA as $key => $value){
			if(trim($value)!=''){
				if($booking_type==3){//Timeslot Booking Settings
					$valueA = explode("#", $value);
					
					$tm_from_val	= trim($valueA[0]);
					$tm_to_val		= trim($valueA[1]);
					$tm_price		= trim($valueA[2]);
					$tm_slot		= trim($valueA[3]);
					
					$bbTmSettings = new BusinessBookingTmSettings();
					$bbTmSettings->biz_id  = $biz_id;
					$bbTmSettings->tm_from = $tm_from_val;
					$bbTmSettings->tm_to = $tm_to_val;
					$bbTmSettings->price = $tm_price;
					$bbTmSettings->slots = $tm_slot;
					$bbTmSettings->save();
				}else{//Table Booking Settings
					$valueA = explode("#", $value);
					
					$tbl_from_val	= trim($valueA[0]);
					$tbl_to_val		= trim($valueA[1]);
					$seat_min		= trim($valueA[2]);
					$seat_max		= trim($valueA[3]);
					$tbl_table		= trim($valueA[4]);
					
					$bbTblSettings = new BusinessBookingTblSettings();
					$bbTblSettings->biz_id  = $biz_id;
					$bbTblSettings->tbl_from = $tbl_from_val;
					$bbTblSettings->tbl_to = $tbl_to_val;
					$bbTblSettings->seat_min = $seat_min;
					$bbTblSettings->seat_max = $seat_max;
					$bbTblSettings->tbl_table = $tbl_table;
					$bbTblSettings->save();
				}
			}
		}
		
		$content = '';
		if($booking_type==3){//Timeslot Booking Settings
			$bookTmSettings		=	BusinessBookingTmSettings::where('biz_id', $biz_id)->orderBy('tm_from')->get();
			foreach($bookTmSettings as $key => $value){
				$content .= '<div id="tmbox_'.$value['id'].'"><span>['.date("h:i A", strtotime($value['tm_from'])).' </span><span>- </span><span>'.date("h:i A", strtotime($value['tm_to'])).'] </span>&nbsp;<span>['.$value['price'].']</span>&nbsp;<span>['.$value['slots'].']</span>&nbsp;<a href="#" class="rem-bhd"><i class="fa fa-minus-square"></i></a><input name="booking_settingsd[]" value="'.$value['id'].'" type="hidden"></div>';
			}
		}else{//Table Booking Settings
			$bookTblSettings	=	BusinessBookingTblSettings::where('biz_id', $biz_id)->orderBy('tbl_from')->get();
			foreach($bookTblSettings as $key => $value){
				$content .= '<div id="tblbox_'.$value['id'].'"><span>['.date("h:i A", strtotime($value['tbl_from'])).' </span><span>- </span><span>'.date("h:i A", strtotime($value['tbl_to'])).' </span>&nbsp;<span>['.$value['seat_min'].']</span>&nbsp;<span>['.$value['seat_max'].']</span>&nbsp;<span>['.$value['tbl_table'].']</span>&nbsp;<a href="#" class="rem-bhd-tbl"><i class="fa fa-minus-square"></i></a><input name="booking_settings_tbld[]" value="'.$value['id'].'" type="hidden"></div>';
			}
		}
		$reply['content'] = $content;
		$reply['statusInfo'] = $statusInfo;
		$reply['msg'] = t('Successfully Updated!');
		echo json_encode($reply);
	}
	
	function biz_bookTmCheck(HttpRequest $request) {
		//Need to write booking checking here
		$biz_id = $request->input('biz_id');
		$id = $request->input('set');
		$reply['status'] = 'error';
		$business = Business::where('id', $biz_id)->where('user_id', $this->user->id)->first();
		if(count($business)>0){
			$flg = 0;
			if($request->has('type')){
				if($request->input('type')==5){
					$flg = 1;
					$bbtm = BusinessBookingTblSettings::find($id);
					$bbtm->delete();
				}
			}
			if($flg == 0){
				$bbtm = BusinessBookingTmSettings::find($id);
				$bbtm->delete();
			}
			$reply['status'] = 'success';
			$reply['msg'] = t('Successfully Deleted!');
		}
		return json_encode($reply);
	}
	
	function updateGifting(HttpRequest $request) {
		
		$biz_id		=	$_GET['biz_id'];
		$status		=	$_GET['status'];
		$amountStr	=	$_GET['amount'];
		$gift_info	=	explode('*',$amountStr);
		
		if($status == 1 && $status != '') {
			
			$businessGift				= Business::where('id', $biz_id)->first();
			$businessGift->gifting		= 1;
			$businessGift->gift_info	= serialize($gift_info);
			$businessGift->save();
			
			return 1;
			
		} else {
			
			$businessGift				= Business::where('id', $biz_id)->first();
			$businessGift->gifting		= 0;
			$businessGift->gift_info	= '';
			$businessGift->save();
			
			return 0;
		}
	}
}
