<?php

namespace App\Http\Controllers\Admin;

use App\Larapen\Models\Category;
use App\Larapen\Models\Country;
use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\City;
use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessOffer;
use App\Larapen\Models\OfferType;
use App\Larapen\Models\Review;

use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\BusinessRequest as StoreRequest;
use App\Http\Requests\Admin\BusinessRequest as UpdateRequest;
use Request;
use DB;

class BusinessController extends CrudController
{
    public $crud = array(
    
        "model" => "App\Larapen\Models\Business",
        "entity_name" => "Business Listing",
        "entity_name_plural" => "Business Listings",
        "route" => "admin/business",
        "reorder" => false,
        "add_permission" => true,
        "biz" => 1,
        
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
                'label' => "Business Owner",
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
				'type' => 'hidden'
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
				'label' => "Map Position",
				'name' => 'google_map',
				'type' => 'google_map',
			],
			[
				'label'=> "Offers & Discounts",
				'name' => 'id',
				'type' => 'biz_offers',
			],
			[
				'name' => 'lat',
				'type' => 'hidden',
			],
			[
				'name' => 'lon',
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
				$request->merge(array($field['name'] => serialize($request->get($field['name']))));
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
				$request->merge(array($field['name'] => serialize($request->get($field['name']))));
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
		
		// Save New Business Offer Details into database on admin side
		$offer	=	BusinessOffer::where('biz_id', Request::get('biz_id')) 
					->where('offertype', Request::get('type'))
					->where('percent', Request::get('percent')) 
					->where('content', Request::get('content'))
					->first(); 
					
		if(empty($offer) && Request::has('biz_id'))
		{
			$offersNew				=	new BusinessOffer();
			$offersNew->biz_id		=	Request::get('biz_id');
			$offersNew->offertype 	= 	Request::get('type');
			$offersNew->percent 	= 	Request::get('percent');
			$offersNew->content 	= 	Request::get('content');
			$offersNew->details 	= 	Request::get('details');
			$offersNew->active 		= 	1;
			$offersNew->save();
			return 1;
			
		} else {
			return 0;
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
}
