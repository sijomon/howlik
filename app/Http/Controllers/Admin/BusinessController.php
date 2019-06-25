<?php

namespace App\Http\Controllers\Admin;

use App\Larapen\Models\Category;
use App\Larapen\Models\Country;
use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\City;
use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessOffer;
use App\Larapen\Models\BusinessImage;
use App\Larapen\Models\BusinessLocation;
use App\Larapen\Models\OfferType;
use App\Larapen\Models\Review;
use App\Larapen\Models\Catcsv; 

use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\BusinessRequest as StoreRequest;
use App\Http\Requests\Admin\BusinessRequest as UpdateRequest;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;
use DB;
use Redirect;
use Validator;
use Session;

class BusinessController extends CrudController
{
    public $crud = array(
    
        "model" => "App\Larapen\Models\Business",
        "entity_name" => "Business Listing",
        "entity_name_plural" => "Business Listings",
        "route" => "admin/business",
        "reorder" => false,
        "add_permission" => true,
		"csv" =>true,
        "csvroute"  =>'upload_business_csv',
		"csvsample"  =>'uploads/business/sample_product.xlsx',
		"limit" =>10,
		"bizMod" => 1,
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'created_at',
                'label' => "Date",
            ],
            [
                'name' => 'title',
                'label' => "Title",
                'type' => "model_function",
                'function_name' => 'getTitleHtml',
            ],
            [
                'name' => 'title_ar',
                'id' => 'title_ar',
                'label' => "Title(AR)",
            ],
            [
                'name' => 'user_id',
                'label' => "Owner",
                'type' => "model_function",
                'function_name' => 'getUserHtml',
            ],
            [
                'name' => 'country_code',
                'label' => "Country",
            ],
            [
                'name' => 'city_id',
                'label' => "City",
                'type' => "model_function",
                'function_name' => 'getCityHtml',
            ],
			[
                'name' => 'id',
                'label' => "Extras",
                'type' => "model_function",
                'function_name' => 'getExtraHtml',
            ],
            [
                'name' => 'active',
                'label' => "Active",
                'type' => "model_function",
                'function_name' => 'getActiveHtml',
            ],
        ],
        
		'fields' => [
			[   
				// Hidden
				'name' => 'id',
				'label' => "id",
				'type' => 'hidden',
			],
		
		],
        
        // *****
        // FIELDS ALTERNATIVE
        // *****]
		// "update_fields" => [
		
		"fields" => [
			[
				'label' => "Category",
				'name' => 'category_id',
				'id' => 'category_id',
				'type' => 'select_from_array',
				'options' => [],
				'allows_null' => false,
			],
			[
				'label' => "Keywords",
				'name' => 'keywords',
				'type' => 'multi_checkboxes',
			],
			[
				'name' => 'title',
				'label' => 'Title',
				'type' => 'text',
				'placeholder' => 'Title (In English.)',
			],
			[
				'name' => 'title_ar',
				'label' => 'Title(AR)',
				'type' => 'text',
				'placeholder' => 'Title (In Arabic.)',
			],
			[
				'name' => 'description',
				'label' => "Description",
				'type' => 'textarea',
				'placeholder' => 'Description (In English.)',
			],
			[
				'name' => 'description_ar',
				'label' => "Description(AR)",
				'type' => 'textarea',
				'placeholder' => 'Description (In Arabic.)',
			],
			[
				'name' => 'biz_hours',
				'label' => "Biz Hours",
				'type' => 'biz_hours',
			],
			[
				'name' => 'more_info',
				'label' => "More Info",
				'type' => 'more_info',
			],
			[
				'name' => 'phone',
				'label' => 'Phone Number',
				'type' => 'text',
				'placeholder' => 'Phone Number',
			],
			[
				'name' => 'web',
				'label' => 'Website',
				'type' => 'text',
				'placeholder' => 'www.your-site.com',
			],
			[
				'id' => 'address1',
				'name' => 'address1',
				'label' => 'Address 1',
				'type' => 'text',
				'placeholder' => '',
			],
			[
				'id' => 'address2',
				'name' => 'address2',
				'label' => 'Address 2',
				'type' => 'text',
				'placeholder' => '',
			],
			[
				'label' => "Country",
				'name' => 'country_code',
				'id' => 'countryCode',
				'type' => 'select_from_array',
				'options' => [],
				'allows_null' => false,
			],
			[
				'id'	=>'locationCode',
				'name' => 'subadmin1_code',
				'label' => 'Location',
				'type' => 'select_from_array',
				'options' => [],
				'allows_null' => false,
			],
			[
				'id'	=>'city_id',
				'name' => 'city_id',
				'label' => 'City',
				'type' => 'select_from_array',
				'options' => [],
				'allows_null' => false,
			],
			[
				'id' => 'zip',
				'name' => 'zip',
				'label' => 'Zip code',
				'type' => 'text',
				'placeholder' => '',
			],
			[
				'type' => 'text',
				'name' => 'biz_email',
				'label' => 'Email',
				'placeholder' => 'Email Address',
				'id' => 'biz_email',
			],
			[
				'label' => "Map Position",
				'name' => 'google_map',
				'type' => 'google_map',
			],
			[
				'label'=> "Business Images",
				'name' => 'id',
				'type' => 'biz_pics',
				'id' => 'biz_id',
			],
			[
				'label'=> "Offers & Discounts",
				'name' => 'id',
				'type' => 'biz_offers',
			],
			[
				'label'=> "More Locations",
				'name' => 'id',
				'type' => 'biz_locations',
			],
			[
				'name' => 'lat',
				'value' => '0',
				'type' => 'hidden',
			],
			[
				'name' => 'lon',
				'value' => '0',
				'type' => 'hidden',
			],
			[
				'name' => 'active',
				'label' => "Active",
				'type' => 'checkbox'
			],
		],
    );
	
    public function __construct()
    {
        $this->crud['fields'][0]['options'] = $this->categories();
		//$this->crud['fields'][1]['options'] = $this->key();
		$this->crud['fields'][12]['options'] = $this->countries();
       // $this->crud->addButton($stack, $name, $type, $content, $position);
		
        parent::__construct();
    }
    
    public function store(StoreRequest $request)
    {
		foreach ($this->crud['fields'] as $k => $field) {
			
			if($request->has($field['name']) && $field['name']=='keywords'){
				$request->merge(array($field['name'] => implode(',',$request->get($field['name']))));
			}
			if($request->has($field['name']) && $field['name']=='biz_hours'){
				$data = $request->get($field['name']);
				
				$tA = array();
				$sortA = array();
				foreach($data as $key => $value)
				{
					$bizhrsA = explode(' ', $value);
					if(isset($tA[$bizhrsA[0]]))
						$tsize = count($tA[$bizhrsA[0]]);
					else
						$tsize =0;
					$tA[$bizhrsA[0]][$tsize] = $bizhrsA;
					$sortA[$bizhrsA[0]][$tsize] = $bizhrsA[1];
				}
				
				$sorted = array();
				foreach($tA as $key => $value){
					array_multisort($sortA[$key], SORT_ASC, $value);
					foreach($value as $key1 => $value1){
						$sorted[] = implode(' ', $value1);
					}
				}
				$request->merge(array($field['name'] => serialize($sorted)));
			}
			if($request->has($field['name']) && $field['name']=='more_info'){
				$request->merge(array($field['name'] => serialize($request->get($field['name']))));
			}
			if($request->has($field['name']) && $field['name']=='lat'){
				$request->merge(array($field['name'] => $request->get('lat1')));
			}
			if($request->has($field['name']) && $field['name']=='lon'){
				$request->merge(array($field['name'] => $request->get('lon1')));
			}
		}
        return parent::storeCrud($request);
    }
    
    public function update(UpdateRequest $request)
    {
		
		foreach ($this->crud['fields'] as $k => $field) {
			
			if($request->has($field['name']) && $field['name']=='keywords'){
				$request->merge(array($field['name'] => implode(',',$request->get($field['name']))));
			}
			if($request->has($field['name']) && $field['name']=='biz_hours'){
				$data = $request->get($field['name']);
				
				$tA = array();
				$sortA = array();
				foreach($data as $key => $value)
				{
					$bizhrsA = explode(' ', $value);
					if(isset($tA[$bizhrsA[0]]))
						$tsize = count($tA[$bizhrsA[0]]);
					else
						$tsize =0;
					$tA[$bizhrsA[0]][$tsize] = $bizhrsA;
					$sortA[$bizhrsA[0]][$tsize] = $bizhrsA[1];
				}
				
				$sorted = array();
				foreach($tA as $key => $value){
					array_multisort($sortA[$key], SORT_ASC, $value);
					foreach($value as $key1 => $value1){
						$sorted[] = implode(' ', $value1);
					}
				}
				
				$request->merge(array($field['name'] => serialize($sorted)));
			}
			
			if($request->has($field['name']) && $field['name']=='more_info'){
				$request->merge(array($field['name'] => serialize($request->get($field['name']))));
			}
			if($request->has($field['name']) && $field['name']=='lat'){
				$request->merge(array($field['name'] => $request->get('lat1')));
			}
			if($request->has($field['name']) && $field['name']=='lon'){
				$request->merge(array($field['name'] => $request->get('lon1')));
			}
		}
        return parent::updateCrud($request);
    }
	
    /*public function adType()
    {
        $entries = AdType::where('translation_lang', config('app.locale'))->get();
        if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        foreach ($entries as $entry) {
            $tab[$entry->translation_of] = $entry->name;
        }
        
        return $tab;
    }*/
    
    public function categories()
    {
        $entries = Category::where('translation_lang', config('app.locale'))->where('parent_id', 0)->orderBy('lft')->get();
        if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        foreach ($entries as $entry) {
            $tab[$entry->translation_of] = $entry->name;
        }
        
        return $tab;
    }
	
	public function countries()
    {
        $entries = Country::where('active', 1)->orderBy('asciiname')->get();
        if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        foreach ($entries as $entry) {
            $tab[$entry->code] = $entry->asciiname;
        }
        
        return $tab;
    }
	
	public function keywords()
	{
		$cat   = Request::get('cat');
		$vals  = Request::get('vals');
		
		$valsA = explode(',', $vals);
		$entries = Category::where('translation_lang', config('app.locale'))->where('parent_id', $cat)->orderBy('lft')->get();
		$res = '';
		foreach ($entries as $key => $entry) {
			$sel = ''; if(in_array($entry->id, $valsA))$sel = ' checked="checked"';
			$res .= '<span><input name="keywords[]" value="'.$entry->id.'" '.$sel.' label="'.$entry->name.'" type="checkbox"> '.$entry->name.'&nbsp;</span>&nbsp;';
			if(($key+1)%3==0)$res .= '<br />';
        }
		echo json_encode (array( 'res' => $res ));
	}
	
	public function location()
	{
		$code   = Request::get('code');
		$curLoc = Request::get('curLoc');
		
		$entries = SubAdmin1::where('code', 'LIKE', $code . '.%')->orderBy('name')->get(['code', 'asciiname']);
		$res = '<option value="">Location</option>';
		foreach ($entries as $key => $entry) {
			$sel = ''; if($entry->code==$curLoc)$sel = '  selected="selected""';
			$res .= '<option value="'.$entry->code.'" '.$sel.'>'.$entry->asciiname.'</option>';
        }
		echo json_encode (array( 'res' => $res ));
	}
	
	public function city()
	{
		$code    = Request::get('code');
		$curCity = Request::get('curCity');
		
		$code_tab = explode('.', $code);
        $country_code = $code_tab[0];
        $admin_code = $code_tab[1];
        
        $entries = City::where('country_code', $country_code)->where('subadmin1_code', $admin_code)->orderBy('population', 'desc')->get(['id as code', 'asciiname']);
		$res = '<option value="">City</option>';
		foreach ($entries as $key => $entry) {
			$sel = ''; if($entry->code==$curCity)$sel = '  selected="selected""';
			$res .= '<option value="'.$entry->code.'" '.$sel.'>'.$entry->asciiname.'</option>';
        }
		echo json_encode (array( 'res' => $res ));
	}
	
	public function postOfferAdmin() {
		
		//echo "<pre>";print_r($_POST);die;
		
		if(Session::has('offersNew')) {
			
			$offerNewIds = Session::get('offersNew');
		}
		else {
			
			$offerNewIds = '';
		}
		
		$offertype 	= 	OfferType::where('active', 1)->where('translation_lang', 'en')->lists('title','translation_of');
			
		if(Request::has('biz_id')) 	{
			
			$offersNew				=	new BusinessOffer();
			$offersNew->biz_id		=	Request::get('biz_id');
			$offersNew->offertype 	= 	Request::get('type');
			$offersNew->percent 	= 	Request::get('percent');
			$offersNew->content 	= 	Request::get('content');
			$offersNew->details 	= 	Request::get('details');
			$offersNew->active 		= 	1;
			$offersNew->save();
			
			$offerContent = '<div class="offer-list-card" style="margin-bottom: 15px;" id="off-'.$offersNew->id.'">
								<div class="offer-list-card-title">
									<span> Offer Type : </span>
									<span> <strong> '.$offertype[$offersNew->offertype].' </strong> </span>
								</div>
								<div class="offer-list-card-content">
									<span> Offer Headline : </span>
									<span> <strong>'.$offersNew->percent.' &nbsp; '.$offersNew->content.'</strong> </span>
										
									<span class="pull-right itemoffer">
										<a id="edit-offer-'.$offersNew->id.'" class="btn btn-xs btn-default" onClick="return editChange('.$offersNew->id.');" data-toggle="modal" data-target="#editModal'.$offersNew->id.'"><i class="fa fa-edit"></i></a>
										<a id="drop-offer-'.$offersNew->id.'" class="btn btn-xs btn-danger" onClick="return dropOffer('.$offersNew->id.');"><i class="fa fa-trash"></i></a>
									</span>
								</div> 
							</div>';
						
			echo json_encode(array( 'success' => $offerContent));
		}
		else {
			
			$offersNew				=	new BusinessOffer();
			$offersNew->biz_id		=	0;
			$offersNew->offertype 	= 	Request::get('type');
			$offersNew->percent 	= 	Request::get('percent');
			$offersNew->content 	= 	Request::get('content');
			$offersNew->details 	= 	Request::get('details');
			$offersNew->active 		= 	1;
			$offersNew->save();
			
			$offerNewIds	.=	$offersNew->id.',';
			Session::set('offersNew', $offerNewIds);	
		
			$offerContent = '<div class="offer-list-card" style="margin-bottom: 15px;" id="off-'.$offersNew->id.'">
								<div class="offer-list-card-title">
									<span> Offer Type : </span>
									<span> <strong> '.$offertype[$offersNew->offertype].' </strong> </span>
								</div>
								<div class="offer-list-card-content">
									<span> Offer Headline : </span>
									<span> <strong>'.$offersNew->percent.' &nbsp; '.$offersNew->content.'</strong> </span>
										
									<span class="pull-right itemoffer">
										<a id="edit-offer-'.$offersNew->id.'" class="btn btn-xs btn-default" onClick="return editChange('.$offersNew->id.');" data-toggle="modal" data-target="#editModal'.$offersNew->id.'"><i class="fa fa-edit"></i></a>
										<a id="drop-offer-'.$offersNew->id.'" class="btn btn-xs btn-danger" onClick="return dropOffer('.$offersNew->id.');"><i class="fa fa-trash"></i></a>
									</span>
								</div> 
							</div>';
						
			echo json_encode(array( 'success' => $offerContent));
			
		}
	}
	
	public function editOfferAdmin() {
		
		// Update Business Offer Details from database on admin side
		$offersEdit	=	BusinessOffer::findOrFail(Request::get('off_id'));
	
		if(!is_null($offersEdit) && Request::has('off_id'))
		{
			$offersEdit->offertype 	= 	Request::get('type');
			$offersEdit->percent 	= 	Request::get('percent');
			$offersEdit->content 	= 	Request::get('content');
			$offersEdit->details 	= 	Request::get('details');
			$offersEdit->update();
			return 1;
			
		} else {
			return 0;
		}
	}
	
	public function dropOfferAdmin() {
		
		// Delete Business Offer Details from database on admin side
		$offersEdit	=	BusinessOffer::findOrFail(Request::get('id'));
	
		if(!is_null($offersEdit) && Request::has('id'))
		{
			$offersEdit->delete();
			return 1;
		} else {
			return 0;
		}
	}
	
	public function postLocationAdmin() {
		
		//echo "<pre>";print_r($_POST);die;
		
		$biz_id 		= 0;
		$locationNewIds = '';
		
		if(Session::has('LocationsNew')) {
			
			$locationNewIds = Session::get('LocationsNew');
		}
		
		if(Request::has('biz_id')) 	{
			
			$biz_id = Request::get('biz_id');
		}
		
		if(Request::has('city')) 	{
			
			$ciid =	Request::get('city');
			
			$nameof	= 	\DB::table('cities')
						->select('cities.asciiname as city', 'countries.asciiname as country')
						->leftjoin('countries', 'cities.country_code', '=', 'countries.code')
						->where('cities.id', $ciid)
						->first();
		}
		
		$locationNew				=	new BusinessLocation();
		$locationNew->biz_id		=	$biz_id;
		$locationNew->address_1 	= 	Request::get('address1');
		$locationNew->address_2 	= 	Request::get('address2');
		$locationNew->phone 		= 	Request::get('phone');
		$locationNew->country_id 	= 	Request::get('country');
		$locationNew->location_id 	= 	Request::get('location');
		$locationNew->city_id 		= 	Request::get('city');
		$locationNew->zip_code 		= 	Request::get('zip');
		$locationNew->lat 			= 	Request::get('lat');
		$locationNew->lon 			= 	Request::get('lon');
		$locationNew->active 		= 	1;
		$locationNew->base 			= 	0;
		$locationNew->save();
		
		if($locationNew->biz_id == 0) {
			
			$locationNewIds	.=	$locationNew->id.',';
			Session::set('LocationsNew', $locationNewIds);	
		}
		
		$locationContent 	=	'<div class="col-md-6" id="loc-'.$locationNew->id.'">
									<div class="location-list-card">
										<div class="location-list-card-title">
											<span class="pull-right itemoffer">
												<a id="drop-location-'.$locationNew->id.'" class="btn btn-xs btn-danger" onClick="dropLocation('.$locationNew->id.');"><i class="fa fa-trash"></i></a>
											</span>
											<span> <strong><i class="fa fa-map-marker"></i> &nbsp; '.$nameof->city.', &nbsp;'.$nameof->country.' </strong> </span>
										</div>
								
										<div class="location-list-card-content">
											<span class="text-muted">  '.str_limit($locationNew->address_1, 40).' </span><br>
											<span class="text-muted"><i class="fa fa-phone"></i>  &nbsp;'.$locationNew->phone.' </span>
										</div> 
									</div>
								</div>';
					
		echo json_encode(array( 'success' => $locationContent));
	}
	
	public function editLocationAdmin() {
		
        $locationTbl = BusinessLocation::find(Request::get('id'));
		$business_location = array(
		
            'address_1' => Request::get('address1'),
            'address_2' => Request::get('address2'),
            'phone' => Request::get('phone'),
			'country_id' => Request::get('country'),
			'location_id' => Request::get('location'),
            'city_id' => Request::get('city'),
            'zip_code' => Request::get('zip'),
            'lat' => Request::get('lat'),
            'lon' => Request::get('lon'),
        );
        $locationTbl->update($business_location);
		
		if($locationTbl) {
			return response()->json('success', 200);
        } 
		else {
			return response()->json('error', 400);
        }
	}
	
	public function dropLocationAdmin() {
		
		$business	= DB::table('businessLocations')->where('id', Request::get('id'))->delete();
		
		if($business) {
			return response()->json('success', 200);
        } 
		else {
			return response()->json('error', 400);
        }
	}
	
	public function getOffersList()
    {
		$biz_id	= Request::get('id');
		
		$modal_head	= '';
		$modal_body	= '';
		
		if($biz_id > 0){
			
			$business		=	Business::where('id', $biz_id)->lists('title','id');
			
			$businessOffers	=	BusinessOffer::withoutGlobalScopes([ActiveScope::class])->where('biz_id', $biz_id)->get();
		
			$offertype 		=	OfferType::where('active', 1)->where('translation_lang', config('app.locale'))->lists('title','translation_of');
			
			$modal_head		.=	'<h4 class="modal-title"><strong> Offers on ' .ucfirst($business[$biz_id]).' </strong></h4>';
			
			if(count($businessOffers) > 0)
			{
				foreach($businessOffers as $offer) {
					
					if($offer->details == "") {
						
						if($offer->offertype == 1) {
						
							$modal_body .= '<div class="col-md-12">
												<div class="offer-list-card" style="margin-bottom: 15px;">
													<div class="offer-list-card-title">
														<strong> Offer Type </strong> : '.$offertype[$offer->offertype].'
													</div>
													<div class="offer-list-card-content">
														<span> <strong> Offer Headline : </strong>'.$offer->percent.'% off '.$offer->content.' </span> </br>
													</div> 
												</div>
											</div>';
						}
						else if($offer->offertype == 2) {
						
							$modal_body .= '<div class="col-md-12">
												<div class="offer-list-card" style="margin-bottom: 15px;">
													<div class="offer-list-card-title">
														<strong> Offer Type </strong> : '.$offertype[$offer->offertype].'
													</div>
													<div class="offer-list-card-content">
														<span> <strong> Offer Headline : </strong> $'.$offer->percent.' off '.$offer->content.' </span> </br>
													</div> 
												</div>
											</div>';
						}
						else if($offer->offertype == 3) {
						
							$modal_body .= '<div class="col-md-12">
												<div class="offer-list-card" style="margin-bottom: 15px;">
													<div class="offer-list-card-title">
														<strong> Offer Type </strong> : '.$offertype[$offer->offertype].'
													</div>
													<div class="offer-list-card-content">
														<span> <strong> Offer Headline : </strong>'.$offer->percent.' free '.$offer->content.' </span> </br>
													</div> 
												</div>
											</div>';
						}
						else if($offer->offertype == 4) {
						
							$modal_body .= '<div class="col-md-12">
												<div class="offer-list-card" style="margin-bottom: 15px;">
													<div class="offer-list-card-title">
														<strong> Offer Type </strong> : '.$offertype[$offer->offertype].'
													</div>
													<div class="offer-list-card-content">
														<span> <strong> Offer Headline : </strong> $'.$offer->percent.' for '.$offer->content.' </span> </br>
													</div> 
												</div>
											</div>';
						}
					}
					else {
						
						if($offer->offertype == 1) {
						
							$modal_body .= '<div class="col-md-12">
												<div class="offer-list-card" style="margin-bottom: 15px;">
													<div class="offer-list-card-title">
														<strong> Offer Type </strong> : '.$offertype[$offer->offertype].'
													</div>
													<div class="offer-list-card-content">
														<span> <strong> Offer Headline : </strong>'.$offer->percent.'% off '.$offer->content.' </span> </br>
													</div> 
													<div class="offer-list-card-content">
														<span> <strong> Optional Details : </strong>'.$offer->details.' </span> </br>
													</div> 
												</div>
											</div>';
						}
						else if($offer->offertype == 2) {
						
							$modal_body .= '<div class="col-md-12">
												<div class="offer-list-card" style="margin-bottom: 15px;">
													<div class="offer-list-card-title">
														<strong> Offer Type </strong> : '.$offertype[$offer->offertype].'
													</div>
													<div class="offer-list-card-content">
														<span> <strong> Offer Headline : </strong> $'.$offer->percent.' off '.$offer->content.' </span> </br>
													</div> 
													<div class="offer-list-card-content">
														<span> <strong> Optional Details : </strong>'.$offer->details.' </span> </br>
													</div> 
												</div>
											</div>';
						}
						else if($offer->offertype == 3) {
						
							$modal_body .= '<div class="col-md-12">
												<div class="offer-list-card" style="margin-bottom: 15px;">
													<div class="offer-list-card-title">
														<strong> Offer Type </strong> : '.$offertype[$offer->offertype].'
													</div>
													<div class="offer-list-card-content">
														<span> <strong> Offer Headline : </strong>'.$offer->percent.' free '.$offer->content.' </span> </br>
													</div> 
													<div class="offer-list-card-content">
														<span> <strong> Optional Details : </strong>'.$offer->details.' </span> </br>
													</div> 
												</div>
											</div>';
						}
						else if($offer->offertype == 4) {
						
							$modal_body .= '<div class="col-md-12">
												<div class="offer-list-card" style="margin-bottom: 15px;">
													<div class="offer-list-card-title">
														<strong> Offer Type </strong> : '.$offertype[$offer->offertype].'
													</div>
													<div class="offer-list-card-content">
														<span> <strong> Offer Headline : </strong> $'.$offer->percent.' for '.$offer->content.' </span> </br>
													</div> 
													<div class="offer-list-card-content">
														<span> <strong> Optional Details : </strong>'.$offer->details.' </span> </br>
													</div>
												</div>
											</div>';
						}
					}
				}
			}
			else
			{
				$modal_body	.=	'<div class="col-md-12">
									<div class="offer-list-card" style="margin-bottom: 15px;">
										<div class="offer-list-card-title">
											<strong> Empty! </strong>
										</div>
									</div>
								</div>';
			}
		}
		echo json_encode(array( 'modal_head' => $modal_head,'modal_body' => $modal_body ));
	}
	
	public function getGiftsList()
    {
		$biz_id	=	Request::get('id');
		
		$modal_head	=	'';
		$modal_body	=	'';
		
		if($biz_id > 0){
			
			$business	=	Business::where('id', $biz_id)->lists('title','id');
			
			$currency	=	DB::table('business')->select('currencies.html_entity as currency')
							->join('countries','countries.code','=','business.country_code')
							->join('currencies','currencies.code','=','countries.currency_code')
							->where('business.id', $biz_id)
							->first();
			
			$gifts		=	DB::table('gift_certificates')
							->select('gift_certificates.*','users.photo as image','users.name as user_name')
							->join('users','users.id','=','gift_certificates.user_id')
							->where('gift_certificates.biz_id', $biz_id)
							->orderBy('gift_certificates.created_at', 'DESC')
							->get();
		
			$modal_head	.=	'<h4 class="modal-title"><strong> Gift Certificates on ' .ucfirst($business[$biz_id]).' </strong></h4>';
			
			if(count($gifts) > 0) {
				
				foreach($gifts as $gift) {
					
					$recipients		=	DB::table('gift_recipients')
										->where('gift_recipients.biz_id', $biz_id)
										->where('gift_recipients.gift_id', $gift->id)
										->where('gift_recipients.sender_id', $gift->user_id)
										->get();
					
					if($gift->image != ''){
						
						$image	=	"http://www.howlik.com/uploads/pictures/dp/".$gift->image; 
						
					} else {
						
						$image	=	"http://www.howlik.com/uploads/pictures/dp/1489643127.png";
					}
					
					$recipient		=	'';
					if($gift->total_quantity > 1) {
						$recipient	=	"Recipients";
					} else {
						$recipient	=	"Recipient";
					}
					
					if(count($recipients) > 0) {
						
						$recipient_content	=	'';
						foreach($recipients as $recipie) {
							
							$recipient_content	.=	'<div class="col-md-6">
														<div class="offer-list-card" style="margin-bottom: 15px; height: auto;">
															<div class="offer-list-card-title" style="height: auto;"> 
																<strong>'.ucfirst($recipie->recipient_name).'</strong><br>
																<span>'.$recipie->recipient_email.'</span>
															</div>
															<div class="offer-list-card-content" style="height: auto;"> 
																<h4><small> Price : </small>'.$currency->currency.' '.$gift->each_price.'</h4>
																<h4><small> Coupen Code : </small>'.$recipie->gift_code.' </h4>
															</div>
														</div>
													</div>';
						}
					}
					
					$modal_body	.=	'<div class="col-md-12">
										<div class="offer-list-card" style="margin-bottom: 15px; height: auto;">
											<div class="offer-list-card-title" style="height: auto;">
												<img src="'. $image .'" style="width: 3em; height: 3em; float: left; border-radius: 50%; margin-right: 5px;" /> 
												<strong>'.ucfirst($gift->user_name).'</strong><br>
												<span>'.date("Y-m-d h:i A", strtotime($gift->created_at)).'</span>
												<span class="pull-right">'.$gift->total_quantity.' '.$recipient.'</span>
											</div>
											<div class="offer-list-card-content" style="height: auto;">'.$recipient_content.'</div>
										</div>
									</div>';
				}
				
			} else {
				
				$modal_body	.=	'<div class="col-md-12">
									<div class="offer-list-card" style="margin-bottom: 15px;">
										<div class="offer-list-card-title">
											<strong> Empty! </strong>
										</div>
									</div>
								</div>';
			}
			
		}
		echo json_encode(array( 'modal_head' => $modal_head,'modal_body' => $modal_body));
	}
	
	public function get_business_ajax(){ 
		$srch	=	'';
		if(Request::has('srch')){
			$srch = trim(Request::get('srch'));
		}
		if($srch != ''){
			$business	=	Business::where('title','LIKE',$srch.'%')->orWhere('title','LIKE','%'.$srch)->orWhere('title','LIKE','%'.$srch.'%')
									  ->orwhere('title_ar','LIKE',$srch.'%')->orWhere('title_ar','LIKE','%'.$srch)->orWhere('title_ar','LIKE','%'.$srch.'%')->paginate($this->crud['limit']);
		}else{
			$business	=	Business::paginate($this->crud['limit']);
		}
		$tableRow = ''.$srch;
		foreach ($business as $k => $entry){
			$tableRow .= '<tr data-entry-id="'.$entry->id.'">';
			$tableRow .= '<td>'.$entry->created_at.'</td>';
			$tableRow .= '<td>'.$entry->getTitleHtml().'</td>';
			$tableRow .= '<td>'.$entry->title_ar.'</td>';
			$tableRow .= '<td>'.$entry->getUserHtml().'</td>';
			$tableRow .= '<td>'.$entry->country_code.'</td>';
			$tableRow .= '<td>'.$entry->getCityHtml().'</td>';
			$tableRow .= '<td>'.$entry->getExtraHtml().'</td>';
			$tableRow .= '<td>'.$entry->getActiveHtml().'</td>';
			$tableRow .= '<td>';
			$tableRow .= '<a href="'.url('admin/business/'.$entry->id.'/edit').'" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a>';
			$tableRow .= '<a href="'.url('admin/business/'.$entry->id).'" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>';
			$tableRow .= '</td>';
			$tableRow .= '</tr>';
		}
		$pageLinks = (string)$business->links();
		$pageLinks = str_replace('_ajax?page', '?page', $pageLinks);
		$replyA['data'] = $tableRow;
		$replyA['paging'] = $pageLinks;
		return json_encode($replyA);
	}

	public function getReviewsList()
    {
		$biz_id	=	Request::get('id');
		
		$modal_head	=	'';
		$modal_body	=	'';
		
		if($biz_id > 0){
			
			$business	=	Business::where('id', $biz_id)->lists('title','id');
			
			$reviews	=	DB::table('review')
							->select('review.*','users.photo as image')
							->join('users','users.id','=','review.user_id')
							->where('review.biz_id', $biz_id)
							->orderBy('review.created_at', 'DESC')
							->get();
		
			$modal_head	.=	'<h4 class="modal-title"><strong> Reviews & Ratings of ' .ucfirst($business[$biz_id]).' </strong></h4>';
			
			if(count($reviews) > 0) {
				
				foreach($reviews as $review) {
					
					if($review->image != ''){
						
						$image	=	"http://www.howlik.com/uploads/pictures/dp/".$review->image; 
						
					} else {
						
						$image	=	"http://www.howlik.com/uploads/pictures/dp/1489643127.png";
					}
					
					$rating	=	'';
					$diff	= 5 - $review->rating;
					if($review->rating > 0 && strlen($review->rating) == 1) {
						
						for($i=0;$i < $review->rating;$i++) {
							$rating .= "<span class='fa fa-star'></span>";
						}
						for($i=0;$i < floor($diff);$i++) {
							$rating .= "<span class='fa fa-star-o'></span>";
						}
					} else {
						
						$rate	=	floor($review->rating);
						for($i=0;$i < $rate;$i++) {
							$rating .= "<span class='fa fa-star'></span>";
						}
						$rating .= "<span class='fa fa-star-half-o'></span>";
						for($i=0;$i < floor($diff);$i++) {
							$rating .= "<span class='fa fa-star-o'></span>";
						}
					}
					
					$modal_body	.=	'<div class="col-md-12">
										<div class="offer-list-card" style="margin-bottom: 15px; height: auto;">
											<div class="offer-list-card-title">
												<img src="'. $image .'" style="width: 3em; height: 3em; float: left; border-radius: 50%; margin-right: 5px;" /> 
												<strong>'.ucfirst($review->user_name).'</strong><br>
												<span>'.date("Y-m-d", strtotime($review->created_at)).'</span>
												<span class="pull-right" style="color: #F60;">'.$rating.'</span> 
											</div>
											<div class="offer-list-card-content" style="height: auto;"> 
												<p>'.$review->review.'</p>
											</div>
										</div>
									</div>';
				}
				
			} else {
				
				$modal_body	.=	'<div class="col-md-12">
									<div class="offer-list-card" style="margin-bottom: 15px;">
										<div class="offer-list-card-title">
											<strong> Empty! </strong>
										</div>
									</div>
								</div>';
			}
			
		}
		echo json_encode(array( 'modal_head' => $modal_head,'modal_body' => $modal_body));
	}
	
	public function upload_business_pics(HttpRequest $request) {
		
		//echo "<pre>";print_r($_POST);die;
		
		if(Session::has('BizPicNew')) {
			
			$picNewIds = Session::get('BizPicNew');
		}
		else {
			
			$picNewIds = '';
		}
		
		$input 	= Input::all();
		$biz_id = $request->input('biz_id');
		
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$validation = Validator::make($input, $rules);
		if ($validation->fails()) {

			return back()->withErrors($validation)->withInput($request->all());
		}
		$file = Input::file('file');
				
		$destinationPath = 'uploads/pictures/business'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = time().rand(1,5).'.'.$extension; // renameing image
        $upload_success = Input::file('file')->move( public_path().'/'.$destinationPath, $fileName); // uploading file to given path
		
		
        if( $upload_success ) {
			
			$picBigUrl = 'http://www.howlik.com/'.$destinationPath.'/'.$fileName;
			
			$picture = new BusinessImage;
			$picture->biz_id	= $biz_id;
			$picture->filename	= $destinationPath.'/'.$fileName;
			$picture->active	= 1;
			$picture->save();
			
			$picNewIds	.=	$picture->id.',';
			Session::set('BizPicNew', $picNewIds);
			
			$pictureContent =	'<div class="col-md-3 height_100" id="img-'.$picture->id.'">
									<img src="'.$picBigUrl.'" class="bsnz_img" />
									<a class="bsnz_btn_dlt" onclick="deleteBizPic('.$picture->id.');"><i class="fa fa-trash"></i></a>
								</div>';
			
			return response()->json(array( 'success' => $pictureContent,'fileName' => $fileName));
        } 
		else {
			
			return response()->json('error', 400);
        }
	}
	
	public function delete_business_pics(HttpRequest $request) {
		
		//echo "<pre>";print_r($_POST);die;
		
		$picture	= '';
		$fileName	= '';
		$destinationPath = 'uploads/pictures/business/';
		
		if($request->has('id')) {
			
			$id 		= $request->input('id');
			$picture 	= BusinessImage::where('id', $id)->first();
			$fileName 	= $picture->filename;
		}
		elseif($request->has('fileName')) {
			
			$fileName 	= $request->input('fileName');
			$picture 	= BusinessImage::where('filename', $destinationPath.$fileName)->get()->first();
		}
		
		if(is_file( public_path().'/'.$destinationPath.$fileName)) {
			
			unlink($destinationPath.$fileName);
		}
		
		if (!is_null($picture)) {
			
			$picture->delete($picture->id);
			return response()->json('success', 200);
        } 
		else {
			
			return response()->json('error', 400);
        }
	}
	
	public function upload_business_csv()
	{
		
		$error     = '';
		$rules     = ['Upload_file' => 'required|mimes:csv,xls,xlsx,xl,txt' ];
	    $file      = Request::all();
	    $validator = Validator::make($file,$rules);
	    if( $validator->fails())
	    {
			 return Redirect::to('admin/category')->withErrors($validator->errors());
		}
		else
		{
			if( $error =="")
			{
				if(Input::hasFile('Upload_file')){
					
					ini_set('memory_limit', '-1');
					$file = Input::file('Upload_file');
					$name = time() . '-' . $file->getClientOriginalName();
					// Moves file to folder on server
					$path = $file->move(public_path() . '/uploads/CSV', $name);
					$data = Excel::load($path, function($reader) {
					})->get()->toArray();
					
					/*unlink($path);
					echo "<pre>";
					print_r($data);
					exit;*/
					
					if(isset($data) && sizeof($data)>0){
						$error = 0;
						$errorA = array();
						$business_info = array();
						foreach ($data as $key => $value) {
							if(trim($value['name'])!=''){
								$category		= '';
								$name			= '';
								$name_ar		= '';
								$description	= '';
								$description_ar	= '';
								$address		= '';
								$phone			= '';
								$email			= '';
								$web			= '';
								$description	= '';
								$city			= '';
								$region			= '';
								$country		= '';
								$zip			= '';
								$lat			= '';
								$lon			= '';
								$imgFolder		= '';
								$img1			= '';
								$img2			= '';
								$img3			= '';
								if(isset($value['category'])){ 
									$category		= trim($value['category']);
								}
								if(isset($value['name'])){
									$name		= trim($value['name']);
								}
								if(isset($value['name_ar'])){
									$name_ar	= trim($value['name_ar']);
								}
								if($name_ar=='')$name_ar=$name;
								if(isset($value['description'])){
									$description = trim($value['description']);
								}
								if(isset($value['description_ar'])){
									$description_ar = trim($value['description_ar']);
								}
								if($description_ar=='')$description_ar=$description;
								if(isset($value['address'])){
									$address		= trim($value['address']);
								}
								if(isset($value['city'])){
									$city		= trim($value['city']);
								}
								if(isset($value['region'])){
									$region		= trim($value['region']);
								}
								if(isset($value['country_code'])){
									$country	= trim($value['country_code']);
								}
								
								//BOF code to select already existing Region 18/05/18
								$cityA = City::select('subadmin1_code')->where('asciiname', $city)->where('country_code', $country)->where('active', 1)->first();
								if (isset($cityA->subadmin1_code) && trim($cityA->subadmin1_code)!='') {
									$subadmin1_code = trim($cityA->subadmin1_code);
									$subA = SubAdmin1::select('asciiname')->where('code', $subadmin1_code)->where('active', 1)->first();
									if (isset($subA->asciiname) && trim($subA->asciiname)!='') {
										$region		= trim($subA->asciiname);
									}
								}
								//EOF code to select already existing Region 18/05/18
								
								if(isset($value['email'])){
									$email		= trim($value['email']);
								}
								if(isset($value['phone'])){
									$phone		= trim($value['phone']);
								}
								if(isset($value['web'])){
									$web		= trim($value['web']);
								}
								if(isset($value['zip'])){
									$zip		= trim($value['zip']);
								}
								if(isset($value['lat'])){
									$lat		= trim($value['lat']);
								}
								if(isset($value['lon'])){
									$lon		= trim($value['lon']);
								}
								if(isset($value['image_folder_numberunique'])){
									$imgFolder	= trim($value['image_folder_numberunique']);
								}
								if(isset($value['image_1'])){
									$img1		= trim($value['image_1']);
								}
								if(isset($value['image_2'])){
									$img2		= trim($value['image_2']);
								}
								if(isset($value['image_3'])){
									$img3		= trim($value['image_3']);
								}
								
								$category_id = 0;
								$catA = Category::select('translation_of')->where('name', trim($category))->where('parent_id', 0)->where('active', 1)->first();
								if (isset($catA->translation_of) && $catA->translation_of>0) {
									$category_id = $catA->translation_of;
								}else{
									$errorA[] = "($key) Category Not exists (". trim($category). ")";
								}
								$country_code = '';
								$subadmin1_code = '';
								$city_id = 0;
								$conA = Country::select('code')->where('code', trim($country))->where('active', 1)->first();
								if (isset($conA->code) && $conA->code!='') {
									$country_code = $conA->code;
									$subA = SubAdmin1::select('code')->where('asciiname', trim($region))->where('code', 'LIKE', $country_code.'.%')->where('active', 1)->first();
									if (isset($subA->code) && $subA->code!='') {
										$subadmin1_code = $subA->code;
										$subadmin1_codeA = explode('.', $subadmin1_code);
										$cityA = City::select('id')->where('asciiname', trim($city))->where('country_code', $country_code)->where(function ($query) use ($subadmin1_code) {
														$subadmin1_codeA = explode('.', $subadmin1_code);
														$query->where('subadmin1_code', $subadmin1_codeA[1])
															  ->orWhere('subadmin1_code', $subadmin1_code);
													})->where('active', 1)->first();
										if (isset($cityA->id) && $cityA->id!='') {
											$city_id = $cityA->id;
										}else{
											$errorA[] = "($key) City Not exists (".trim($country).'->'.trim($region).'->'.trim($city).')';
										}
									}else{
										$errorA[] = "($key) Region Not exists (".trim($country).'->'.trim($region).')';
									}
								}else{
									$errorA[] = "($key) Country Not exists (".trim($country).')';
								}
								
								if($category_id>0 && $city_id>0){
									$extraA['email'] = $email;
									$business_info[] = array(
										'country_code' => $country_code,
										'user_id' => 1,
										'category_id' => $category_id,
										'title' => $name,
										'description' => $description,
										'title_ar' => $name_ar,
										'description_ar' => $description_ar,
										'phone' => $phone,
										'web' => $web,
										'extra_info' => serialize($extraA),
										'address1' => $address,
										'zip' => $zip,
										'lat' => $lat,
										'lon' => $lon,
										'imgFolder' => $imgFolder,
										'img1' => trim($img1),
										'img2' => trim($img2),
										'img3' => trim($img3),
										'city_id' => $city_id,
										'subadmin1_code' => $subadmin1_code,
										'active' => 1,
									);
									//print_r($business_info);exit;
								}else{
									$error = 1;
								}
							}
						}
						if($error == 0 && sizeof($business_info)>0){
							foreach($business_info as $key => $bizInfo){
								// Save Business to database
								$business = new Business($bizInfo);
								$business->save();
								
								$locationNew				=	new BusinessLocation();
								$locationNew->biz_id		=	$business->id;
								$locationNew->address_1 	= 	$bizInfo['address1'];
								$locationNew->phone 		= 	$bizInfo['phone'];
								$locationNew->country_id 	= 	$bizInfo['country_code'];
								$locationNew->location_id 	= 	$bizInfo['subadmin1_code'];
								$locationNew->city_id 		= 	$bizInfo['city_id'];
								$locationNew->zip_code 		= 	$bizInfo['zip'];
								$locationNew->lat 			= 	$bizInfo['lat'];
								$locationNew->lon 			= 	$bizInfo['lon'];
								$locationNew->active 		= 	1;
								$locationNew->base 			= 	0;
								$locationNew->save();
								
								//echo "<br /><br />Name =".$bizInfo['title'];
								//BOF Image Upload code
								$tempPath = 'uploads/temp/'.$bizInfo['imgFolder']; // temp path
								$destinationPath = 'uploads/pictures/business'; // upload path
								//echo "<br />base_path=".base_path($tempPath.'/'.$bizInfo['img1']);
								if (File::exists(base_path($tempPath.'/'.$bizInfo['img1']))){
									$extension = File::extension(base_path($tempPath.'/'.$bizInfo['img1'])); // getting file extension
									$fileName = time().rand(10,99).rand(100,999).rand(10,99).'1.'.$extension; // renameing image
									//echo "<br /><img src='".url($tempPath.'/'.$bizInfo['img1'])."' width='100' />";
									//echo "<br />".base_path($tempPath.'/'.$bizInfo['img1']).'=>'. base_path($destinationPath.'/'.$fileName);
									if (File::move(base_path($tempPath.'/'.$bizInfo['img1']), base_path($destinationPath.'/'.$fileName))){
										$picture = new BusinessImage;
										$picture->biz_id	= $business->id;
										$picture->filename	= $destinationPath.'/'.$fileName;
										$picture->active	= 1;
										$picture->save();
									}
								}
								//echo "<br />base_path=".base_path($tempPath.'/'.$bizInfo['img2']);
								if (File::exists(base_path($tempPath.'/'.$bizInfo['img2']))){
									$extension = File::extension(base_path($tempPath.'/'.$bizInfo['img2'])); // getting file extension
									$fileName = time().rand(10,99).rand(100,999).rand(10,99).'2.'.$extension; // renameing image
									//echo "<br /><img src='".url($tempPath.'/'.$bizInfo['img2'])."' width='100' />";
									//echo "<br />".base_path($tempPath.'/'.$bizInfo['img2']).'=>'. base_path($destinationPath.'/'.$fileName);
									if (File::move(base_path($tempPath.'/'.$bizInfo['img2']), base_path($destinationPath.'/'.$fileName))){
										$picture = new BusinessImage;
										$picture->biz_id	= $business->id;
										$picture->filename	= $destinationPath.'/'.$fileName;
										$picture->active	= 1;
										$picture->save();
									}
								}
								//echo "<br />base_path=".base_path($tempPath.'/'.$bizInfo['img3']);
								if (File::exists(base_path($tempPath.'/'.$bizInfo['img3']))){
									$extension = File::extension(base_path($tempPath.'/'.$bizInfo['img3'])); // getting file extension
									$fileName = time().rand(10,99).rand(100,999).rand(10,99).'3.'.$extension; // renameing image
									//echo "<br /><img src='".url($tempPath.'/'.$bizInfo['img3'])."' width='100' />";
									//echo "<br />".base_path($tempPath.'/'.$bizInfo['img3']).'=>'. base_path($destinationPath.'/'.$fileName);
									if (File::move(base_path($tempPath.'/'.$bizInfo['img3']), base_path($destinationPath.'/'.$fileName))){
										$picture = new BusinessImage;
										$picture->biz_id	= $business->id;
										$picture->filename	= $destinationPath.'/'.$fileName;
										$picture->active	= 1;
										$picture->save();
									}
								}
								//sleep(1);
								File::deleteDirectory($tempPath);
								//EOF Image Upload code
							}
							return Redirect::to('admin/business');
						}else{
							return Redirect::to('admin/business')->withErrors($errorA);
						}
					}
				}
			}
		}
	}
	
	public function upload_business_csv1()
	{
		
		$error     = '';
		$rules     = ['Upload_file' => 'required|mimes:csv,xls,xlsx,xl,txt' ];
	    $file      = Request::all();
	    $validator = Validator::make($file,$rules);
	    if( $validator->fails())
	    {
			 return Redirect::to('admin/category')->withErrors($validator->errors());
		}
		else
		{
			if( $error =="")
			{
				if(Input::hasFile('Upload_file')){
					
					ini_set('memory_limit', '-1');
					//$file = Input::file('Upload_file');
					//$name = time() . '-' . $file->getClientOriginalName();
					// Moves file to folder on server
					//$path = $file->move(public_path() . '/uploads/CSV', $name);
					$path = '/home/howlik/public_html/demo/uploads/CSV/1498200961-vin2.xls';
					$data = Excel::load($path, function($reader) {
					})->get()->toArray();
					
					//unlink($path);
					/*echo "<pre>";
					print_r($data);
					exit;
					[category] => Shopping
					[name] => Al Rais Shopping Centre
					[po_box] => P.O.Box: 945
					[city] => Dubai
					[country] => United Arab Emirates
					[contact_number] => alraisct@emirates.net.ae
					[web] => */
					if(isset($data) && sizeof($data)>0){
						
						foreach ($data as $key => $value) {
							
							$type = '';
							$depth = 2;
							if($key>=0){
								
								$category		= '';
								$name			= '';
								$address		= '';
								$phone			= '';
								$fax			= '';
								$email			= '';
								$web			= '';
								$description	= '';
								$city			= '';
								$country		= 'AE';
								$zip			= '';
								if(isset($value['category'])){ 
									$category		= trim($value['category']);
								}
								if(isset($value['name'])){
									$name		= trim($value['name']);
								}
								if(isset($value['po_box'])){
									$address		= trim($value['po_box']);
								}
								if(isset($value['city'])){
									$city		= trim($value['city']);
								}
								
								if(isset($value['contact_number'])){
									if(strpos($value['contact_number'], '@')){
										$email	= trim($value['contact_number']);
									}elseif(strpos($value['contact_number'], 'ww.')){
										$web	= trim($value['contact_number']);
									}else{
										$phone	= trim($value['contact_number']);
									}
								}
								
								if(isset($value['web'])){
									if(strpos($value['web'], '@')){
										$email	= trim($value['web']);
									}else{
										$web	= trim($value['web']);
									}
								}
								
								$cat = new Catcsv();
								
								$cat->category 	= $category;
								$cat->name 		= $name;
								$cat->address 	= $address;
								$cat->phone 	= $phone;
								$cat->fax 		= $fax;
								$cat->email 	= $email;
								$cat->web 		= $web;
								$cat->description = $description;
								$cat->city 		= $city;
								$cat->country 	= $country;
								$cat->zip 		= $zip;
								$cat->fetch_time = 2;
								$cat->save();
							}
						}
						return Redirect::to('admin/business');
					}
				}
			}
		}
	}
}
