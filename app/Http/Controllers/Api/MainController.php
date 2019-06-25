<?php

	namespace App\Http\Controllers\Api;
	use App\Http\Controllers\Controller;

	use DB;
	use URL;
	use Auth;
	use Mail;
	use Hash;
	use Session;
	use Carbon\Carbon;
	use Input;
	use Illuminate\Pagination\Paginator;
	
	use App\Larapen\Helpers\Ip;
	use App\Larapen\Helpers\Curl;
	use App\Larapen\Helpers\Rules;
	
	use Illuminate\Support\Collection;
	use Illuminate\Support\Facades\View;
	
	use Illuminate\Support\Facades\Event;
	use Illuminate\Support\Facades\Password;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Http\Request as HttpRequest;
	use Illuminate\Support\Facades\Request as Request;
	
	use Torann\LaravelMetaTags\Facades\MetaTag;
	use Larapen\CountryLocalization\Helpers\Country;
	use Larapen\CountryLocalization\Facades\CountryLocalization;
	
	use App\Larapen\Models\Ad;
	use App\Larapen\Models\User;
	use App\Larapen\Models\Gender;
	use App\Larapen\Models\Review;
	use App\Larapen\Models\UserType;
	use App\Larapen\Models\Eventnew;
	use App\Larapen\Models\Business;
	use App\Larapen\Models\PaypalLog;
	use App\Larapen\Models\EventTicket;
	use App\Larapen\Models\UserLocation;
	use App\Larapen\Models\BusinessOffer;
	use App\Larapen\Models\BusinessScam;
	use App\Larapen\Models\BusinessImage;
	use App\Larapen\Models\GiftRecipient;
	use App\Larapen\Models\GiftCertificate;
	use App\Larapen\Models\BusinessBooking;
	use App\Larapen\Models\NotifAll;
	use App\Larapen\Models\BusinessLocation;
	use App\Larapen\Models\BusinessBookingOrder;
	use App\Larapen\Models\BusinessBookingTmSettings;
	use App\Larapen\Models\BusinessBookingTblSettings;
	use App\Larapen\Models\GoogleSearchModel;
	use App\Larapen\Models\GoogleSearchIdsModel;
	use App\Larapen\Models\Category;
	use App\Larapen\Models\Country as CountryModel;
	use App\Larapen\Models\CategoryGoogleTypeModel;
	
	// use App\Larapen\Events\EventWasPosted;
	use App\Larapen\Events\BusinessWasPosted;
	use App\Larapen\Events\SendMessage;
	
	class MainController extends Controller {
		
		/**
		 * Get the Dashboard.
		 *
		 * @return Response
		 */
		public function GetDashboard(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			/* $data['alerts'] = 'invalid credential.'; */
			$user			= User::where('api_key', $request->input('apikey'))->first();
			/* if( count($user) ) { */
				
				$country_code		=	'';
				$language_code		=	'en';
				$circle_radius 		= 	3959;
				$max_distance 		= 	20;
				$latitude			=	'';
				$longitude			=	'';
				
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				if( $request->has('latitude') ) {
					$latitude		=	$request->input('latitude');
				}
				if( $request->has('longitude') ) {
					$longitude		=	$request->input('longitude');
				}
				
				/*if( $latitude && $longitude ) {
						
					$nearby 	= 	$circle_radius .' * acos(cos(radians(' . $latitude . ')) * cos(radians(lat)) *
									cos(radians(lon) - radians(' . $longitude . ')) +
									sin(radians(' . $latitude . ')) * sin(radians(lat)))';
					
					if( $language_code == 'ar' ) {
						$select = "business.id as biz_id, business.title_ar as biz_title, business.visits as biz_visits, business.created_at as biz_date, businessImages.filename as biz_image, cities.name as city_title, subadmin1.name as location_title";
					}	
					else {
						$select = "business.id as biz_id, business.title as biz_title, business.visits as biz_visits, business.created_at as biz_date, businessImages.filename as biz_image, cities.asciiname as city_title, subadmin1.asciiname as location_title";
					}												
					$coun_code	= "";						
					if( $country_code ) {
						$coun_code	= "AND business.country_code ='".$country_code."'";
					}
					
					$business	=	DB::select('
										SELECT * FROM
											(SELECT '.$select.',  ('.$nearby.')
												AS distance,
												COUNT(review.rating) as rating_count, 
												SUM(review.rating) as rating_value,
												COUNT(review.expense) as expense_count, 
												SUM(review.expense) as expense_value
												FROM business 
												LEFT JOIN cities ON business.city_id = cities.id
												LEFT JOIN subadmin1 ON business.subadmin1_code = subadmin1.code
												LEFT JOIN businessImages ON business.id = businessImages.biz_id
												LEFT JOIN review ON business.id = review.biz_id
												WHERE business.active = 1 '.$coun_code.' GROUP BY biz_id ORDER BY distance ASC
											) AS distances
										;
									');
					
					if( count($business) ) {
						foreach( $business as $values ) {
							if( $values->distance ) {
								$values->distance	=	round($values->distance);
							}
						}
					}
				}
				else {
					$business			= 	DB::table('business');
					if( $language_code == 'ar' ) {
						$business		= 	$business->select('business.id as biz_id', 'business.title_ar as biz_title', 'business.visits as biz_visits','business.created_at as biz_date','businessImages.filename as biz_image', 'cities.name as city_title', 'subadmin1.name as location_title', DB::raw("COUNT(review.rating) as rating_count"), DB::raw("SUM(review.rating) as rating_value"), DB::raw("COUNT(review.expense) as expense_count"), DB::raw("SUM(review.expense) as expense_value"));
					}	
					else {
						$business		= 	$business->select('business.id as biz_id', 'business.title as biz_title', 'business.visits as biz_visits', 'business.created_at as biz_date','businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title', DB::raw("COUNT(review.rating) as rating_count"), DB::raw("SUM(review.rating) as rating_value"), DB::raw("COUNT(review.expense) as expense_count"), DB::raw("SUM(review.expense) as expense_value"));
					}					
					$business			= 	$business->leftjoin('cities','business.city_id', '=', 'cities.id')												->leftjoin('subadmin1','business.subadmin1_code', '=', 'subadmin1.code')												->leftjoin('businessImages','business.id', '=', 'businessImages.biz_id')												->leftjoin('review','business.id', '=', 'review.biz_id');						if( $country_code ) {							$business		= 	$business->where('business.country_code', '=', $country_code);						}						$business			= 	$business->where('business.active', 1)->groupBy('business.id')->orderBy('business.visits', 'desc')->get();
				}
				if( count($business) ) {
					foreach( $business as $values ) {
						if( $values->biz_title ) {
							$values->biz_title	=	ucwords($values->biz_title);
						}
						if( $values->biz_date ) {
							$values->biz_date	=	date("jS F Y h:i A", strtotime($values->biz_date));
						}
						if( !$values->biz_image ) {
							$values->biz_image	=	'uploads/pictures/no-image.jpg';
						}
						$values->rating			=	0;
						$values->expense		=	0;
						if( $values->rating_count ) {
							$values->rating		=	$values->rating_value / $values->rating_count;
						}
						if( $values->expense_count ) {
							$values->expense	=	$values->expense_value / $values->expense_count;
						}
						unset($values->rating_count);
						unset($values->rating_value);
						unset($values->expense_count);
						unset($values->expense_value);
					}
				}
				*/
				$data['business']	= 	array();//$business;
										
				$category			= 	DB::table('categories')
										->select('translation_of as code', 'name')
										->where('categories.translation_lang', '=', $language_code)
										->where('categories.active', 1)
										->where('categories.parent_id', 0)
										->orderBy('categories.name', 'asc')
										->get();
				
				if( count($category) ) {
					foreach( $category as $values ) {
						if( $values->name ) {
							$filename		=	str_replace("&_", "", str_replace(" ", "_", strtolower($values->name)));
							$values->icon	=	'uploads/Category/icons/'.$filename.'.png';
						}
					}
				}
				
				$country			=	DB::table('countries');
				if( $language_code == 'ar' ) {
					$country		=	$country->select('name as title', 'code');
				}
				else {
					$country		=	$country->select('asciiname as title', 'code');
				}
				$country			=	$country->where('active', 1)->get();
				/* $data['country']	=	$country; */
				
				$data['category']	= 	$category;
				$currency 			= 	DB::table('countries')
										->select('currencies.code', 'currencies.html_entity')
										->leftjoin('currencies', 'countries.currency_code', '=', 'currencies.code')
										->where('countries.code', '=', $country_code)
										->first();
				
				$data['country_code']	= 	$country_code;
				$data['language_code']	= 	$language_code;
				if( count($currency) ) {
					$data['currency_code']	= 	$currency->code;
					$data['currency_icon']	= 	$currency->html_entity;
				}
				
				$data['profile']	= 	$user;
										
				$data['status']		= 	'success';
				/* unset($data['alerts']); */
				
			/* } */
			return json_encode($data);
		}
		
		/**
		 * Get the edit profile page.
		 *
		 * @return Response
		 */
		public function GetProfile(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$data['status'] 	= 'success';
				
				if( $user->photo ) {
					$user->photo	= 'uploads/pictures/dp/'.$user->photo;
				}
				else {
					$user->photo	= 'uploads/pictures/dp/demo.jpg';
				}
				
				$data['profile']	= $user;
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
						
				$countries 	= \DB::table('countries');
				if( $language_code == 'ar' ) {
					$countries = $countries->select('code', 'name as title');
				}
				else {
					$countries = $countries->select('code', 'asciiname as title');
				}
				$countries	= $countries->where('active', 1)->get();
				
				$data['countries'] 	= $countries;
				$data['genders'] 	= Gender::select('translation_of', 'name')->where('translation_lang', $language_code)->get();
				$data['usertypes'] 	= UserType::select('id', 'name')->where('active', 1)->get();
				
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Post the edit profile form.
		 *
		 * @return Response
		 */
		public function PostProfile(HttpRequest $request) {
			
			$data 			= [];
			$data['status']	= 'error';
			$data['alerts']	= 'invalid credential.';
			$user 			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$info = array(
					'country_code'	=> $request->input('country'),
					'gender_id'		=> $request->input('gender'),
					'name'			=> $request->input('name'),
					'phone'			=> $request->input('phone'),
					'email'			=> $request->input('email'),
					'about'			=> $request->input('about'),
				);
				$user->update($info);
				
				$data['status']	= 'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Post the profile picture upload.
		 *
		 * @return Response
		 */
		public function UploadProfilePicture(HttpRequest $request) {
			
			$data 			= [];
			$data['status']	= 'error';
			$data['alerts']	= 'invalid credential.';
			$user 			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->hasFile('file') ) {
					
					$file			=	$request->file('file');
					$name			=	$file->getClientOriginalName();
					
					$destination	=	public_path().'/uploads/pictures/dp';
					$extension		= 	$file->getClientOriginalExtension();
					$filename		=	time().'.'.$extension;
					$file->move($destination, $filename);
					
					if( $user->update([ 'photo' => $filename ]) ) {
						$data['status']	= 	'success';
						unset($data['alerts']);
					}
					else {
						unset($data['alerts']);
					}
				}
				else {
					$data['alerts'] = 'file required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the Own Events.
		 *
		 * @return Response
		 */
		public function GetOwnEvent(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {

				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$events				= 	DB::table('events');
				if( $language_code == 'ar' ) {
					$events			=	$events->select('events.*','cities.name as city_name');
				}
				else {
					$events			=	$events->select('events.*','cities.asciiname as city_name');
				}
				$events				=	$events->leftjoin('cities','events.event_place', '=', 'cities.id')
										->where('events.user_id', $user->id)->orderBy('events.created_at', 'desc')->get();
				
				if( count($events) ) {
					foreach( $events as $values ) {
						if( !$values->event_image1 ) {
							$values->event_image1	=	'uploads/pictures/no-image.jpg';
						}
						if( $values->event_place ) {
							$values->event_place_old		=	$values->event_place;
						}
						if( $values->event_place ) {
							$values->event_place		=	$values->city_name;
						}
						if( $values->event_date ) {
							$values->event_date		=	date("d-m-Y", strtotime($values->event_date));
						}
						if( $values->eventEnd_date ) {
							$values->eventEnd_date	=	date("d-m-Y", strtotime($values->eventEnd_date));
						}
						if( $values->event_starttime ) {
							$values->event_starttime =	date("h:i A", strtotime($values->event_starttime));
						}
						if( $values->event_endtime ) {
							$values->event_endtime	=	date("h:i A", strtotime($values->event_endtime));
						}
					}
				}
					
				$data['events']		= 	$events;						
				$data['status']		= 	'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Get the Upcoming Events.
		 *
		 * @return Response
		 */
		public function GetUpcomeEvent(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			/* $data['alerts'] = 'invalid credential.'; */
			if($request->has('apikey') && $request->input('apikey') !='')
			{
				$user			= User::where('api_key', $request->input('apikey'))->first();
				if( count($user) ) { 
					
					$country_code		=	$user->country_code;
					if( $request->has('country_code') ) {
						$country_code	=	$request->input('country_code');
					}
					$city_code			=	'';
					if( $request->has('city_code') ) {
						$city_code		=	$request->input('city_code');
					}
					
					$events				= 	DB::table('events')
											->select('events.*','cities.asciiname as city_name')
											->leftjoin('cities','events.event_place', '=', 'cities.id')
											->where('events.event_date', '>=', date('Y-m-d'));
											
					if( $country_code )	{					
						$events			= 	$events->where('events.country_code', '=', $country_code);
					}
											
					if( $city_code )	{					
						$events			= 	$events->where('events.event_place', '=', $city_code);
					}
					$events				=	$events->orderBy('events.event_date', 'asc')->get();

					if( count($events) ) {
						
						foreach( $events as $values ) {
							
							if( !$values->event_image1 ) {
								$values->event_image1	=	'uploads/pictures/no-image.jpg';
							}
							if( $values->event_date ) {
								$values->event_date		=	date("d-m-Y", strtotime($values->event_date));
							}
							if( $values->event_place ) {
							$values->event_place_old		=	$values->event_place;
							}
							if( $values->event_place ) {
								$values->event_place		=	$values->city_name;
							}
							if( $values->eventEnd_date ) {
								$values->eventEnd_date	=	date("d-m-Y", strtotime($values->eventEnd_date));
							}
							if( $values->event_starttime ) {
								$values->event_starttime =	date("h:i A", strtotime($values->event_starttime));
							}
							if( $values->event_endtime ) {
								$values->event_endtime	=	date("h:i A", strtotime($values->event_endtime));
							}
						}
					}
						
					$data['events']		= 	$events;						
					$data['status']		= 	'success';
					unset($data['alerts']); 
				 }
			}
			else 
			{
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
					
					$events				= 	DB::table('events')
											->select('events.*','cities.asciiname as city_name')
											->leftjoin('cities','events.event_place', '=', 'cities.id')
											->where('events.event_date', '>=', date('Y-m-d'))
											->where('events.country_code', '=', $country_code)
											->orderBy('events.event_date', 'asc')->get();
											
					if( count($events) ) {
						
						foreach( $events as $values ) {
							
							if( !$values->event_image1 ) {
								$values->event_image1	=	'uploads/pictures/no-image.jpg';
							}
							if( $values->event_date ) {
								$values->event_date		=	date("d-m-Y", strtotime($values->event_date));
							}
							if( $values->event_place ) {
							$values->event_place_old		=	$values->event_place;
							}
							if( $values->event_place ) {
								$values->event_place		=	$values->city_name;
							}
							if( $values->eventEnd_date ) {
								$values->eventEnd_date	=	date("d-m-Y", strtotime($values->eventEnd_date));
							}
							if( $values->event_starttime ) {
								$values->event_starttime =	date("h:i A", strtotime($values->event_starttime));
							}
							if( $values->event_endtime ) {
								$values->event_endtime	=	date("h:i A", strtotime($values->event_endtime));
							}
						}
					}						
					$data['events']		= 	 $events;
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else 
				{
					$data['alerts'] = 'country_code is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the Popular Events.
		 *
		 * @return Response
		 */
		public function GetPopularEvent(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			if($request->has('apikey') && $request->input('apikey') !='')
			{
				$user			= User::where('api_key', $request->input('apikey'))->first();
				if( count($user) ) {
				
				$country_code		=	$user->country_code;
				$city_code			=	'';
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				if( $request->has('city_code') ) {
					$city_code	=	$request->input('city_code');
				}
				
				$events				= 	DB::table('events')
										->select('events.*','cities.asciiname as city_name')
										->leftjoin('cities','events.event_place', '=', 'cities.id');
										
				if( $country_code )	{					
					$events			= 	$events->where('events.country_code', '=', $country_code);
				}
										
				if( $city_code )	{					
					$events			= 	$events->where('events.event_place', '=', $city_code);
				}
				$events				=	$events->orderBy('events.visits', 'desc')->get();
					
				if( count($events) ) {
					
					foreach( $events as $values ) {
						
						if( !$values->event_image1 ) {
							$values->event_image1	=	'uploads/pictures/no-image.jpg';
						}
						if( $values->event_date ) {
							$values->event_date		=	date("d-m-Y", strtotime($values->event_date));
						}
						if( $values->event_place ) {
							$values->event_place_old		=	$values->event_place;
						}
						if( $values->event_place ) {
							$values->event_place		=	$values->city_name;
						}
						if( $values->eventEnd_date ) {
							$values->eventEnd_date	=	date("d-m-Y", strtotime($values->eventEnd_date));
						}
						if( $values->event_starttime ) {
							$values->event_starttime =	date("h:i A", strtotime($values->event_starttime));
						}
						if( $values->event_endtime ) {
							$values->event_endtime	=	date("h:i A", strtotime($values->event_endtime));
						}
					}
				}	
				$data['events']		= 	$events;
				$data['status']		= 	'success';
				unset($data['alerts']);
				
			 }
			}
			else {
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
					$events				= 	DB::table('events')
										    ->select('events.*','cities.asciiname as city_name')
										    ->leftjoin('cities','events.event_place', '=', 'cities.id')
											->where('events.country_code', '=', $country_code)
											->orderBy('events.visits', 'desc')->get();
										
					if( count($events) ) {
					
						foreach( $events as $values ) {
							
							if( !$values->event_image1 ) {
								$values->event_image1	=	'uploads/pictures/no-image.jpg';
							}
							if( $values->event_place ) {
							$values->event_place_old		=	$values->event_place;
							}
							if( $values->event_place ) {
								$values->event_place		=	$values->city_name;
							}
							if( $values->event_date ) {
								$values->event_date		=	date("d-m-Y", strtotime($values->event_date));
							}
							if( $values->eventEnd_date ) {
								$values->eventEnd_date	=	date("d-m-Y", strtotime($values->eventEnd_date));
							}
							if( $values->event_starttime ) {
								$values->event_starttime =	date("h:i A", strtotime($values->event_starttime));
							}
							if( $values->event_endtime ) {
								$values->event_endtime	=	date("h:i A", strtotime($values->event_endtime));
							}
						}
					}						
					$data['events']		= 	 $events;
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else 
				{
					$data['alerts'] = 'country_code is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the Event by id.
		 *
		 * @return Response
		 */
		public function GetSingleEvent(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			/* $user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) { */
				
				if( $request->has('event_id') ) {
					
					$events	= 	DB::table('events')
								->select('events.*', 'cities.asciiname as city_name')
								->leftjoin('cities','events.event_place', '=', 'cities.id')
								->where('events.id', $request->input('event_id'))->first();
					
					if( count($events) ) {
						if( $events->ticket_details ) {
							$arrays	=	unserialize($events->ticket_details);
							if( count($arrays) ) {
								
								if( array_key_exists("tickets", $arrays) ) {
									$events->ticket_count	=	$arrays['tickets'];
								}
								if( array_key_exists("price", $arrays) ) {
									$events->ticket_price	=	$arrays['price'];
								}
								if( array_key_exists("currency", $arrays) ) {
									$events->currency_code	=	$arrays['currency'];
								}
							}
						}
						if( !$events->event_image1 ) {
							$events->event_image1	=	'uploads/pictures/no-image.jpg';
						}
						if( $events->event_date ) {
							$events->event_date	=	date('d-m-Y', strtotime($events->event_date));
						}
						if( $events->event_starttime ) {
							$events->event_starttime	=	date('h:i A', strtotime($events->event_starttime));
						}
						if( $events->eventEnd_date ) {
							$events->eventEnd_date	=	date('d-m-Y', strtotime($events->eventEnd_date));
						}
						if( $events->event_endtime ) {
							$events->event_endtime	=	date('h:i A', strtotime($events->event_endtime));
						}
						
						$data['events']		= 	$events;						
						$data['status']		= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'event not found.';
					}
				}
				else {
					$data['alerts'] = 'event id required.';
				}
			//}
			return json_encode($data);
		}
		
		/**
		 * Get the All Business.
		 *
		 * @return Response
		 */
		
		public function arrayPaginator($array, $request)
		{
			$page    = Input::get('page',1);
			$perPage = 20;
			$offset  = ($page * $perPage) - $perPage;

		  $lap = new \Illuminate\Pagination\LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
				['path' => $request->url(), 'query' => $request->query()]);
		  return (object)[
				'current_page' => $lap->currentPage(),
				'data' => $lap->values(),
				'first_page_url' => $lap->url(1),
				'from' => $lap->firstItem(),
				'last_page' => $lap->lastPage(),
				'last_page_url' => $lap->url($lap->lastPage()),
				'next_page_url' => $lap->nextPageUrl(),
				'per_page' => $lap->perPage(),
				'prev_page_url' => $lap->previousPageUrl(),
				'to' => $lap->lastItem(),
				'total' => $lap->total(),
			];
				
		}
		
		public function GetBusinessAllT(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			/* $data['alerts'] = 'invalid credential.'; */
			$user			= User::where('api_key', $request->input('apikey'))->first();
			/* if( count($user) ) { */
				
				$country_code		=	'';
				$city_code			=	'';
				$language_code		=	'en';
				$circle_radius 		= 	3959;
				$max_distance 		= 	20;
				$latitude			=	'';
				$longitude			=	'';
				$keyword			=	'';
				$sCat 				= 	'';
				$sCatId 			= 	'';
				$city_id			=	'';
				$srhWhere			= 	'';
				$srhWhereCountry	= 	'';
				
				if( $request->has('country_code') ) {
					$country_codeR	=	$request->input('country_code');
					$countryA = CountryModel::where('code', $country_codeR)->first();
					if(isset($countryA->code) && trim($countryA->code)!=''){
						$country_code = $countryA->code;
						$srhWhereCountry = " AND business.country_code='".$country_code."' ";
					}
				}
				
				if($request->has('language_code') && $request->input('language_code')!='' && $request->input('language_code')!='null') {
					$language_code	=	$request->input('language_code');
				}
				
				if( $request->has('city_code') ) {
					$city_code		=	$request->input('city_code');
				}
				
				if( $request->has('city_code') ) {
					$city_code		=	$request->input('city_code');
				}
				
				if( $request->has('latitude') ) {
					$latitude		=	$request->input('latitude');
				}
				if( $request->has('longitude') ) {
					$longitude		=	$request->input('longitude');
				}
				if( $request->has('q') ) {
					$keyword		=	$request->input('q');
				}
					
				if( $latitude && $longitude && $latitude!='' && $longitude!='') {
					$bTitle = 'business.title';
					if($language_code=='ar'){
						$bTitle = 'business.title_ar';
					}
		
					if( $request->has('category_id') ) {
						$arCat = Category::where('translation_lang', $language_code)->where('translation_of',(int)$request->input('category_id'))->orderBy('lft')->first();
						if(isset($arCat->id) && $arCat->id>0){
							$sCat	= $arCat->name;
							$sCatId	= $arCat->translation_of;
							$srhWhere .= " AND business.category_id='".$arCat->id."'";
							
							if(trim($keyword)==''){
								//$keyword = $sCat;
							}
						}
					}
					if(trim($keyword)!='' || $sCatId>0){
						$gData['lat'] = $latitude;
						$gData['lng'] = $longitude;
						$gData['c_code'] = $country_code;
						$gData['cat'] = $sCat;
						$gData['cat_id'] = $sCatId;
						$gData['city_id'] = $city_id;
						$gData['img'] = 'yes';
						$gData['keyword'] = trim($keyword);
						
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
						
						$sKeyword 		  = addslashes(trim($keyword));
						$keyCatA = array();
						if(trim($keyword)!==''){
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
						
						if(is_array($searchIdA) && count($searchIdA)>0){
							$gIds = GoogleSearchIdsModel::select('googleId')->whereIn('searchId', $searchIdA)->get()->toArray();
						}else{
							$gIds = GoogleSearchIdsModel::select('googleId')->where('searchId', $searchId)->get()->toArray();
						}
						$gIdsA = array_column($gIds, 'googleId');
						if(count($gIdsA)>0){
							$srhWhere .= " OR (business.active='1' ".$srhWhereCountry." AND business.googleId IN ('".implode("','", $gIdsA)."')) ";
						}
					}						
					$nearby 	= 	$circle_radius .' * acos(cos(radians(' . $latitude . ')) * cos(radians(business.lat)) *
									cos(radians(business.lon) - radians(' . $longitude . ')) +
									sin(radians(' . $latitude . ')) * sin(radians(business.lat)))';
					
					if( $language_code == 'ar' ) {
						$select = "business.id as biz_id, business.title_ar as biz_title, business.visits as biz_visits, business.created_at as biz_date, cities.name as city_title, subadmin1.name as location_title";
					}	
					else {
						$select = "business.id as biz_id, business.title as biz_title, business.visits as biz_visits, business.created_at as biz_date, cities.asciiname as city_title, subadmin1.asciiname as location_title";
					}
				
					$srchQuery = '';
					if($keyword!=''){
						$srchQuery = ' (business.title LIKE \'%'.$keyword.'%\' OR business.description LIKE \'%'.$keyword.'%\') AND';
					}

					$business	=	DB::select('SELECT business.lat,business.lon ,'.$select.',  ('.$nearby.')
												AS distance,
												n.rating_count,n.rating_value,n.expense_count,n.expense_value,
												(SELECT bi.filename FROM businessImages as bi WHERE bi.biz_id=business.id AND bi.active=1 LIMIT 1) as biz_image 
												FROM business 
												LEFT JOIN cities ON business.city_id = cities.id
												LEFT JOIN subadmin1 ON business.subadmin1_code = subadmin1.code
												LEFT JOIN (
													SELECT biz_id, COUNT(review.rating) as rating_count, 
														SUM(review.rating) as rating_value,
														COUNT(review.expense) as expense_count, 
														SUM(review.expense) as expense_value
														FROM review GROUP BY biz_id
												
												) AS n ON business.id = n.biz_id
												WHERE business.active=1 '.$srhWhereCountry.' '.$srhWhere.' 
												HAVING distance < 10 ORDER BY distance
									'); 
					//$delArr = array();
					if( count($business) ) {
						foreach( $business as $key => $values ) {
							if( $values->distance ) {
								//Edited On 03-05-2018  
								//$values->distance	=	round($values->distance);
								//NEW MILES TO KM
								$values->miles	    =	$values->distance;
								$values->distance_k	=	round($values->distance * 1.609);
								$values->distance   =	round($values->distance * 1609.344);
								//$values->distance_k	=	round($this->distance($values->lat, $values->lon,$latitude, $longitude, "K"));
							}
							
							//BOF UNLINKING Latitude = 0 and Longitude =0 Businesses
							if((trim($values->lat)==0) || (trim($values->lat)=='')){
								unset($business[$key]);
							}
							if((trim($values->lon)==0) || (trim($values->lon)=='')){
								unset($business[$key]);
							}
						}
						
						$business = array_values(array_filter($business)); 
						//EOF 
					}
				}
				else {
					$business			= 	DB::table('business');
					if( $language_code == 'ar' ) {
						$business		= 	$business->select('business.id as biz_id', 'business.title_ar as biz_title', 'business.visits as biz_visits','business.created_at as biz_date','businessImages.filename as biz_image', 'cities.name as city_title', 'subadmin1.name as location_title', DB::raw("COUNT(review.rating) as rating_count"), DB::raw("SUM(review.rating) as rating_value"), DB::raw("COUNT(review.expense) as expense_count"), DB::raw("SUM(review.expense) as expense_value"));
					}	
					else {
						$business		= 	$business->select('business.id as biz_id', 'business.title as biz_title', 'business.visits as biz_visits', 'business.created_at as biz_date','businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title', DB::raw("COUNT(review.rating) as rating_count"), DB::raw("SUM(review.rating) as rating_value"), DB::raw("COUNT(review.expense) as expense_count"), DB::raw("SUM(review.expense) as expense_value"));
					}					
					$business			= 	$business->leftjoin('cities','business.city_id', '=', 'cities.id')
											->leftjoin('subadmin1','business.subadmin1_code', '=', 'subadmin1.code')
											->leftjoin('businessImages','business.id', '=', 'businessImages.biz_id')
											->leftjoin('review','business.id', '=', 'review.biz_id');
					if( $request->has('category_id') ) {
						$business		=	$business->where('business.category_id', $request->input('category_id'));
					}
					if( $country_code ) {	
						$business		= 	$business->where('business.country_code', '=', $country_code);
					}
					if($keyword!=''){
						$business		= 	$business->where( function($query) use($keyword){
							$query->where('business.title', 'LIKE', "%$keyword%");
							$query->orWhere('business.description', 'LIKE', "%$keyword%"); 
						});
					}
					$business		= 	$business->where('business.active', 1)
													->groupBy('business.id')
													->orderBy('business.visits', 'desc')
													->get();
													//->paginate(20);
						
				}
				
				if( count($business) ) {
					foreach( $business as $values ) {
						if( $values->biz_title ) {
							$values->biz_title	=	ucwords($values->biz_title);
						}
						if( $values->biz_date ) {
							$values->biz_date	=	date("jS F Y h:i A", strtotime($values->biz_date));
						}
						if( !$values->biz_image ) {
							$values->biz_image	=	'uploads/pictures/no-image.jpg';
						}
						$values->rating			=	0;
						$values->expense		=	0;
						if( $values->rating_count ) {
							$values->rating		=	$values->rating_value / $values->rating_count;
						}
						if( $values->expense_count ) {
							$values->expense	=	$values->expense_value / $values->expense_count;
						}
						unset($values->rating_count);
						unset($values->rating_value);
						unset($values->expense_count);
						unset($values->expense_value);
					}
				}
				
				   if($request->has('page') && $request->input('page')!='') {
						$page 	  = $request->input('page');
						$business =  $this->arrayPaginator($business, $request);  
					}
				
				$data['business']	= 	$business;
				$data['status']		= 	'success';
				
				/* unset($data['alerts']);*/ 
				
			/* } */
			return json_encode($data);
		}
		
		public function GetBusinessAll(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			/* $data['alerts'] = 'invalid credential.'; */
			$user			= User::where('api_key', $request->input('apikey'))->first();
			/* if( count($user) ) { */
				
				$country_code		=	'';
				$city_code			=	'';
				$language_code		=	'en';
				$circle_radius 		= 	3959;
				$max_distance 		= 	20;
				$latitude			=	'';
				$longitude			=	'';
				$keyword			=	'';
				$sCat 				= 	'';
				$sCatId 			= 	'';
				$city_id			=	'';
				$srhWhere			= 	'';
				$srhWhereCountry	= 	'';
				
				if( $request->has('country_code') ) {
					$country_codeR	=	$request->input('country_code');
					$countryA = CountryModel::where('code', $country_codeR)->first();
					if(isset($countryA->code) && trim($countryA->code)!=''){
						$country_code = $countryA->code;
						$srhWhereCountry = " AND business.country_code='".$country_code."' ";
					}
				}
				
				if($request->has('language_code') && $request->input('language_code')!='' && $request->input('language_code')!='null') {
					$language_code	=	$request->input('language_code');
				}
				
				if( $request->has('city_code') ) {
					$city_code		=	$request->input('city_code');
				}
				
				if( $request->has('city_code') ) {
					$city_code		=	$request->input('city_code');
				}
				
				if( $request->has('latitude') ) {
					$latitude		=	$request->input('latitude');
				}
				if( $request->has('longitude') ) {
					$longitude		=	$request->input('longitude');
				}
				if( $request->has('q') ) {
					$keyword		=	$request->input('q');
				}
					
				if( $latitude && $longitude && $latitude!='' && $longitude!='') {
					$bTitle = 'business.title';
					if($language_code=='ar'){
						$bTitle = 'business.title_ar';
					}
		
					if( $request->has('category_id') ) {
						$arCat = Category::where('translation_lang', $language_code)->where('translation_of',(int)$request->input('category_id'))->orderBy('lft')->first();
						if(isset($arCat->id) && $arCat->id>0){
							$sCat	= $arCat->name;
							$sCatId	= $arCat->translation_of;
							$srhWhere .= " AND business.category_id='".$arCat->id."'";
							
							if(trim($keyword)==''){
								//$keyword = $sCat;
							}
						}
					}
					if(trim($keyword)!='' || $sCatId>0){
						$gData['lat'] = $latitude;
						$gData['lng'] = $longitude;
						$gData['c_code'] = $country_code;
						$gData['cat'] = $sCat;
						$gData['cat_id'] = $sCatId;
						$gData['city_id'] = $city_id;
						$gData['img'] = 'yes';
						$gData['keyword'] = trim($keyword);
						
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
						
						$sKeyword 		  = addslashes(trim($keyword));
						$keyCatA = array();
						if(trim($keyword)!==''){
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
						
						if(is_array($searchIdA) && count($searchIdA)>0){
							$gIds = GoogleSearchIdsModel::select('googleId')->whereIn('searchId', $searchIdA)->get()->toArray();
						}else{
							$gIds = GoogleSearchIdsModel::select('googleId')->where('searchId', $searchId)->get()->toArray();
						}
						$gIdsA = array_column($gIds, 'googleId');
						if(count($gIdsA)>0){
							$srhWhere .= " OR (business.active='1' ".$srhWhereCountry." AND business.googleId IN ('".implode("','", $gIdsA)."')) ";
						}
					}						
					$nearby 	= 	$circle_radius .' * acos(cos(radians(' . $latitude . ')) * cos(radians(business.lat)) *
									cos(radians(business.lon) - radians(' . $longitude . ')) +
									sin(radians(' . $latitude . ')) * sin(radians(business.lat)))';
					
					if( $language_code == 'ar' ) {
						$select = "business.id as biz_id, business.title_ar as biz_title, business.visits as biz_visits, business.created_at as biz_date, cities.name as city_title, subadmin1.name as location_title";
					}	
					else {
						$select = "business.id as biz_id, business.title as biz_title, business.visits as biz_visits, business.created_at as biz_date, cities.asciiname as city_title, subadmin1.asciiname as location_title";
					}
				
					$srchQuery = '';
					if($keyword!=''){
						$srchQuery = ' (business.title LIKE \'%'.$keyword.'%\' OR business.description LIKE \'%'.$keyword.'%\') AND';
					}

					$business	=	DB::select('SELECT business.lat,business.lon ,'.$select.',  ('.$nearby.')
												AS distance,
												n.rating_count,n.rating_value,n.expense_count,n.expense_value,
												(SELECT bi.filename FROM businessImages as bi WHERE bi.biz_id=business.id AND bi.active=1 LIMIT 1) as biz_image 
												FROM business 
												LEFT JOIN cities ON business.city_id = cities.id
												LEFT JOIN subadmin1 ON business.subadmin1_code = subadmin1.code
												LEFT JOIN (
													SELECT biz_id, COUNT(review.rating) as rating_count, 
														SUM(review.rating) as rating_value,
														COUNT(review.expense) as expense_count, 
														SUM(review.expense) as expense_value
														FROM review GROUP BY biz_id
												
												) AS n ON business.id = n.biz_id
												WHERE business.active=1 '.$srhWhereCountry.' '.$srhWhere.' 
												HAVING distance < 10 ORDER BY distance
									'); 
					//$delArr = array();
					if( count($business) ) {
						foreach( $business as $key => $values ) {
							if( $values->distance ) {
								//Edited On 03-05-2018  
								//$values->distance	=	round($values->distance);
								//NEW MILES TO KM
								$values->miles	    =	$values->distance;
								$values->distance_k	=	round($values->distance * 1.609);
								$values->distance   =	round($values->distance * 1609.344);
								//$values->distance_k	=	round($this->distance($values->lat, $values->lon,$latitude, $longitude, "K"));
							}
							
							//BOF UNLINKING Latitude = 0 and Longitude =0 Businesses
							if((trim($values->lat)==0) || (trim($values->lat)=='')){
								unset($business[$key]);
							}
							if((trim($values->lon)==0) || (trim($values->lon)=='')){
								unset($business[$key]);
							}
						}
						
						$business = array_values(array_filter($business)); 
						//EOF 
					}
				}
				else {
					$business			= 	DB::table('business');
					if( $language_code == 'ar' ) {
						$business		= 	$business->select('business.id as biz_id', 'business.title_ar as biz_title', 'business.visits as biz_visits','business.created_at as biz_date','businessImages.filename as biz_image', 'cities.name as city_title', 'subadmin1.name as location_title', DB::raw("COUNT(review.rating) as rating_count"), DB::raw("SUM(review.rating) as rating_value"), DB::raw("COUNT(review.expense) as expense_count"), DB::raw("SUM(review.expense) as expense_value"));
					}	
					else {
						$business		= 	$business->select('business.id as biz_id', 'business.title as biz_title', 'business.visits as biz_visits', 'business.created_at as biz_date','businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title', DB::raw("COUNT(review.rating) as rating_count"), DB::raw("SUM(review.rating) as rating_value"), DB::raw("COUNT(review.expense) as expense_count"), DB::raw("SUM(review.expense) as expense_value"));
					}					
					$business			= 	$business->leftjoin('cities','business.city_id', '=', 'cities.id')
											->leftjoin('subadmin1','business.subadmin1_code', '=', 'subadmin1.code')
											->leftjoin('businessImages','business.id', '=', 'businessImages.biz_id')
											->leftjoin('review','business.id', '=', 'review.biz_id');
					if( $request->has('category_id') ) {
						$business		=	$business->where('business.category_id', $request->input('category_id'));
					}
					if( $country_code ) {	
						$business		= 	$business->where('business.country_code', '=', $country_code);
					}
					if($keyword!=''){
						$business		= 	$business->where( function($query) use($keyword){
							$query->where('business.title', 'LIKE', "%$keyword%");
							$query->orWhere('business.description', 'LIKE', "%$keyword%"); 
						});
					}
					$business		= 	$business->where('business.active', 1)
													->groupBy('business.id')
													->orderBy('business.visits', 'desc')
													->get();
													//->paginate(20);
						
				}
				
				if( count($business) ) {
					foreach( $business as $values ) {
						if( $values->biz_title ) {
							$values->biz_title	=	ucwords($values->biz_title);
						}
						if( $values->biz_date ) {
							$values->biz_date	=	date("jS F Y h:i A", strtotime($values->biz_date));
						}
						if( !$values->biz_image ) {
							$values->biz_image	=	'uploads/pictures/no-image.jpg';
						}
						$values->rating			=	0;
						$values->expense		=	0;
						if( $values->rating_count ) {
							$values->rating		=	$values->rating_value / $values->rating_count;
						}
						if( $values->expense_count ) {
							$values->expense	=	$values->expense_value / $values->expense_count;
						}
						unset($values->rating_count);
						unset($values->rating_value);
						unset($values->expense_count);
						unset($values->expense_value);
					}
				}
				
				   if($request->has('page') && $request->input('page')!='') {
						$page 	  = $request->input('page');
						$business =  $this->arrayPaginator($business, $request);  
					}
				
				$data['business']	= 	$business;
				$data['status']		= 	'success';
				
				/* unset($data['alerts']);*/ 
				
			/* } */
			return json_encode($data);
		}
		
		public function SearchBusiness(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			/* $data['alerts'] = 'invalid credential.'; */
			$user			= User::where('api_key', $request->input('apikey'))->first();
			/* if( count($user) ) { */
				
				$country_code		=	'';
				$city_code			=	'';
				$language_code		=	'en';
				$circle_radius 		= 	3959;
				$max_distance 		= 	20;
				$latitude			=	'';
				$longitude			=	'';
				$keyword			=	'';
				
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				if( $request->has('city_code') ) {
					$city_code		=	$request->input('city_code');
				}
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				if( $request->has('latitude') ) {
					$latitude		=	$request->input('latitude');
				}
				if( $request->has('longitude') ) {
					$longitude		=	$request->input('longitude');
				}
				if( $request->has('q') ) {
					$keyword		=	$request->input('q');
				}
					
				if( $latitude && $longitude && $latitude!='' && $longitude!='') {
						
					$nearby 	= 	$circle_radius .' * acos(cos(radians(' . $latitude . ')) * cos(radians(lat)) *
									cos(radians(lon) - radians(' . $longitude . ')) +
									sin(radians(' . $latitude . ')) * sin(radians(lat)))';
					
					if( $language_code == 'ar' ) {
						$select = "business.id as biz_id, business.title_ar as biz_title, business.visits as biz_visits, business.created_at as biz_date, businessImages.filename as biz_image, cities.name as city_title, subadmin1.name as location_title";
					}	
					else {
						$select = "business.id as biz_id, business.title as biz_title, business.visits as biz_visits, business.created_at as biz_date, businessImages.filename as biz_image, cities.asciiname as city_title, subadmin1.asciiname as location_title";
					}
				
					$catQuery		=	'';
					if( $request->has('category_id') ) {
						$catQuery	=	'business.category_id = '.$request->input('category_id').' AND';
					}
					$coun_code	= "";						
					if( $country_code ) {
						$coun_code	= "AND business.country_code ='".$country_code."'";
					}
					$srchQuery = '';
					if($keyword!=''){
						$srchQuery = ' (business.title LIKE \'%'.$keyword.'%\' OR business.description LIKE \'%'.$keyword.'%\') AND';
					}
					$business	=	DB::select('
										SELECT * FROM
											(SELECT lat,lon ,'.$select.',  ('.$nearby.')
												AS distance,
												COUNT(review.rating) as rating_count, 
												SUM(review.rating) as rating_value,
												COUNT(review.expense) as expense_count, 
												SUM(review.expense) as expense_value
												FROM business 
												LEFT JOIN cities ON business.city_id = cities.id
												LEFT JOIN subadmin1 ON business.subadmin1_code = subadmin1.code
												LEFT JOIN businessImages ON business.id = businessImages.biz_id
												LEFT JOIN review ON business.id = review.biz_id
												WHERE '.$catQuery.$srchQuery.' business.active = 1 '.$coun_code.' GROUP BY biz_id ORDER BY distance ASC
											) AS distances
										;
									');
					//$delArr = array();
					/*echo "<pre>";
					print_r($business);
					exit;*/
					if( count($business) ) {
						foreach( $business as $key => $values ) {
							if( $values->distance ) {
								//Edited On 03-05-2018  
								//$values->distance	=	round($values->distance);
								//NEW MILES TO KM
								$values->miles	    =	$values->distance;
								$values->distance_k	=	round($values->distance * 1.609);
								$values->distance   =	round($values->distance * 1609.344);
								//$values->distance_k	=	round($this->distance($values->lat, $values->lon,$latitude, $longitude, "K"));
							}
							
						}
						//BOF UNLINKING Latitude = 0 and Longitude =0 Businesses
						 foreach($business as $key => $val){
							if((trim($val->lat)==0) || (trim($val->lat)=='')){
								unset($business[$key]);
							}
							if((trim($val->lon)==0) || (trim($val->lon)=='')){
								unset($business[$key]);
							}
						 }
						 $business = array_values(array_filter($business)); 
						 //EOF 
					}
				}
				else {
					$business			= 	DB::table('business');
					if( $language_code == 'ar' ) {
						$business		= 	$business->select('business.id as biz_id', 'business.title_ar as biz_title', 'business.visits as biz_visits','business.created_at as biz_date','businessImages.filename as biz_image', 'cities.name as city_title', 'subadmin1.name as location_title', DB::raw("COUNT(review.rating) as rating_count"), DB::raw("SUM(review.rating) as rating_value"), DB::raw("COUNT(review.expense) as expense_count"), DB::raw("SUM(review.expense) as expense_value"));
					}	
					else {
						$business		= 	$business->select('business.id as biz_id', 'business.title as biz_title', 'business.visits as biz_visits', 'business.created_at as biz_date','businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title', DB::raw("COUNT(review.rating) as rating_count"), DB::raw("SUM(review.rating) as rating_value"), DB::raw("COUNT(review.expense) as expense_count"), DB::raw("SUM(review.expense) as expense_value"));
					}					
					$business			= 	$business->leftjoin('cities','business.city_id', '=', 'cities.id')
											->leftjoin('subadmin1','business.subadmin1_code', '=', 'subadmin1.code')
											->leftjoin('businessImages','business.id', '=', 'businessImages.biz_id')
											->leftjoin('review','business.id', '=', 'review.biz_id');
					if( $request->has('category_id') ) {
						$business		=	$business->where('business.category_id', $request->input('category_id'));
					}
					if( $country_code ) {	
						$business		= 	$business->where('business.country_code', '=', $country_code);
					}
					if($keyword!=''){
						$business		= 	$business->where( function($query) use($keyword){
							$query->where('business.title', 'LIKE', "%$keyword%");
							$query->orWhere('business.description', 'LIKE', "%$keyword%"); 
						});
					}
					$business		= 	$business->where('business.active', 1)
													->groupBy('business.id')
													->orderBy('business.visits', 'desc')
													->get();
													//->paginate(20);
						
				}
				
				if( count($business) ) {
					foreach( $business as $values ) {
						if( $values->biz_title ) {
							$values->biz_title	=	ucwords($values->biz_title);
						}
						if( $values->biz_date ) {
							$values->biz_date	=	date("jS F Y h:i A", strtotime($values->biz_date));
						}
						if( !$values->biz_image ) {
							$values->biz_image	=	'uploads/pictures/no-image.jpg';
						}
						$values->rating			=	0;
						$values->expense		=	0;
						if( $values->rating_count ) {
							$values->rating		=	$values->rating_value / $values->rating_count;
						}
						if( $values->expense_count ) {
							$values->expense	=	$values->expense_value / $values->expense_count;
						}
						unset($values->rating_count);
						unset($values->rating_value);
						unset($values->expense_count);
						unset($values->expense_value);
					}
				}
				
				   if($request->has('page') && $request->input('page')!='') {
						$page 	  = $request->input('page');
						$business =  $this->arrayPaginator($business, $request);  
					}
				
				$data['business']	= 	$business;
				$data['status']		= 	'success';
				
				/* unset($data['alerts']);*/ 
				
			/* } */
			return json_encode($data);
		}
		
		public function distance($lat1, $lon1, $lat2, $lon2, $unit)
		{
			$theta = $lon1 - $lon2;
			$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
			$dist = acos($dist);
			$dist = rad2deg($dist);
			$miles = $dist * 60 * 1.1515;
			$unit = strtoupper($unit);
			if ($unit == "K") {
				return ($miles * 1.609344);
			}
			else if ($unit == "N") {
				return ($miles * 0.8684);
			}
			else {
				return $miles;
			}
		}
		/**
		 * Booking the Business.
		 *
		 * @return Response
		 */
		 public function BusinessStatusChangeAction(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			 if( count($user) ) {
				
				$data['status'] = 'success';
				if( $request->has('booking_id') &&  $request->has('status')) {
					$status 	= $request->input('status');
					$booking_id = $request->input('booking_id');
					$btb 		= BusinessBookingOrder::where('id', $booking_id)->first();
					if(count($btb)){        
						$btb->approved = $status;
						$btb->save();            
						if($status == 1) {
							$data['alerts'] = 'Successfully Update the status to '.t('Approved').'';
						}else if($status == 2) {
							$data['alerts'] = 'Successfully Update the status to '.t('Discarded').'';
						}
					}else
					{
						$data['alerts'] = 'Failed to Update status !';
					}
				}     
				
				//unset($data['alerts']);
			}
			return json_encode($data);
		}
		 
		 /**
		 * Get the All Business.
		 *
		 * @return Response
		 */
		public function GetBusinessOwn(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$business			= 	DB::table('business');
				if( $language_code == 'ar' ) {
					$business		= 	$business->select('business.id as biz_id', 'business.title_ar as biz_title', 'business.visits as biz_visits', 'business.created_at as biz_date','businessImages.filename as biz_image', 'cities.name as city_title', 'subadmin1.name as location_title');
				}	
				else {
					$business		= 	$business->select('business.id as biz_id', 'business.title as biz_title', 'business.visits as biz_visits', 'business.created_at as biz_date','businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title');
				}					
				$business			= 	$business->leftjoin('cities','business.city_id', '=', 'cities.id')
										->leftjoin('subadmin1','business.subadmin1_code', '=', 'subadmin1.code')
										->leftjoin('businessImages','business.id', '=', 'businessImages.biz_id')
										->where('business.user_id', $user->id)->where('business.active', 1)
										->groupBy('business.id')->get();

				if( count($business) ) {
					foreach( $business as $values ) {
						if( $values->biz_id ) {
							$values->biz_booking = DB::table('businessBookingOrder')->where('biz_id', $values->biz_id)->count();
						}
						if( $values->biz_title ) {
							$values->biz_title	 =	ucwords($values->biz_title);
						}
						if( $values->biz_date ) {
							$values->biz_date	 =	date("jS F Y h:i A", strtotime($values->biz_date));
						}
						if( !$values->biz_image ) {
							$values->biz_image	 =	'uploads/pictures/no-image.jpg';
						}
					}
				}
				
				$data['user_type_id']	= 	$user->user_type_id;
				$data['business']	= 	$business;
				$data['status']		= 	'success';
				
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * ReportBusiness.
		 *
		 * @return Response
		 */
		public function ReportBusiness(HttpRequest $request) {
			
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			if($request->has('apikey')){
				if( $request->has('reason') ) {
					if( $request->has('biz_id') ) {
						$user			= User::where('api_key', $request->input('apikey'))->first();
						if( count($user) ) {
						  $business		= 	DB::table('business')
											  ->where('id',$request->input('biz_id'))
											  ->first();
						  if($business!=''){
							  $Arr		= 	DB::table('businessScam')
											  ->where('biz_id',$request->input('biz_id'))
											  ->where('user_id',$user->id)
											  ->first();
							  if(count($Arr)==0) {
								  $scam   		  = new BusinessScam();
								  $scam->biz_id   = $business->id;
								  $scam->reason   = $request->input('reason');
								  $scam->user_id  = $user->id;
								  $scam->ip_addr  = '';
								  $scam->save();
								  $data['status']		= 	'success';
								  unset($data['alerts']);
							  }else {
								$data['alerts'] = 'Already Reported';}
							  
						  }else {
							$data['alerts'] = 'business not found!';}
					   }
					}else {
						$data['alerts'] = 'biz_id is required!';}
				}else {
					$data['reason'] = 'biz_id is required!'; }
		    }else{
				$data['alerts'] = 'apikey is required!';
		    }
		  return json_encode($data);
		}
		/**
		 * Get a Single Business based on id.
		 *
		 * @return Response
		 */
		public function GetBusinessSingle(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			if($request->has('biz_id') && $request->input('biz_id')!='' ){
				if($request->has('apikey') && $request->input('apikey')!=''){
					$user			= User::where('api_key', $request->input('apikey'))->first();
					//if( count($user) ) {
				}
				if( $request->has('biz_id') ) {
					googlefetchdetails($request->get('biz_id'));
					
					$country_code		=	'';
					$city_code			=	'';
					$language_code		=	'en';
					if( $request->has('country_code') ) {
						$country_code	=	$request->input('country_code');
					}
					if( $request->has('city_code') ) {
						$city_code		=	$request->input('city_code');
					}
					if( $request->has('language_code') ) {
						$language_code	=	$request->input('language_code');
					}
					
					
					$business			= 	DB::table('business');
					if( $language_code == 'ar' && $request->input('apikey')!='') {
						$business		= 	$business->select('business.*', 'business.title_ar as biz_title', 'businessImages.filename as biz_image', 'cities.name as city_title', 'subadmin1.name as location_title', 'businessBooking.title as booking_title');
						//$business		= 	$business->select('businessScam.id as scam_id','businessScam.reason as scam_reason');
					}	
					else if($language_code == 'en' && $request->input('apikey')!=''){
						$language_code == 'en';
						$business		= 	$business->select('business.*', 'business.title as biz_title', 'businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title', 'businessBooking.title as booking_title');
						//$business		= 	$business->select('business.*','business.title as biz_title', 'businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title', 'businessBooking.title as booking_title');
						//$business		= 	$business->select('businessScam.id as scam_id','businessScam.reason as scam_reason');
					}
					
					else if($language_code == 'ar' && $request->input('apikey')=='')
					{
						$business		= 	$business->select('business.*','business.title_ar as biz_title', 'businessImages.filename as biz_image', 'cities.name as city_title', 'subadmin1.name as location_title', 'businessBooking.title as booking_title');
					}
					else if($language_code == 'en' && $request->input('apikey')=='')
					{
						$business		= 	$business->select('business.*','business.title as biz_title', 'businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title', 'businessBooking.title as booking_title');
					}
					
							
					$business			= 	$business->leftjoin('cities', 'business.city_id', '=', 'cities.id')
														->leftjoin('subadmin1', 'business.subadmin1_code', '=', 'subadmin1.code')
														->leftjoin('businessImages','business.id', '=', 'businessImages.biz_id')
														->leftjoin('businessBooking','business.booking_type', '=', 'businessBooking.translation_of');
					
					
					if($request->input('apikey')!='' && count($user)>0 && count($user)>0){
						 $business  = $business->leftjoin('businessScam','business.id', '=', 'businessScam.biz_id');
						 $res = BusinessScam::where('biz_id', $request->input('biz_id'))
										->where('user_id', $user->id)
										->first();								
						 
										
					     if(count($res)>0 && count($user)>0){
							 $business  = $business->addSelect('businessScam.id as scam_id','businessScam.reason as scam_reason');
						     $business	= 	$business->where('businessScam.user_id', $user->id);
						 }
					} 
					if( $city_code ) {					
						$business		= 	$business->where('business.city_id', $city_code);
					}	
					if( $country_code ) {					
						$business		= 	$business->where('business.country_code', $country_code);
					}	
					
					/* if( $language_code == 'ar' ) {
						$business		= 	$business->where('businessBooking.translation_lang', 'ar');
					}	
					else {
						$business		= 	$business->where('businessBooking.translation_lang', 'en');
					} */
					$business			= 	$business->where('business.id', $request->input('biz_id'))->first();
					
					if( count($business) ) {
						
						$data['status']		= 	'success';
						
						if( $business->biz_title ) {
							$business->biz_title	=	ucwords($business->biz_title);
						}
						if( !$business->biz_image ) {
							$business->biz_image	=	'uploads/pictures/no-image.jpg';
						}
						
						if( $business->keywords ) {
							$keywords = array_filter(explode(",", $business->keywords));
							$kwarray  = array();	
							if( count($keywords) ) {
								foreach( $keywords as $key => $value ) {
									$kwarray[] = array('id' => $value);
								}
							}
							$business->keywords   = $kwarray;
						}
						else {
							$business->keywords = array();
						}
						
						$openOrNot = array('day' => 'Unavailable', 'hourz' => 'Unavailable', 'status' => 'Unavailable');
						if( $business->biz_hours ) {
							$biz_hours = unserialize($business->biz_hours);
							$hours_arr = array();
							$hours_arr_1 = array();
							if( count($biz_hours) ) {
								for($i=0;$i<count($biz_hours);$i++) {
									$hours_sub  = explode(" ", $biz_hours[$i]);
									$hours_sup	= array();
									$hours_sup_1	= array();
									if( count($hours_sub) ) {
										$hours_sup['biz_days'] 			= $hours_sub[0];
										$hours_sup['biz_start_hours'] 	= date("g:i A", strtotime($hours_sub[1]));
										$hours_sup['biz_end_hours'] 	= date("g:i A", strtotime($hours_sub[2]));
									}
									$hours_arr[$i] = $hours_sup;
								}
								//for ios 21-06-18 business hours
								 for($i=0;$i<7;$i++) {
									$hours_sup_1	= array();
									if( count($hours_sub) ) {
										$hours_sup_1['biz_days'] 			= "".$i."";
										$hours_sup_1['biz_start_hours'] 	= "";
										$hours_sup_1['biz_end_hours'] 		= "";
									}
									$hours_arr_1[$i] = $hours_sup_1;
								}
								$resArr = array();
								if(is_array($hours_arr_1) && is_array($hours_arr)){
									foreach($hours_arr_1 as $key => $val){
										$resArr[] = $val['biz_days'];  
									}
									foreach($hours_arr as $key => $val){
										 
										if(in_array($val['biz_days'], $resArr))
										  {
											 unset($hours_arr_1[$key]); 
										  }
									}
									$hoursRes = array_merge($hours_arr,$hours_arr_1);
									$business->biz_hours_ios = $hoursRes;
								}
							     
								//for ios 21-06-18 business hours
							}
							
							$countryCode	=	DB::table('business')
											->where('id', $request->get('biz_id') )
											->pluck('country_code');
											
							$timeZone	=	DB::table('time_zones')
											->where('country_code', $countryCode )
											->pluck('time_zone_id');
							//echo $timeZone[0]; exit();
							
							$bizDayA 	= array(0=>'Mon',1=>'Tue',2=>'Wed',3=>'Thu',4=>'Fri',5=>'Sat',6=>'Sun');
							if( count($biz_hours) ) {
								foreach($biz_hours as $key => $value) {
									$bizhrsA = explode(' ', $value);
									if($bizDayA[$bizhrsA[0]] == date("D")) {
										$timeStrt[]  = strtotime($bizhrsA[1]);
										$timeEnd[]  = strtotime($bizhrsA[2]);
										;
										$bizhrs2 = $bizhrsA[2]; 
									}
								}
								
								if( isset($timeStrt[0])){
									 $start0 = date('H:i a', $timeStrt[0]); 
									 $end0 = date('H:i a', $timeEnd[0]); 
									 
									 if($end0 == '00:00 am'){
									 $end0 = '24:00';
								 }
								}
								 
								 $timeNow = Carbon::now($timeZone[0])->format('H:i a');
								 //$timeNow = '05:43'; 
								 //$timeNow = '17:43';
								 //echo $timeNow; exit();
								 if( isset($timeStrt[2])){
									 $start1 	= date('H:i a', $timeStrt[1]); 
									 $end1 		= date('H:i a', $timeEnd[1]); 
									 $start2 	= date('H:i a', $timeStrt[2]); 
									 $end2 		= date('H:i a', $timeEnd[2]); 
									 
									 if($end1 == '00:00 am'){
										 $end1 = '24:00';
									 }
									if($end2 == '00:00 am'){
										$end2 = '24:00';
									}
									if (($timeNow > $start0 && $timeNow < $end0) || ($timeNow > $start1 && $timeNow < $end1) || ($timeNow > $start2 && $timeNow < $end2) ){
										
										$times =  date("h:i A",$timeStrt[0])." - ".date("h:i A", $timeEnd[0]). " /n " .date("h:i A",$timeStrt[1])." - ".date("h:i A", $timeEnd[1]). " /n " .date("h:i A",$timeStrt[2])." - ".date("h:i A", $timeEnd[2]);
										$status = "Open";
										$openOrNot = array('day' => 'Today', 'hourz' => $times, 'status' => $status);
									}else{
										$times =  date("h:i A",$timeStrt[0])." - ".date("h:i A", $timeEnd[0]). " /n " .date("h:i A",$timeStrt[1])." - ".date("h:i A", $timeEnd[1]). " /n " .date("h:i A",$timeStrt[2])." - ".date("h:i A", $timeEnd[2]);
										$status = "Closed";
										$openOrNot = array('day' => 'Today', 'hourz' => $times, 'status' => $status);
									}
								 }
										
								 elseif( isset($timeStrt[1]) ) {
								  $start1 = date('H:i a', $timeStrt[1]); 
								  $end1   = date('H:i a', $timeEnd[1]); 
								  
								  if($end1 == '00:00 am'){
									  $end1 = '24:00';
								  }
								  
								  if (($timeNow > $start0 && $timeNow < $end0) || ($timeNow > $start1 && $timeNow < $end1)){
									  //$times 	= date("h:i A", $timeSt)." - ".date("h:i A", $timeEd);
									$times =  date("h:i A",$timeStrt[0])." - ".date("h:i A", $timeEnd[0]). " /n " .date("h:i A",$timeStrt[1])." - ".date("h:i A", $timeEnd[1]);
									 
									$status = "Open";
									
									$openOrNot = array('day' => 'Today', 'hourz' => $times, 'status' => $status);
									
								  }
								  else{
									  $times =  date("h:i A",$timeStrt[0])." - ".date("h:i A", $timeEnd[0]). " /n " .date("h:i A",$timeStrt[1])." - ".date("h:i A", $timeEnd[1]);
									 
									$status = "Closed";
									
									$openOrNot = array('day' => 'Today', 'hourz' => $times, 'status' => $status);
								  }
									
								}
								
								elseif( isset($timeStrt[0])){
									
									if($start0 > $end0)
									{
										
										$midNight1 = '24:00';
										$midNight2 = '00:00 am';
										
										if(($timeNow > $start0 && $timeNow < $midNight1) || ($timeNow > $midNight2 && $timeNow < $end0)){
											$times =  date("h:i A",$timeStrt[0])." - ".date("h:i A", $timeEnd[0]);
											$status = "Open";
											$openOrNot = array('day' => 'Today', 'hourz' => $times,  'status' => $status);
										}
										else{
											$times =  date("h:i A",$timeStrt[0])." - ".date("h:i A", $timeEnd[0]);
											$status = "Closed";
										
											$openOrNot = array('day' => 'Today', 'hourz' => $times,  'status' => $status);
										}
									}
									else
									{
										if($timeNow > $start0 && $timeNow < $end0){
											$times =  date("h:i A",$timeStrt[0])." - ".date("h:i A", $timeEnd[0]);
											$status = "Open";
										
											$openOrNot = array('day' => 'Today', 'hourz' => $times,  'status' => $status);
										}
										else{
											$times =  date("h:i A",$timeStrt[0])." - ".date("h:i A", $timeEnd[0]);
											$status = "Closed";
										
											$openOrNot = array('day' => 'Today', 'hourz' => $times,  'status' => $status);
										}
									}
									//exit();
									
									
								}
								
								
								
								else {
									$openOrNot = array('day' => 'Offday', 'hourz' => 'Unavailable', 'status' => 'Closed');
								}
							}
							$business->biz_hours = $hours_arr;
						}
						else {
							$business->biz_hours = array();
						}
						$data['businessOpen'] = $openOrNot;
						/*
						if(count($data['businessOpen'])>0) {
							foreach($data['businessOpen'] as $k => $v){
								$v->hourz = ucfirst($v->hourz);
							}
						}
						*/
					
						if( $business->more_info ) {
							$biz_info	= array();
							$more_info_old  = array_filter(unserialize($business->more_info));
							$more_info  = unserialize($business->more_info);
							if( count($more_info) ) {
								foreach( $more_info as $key => $value ) {
									
									$biz_info[] = array('id' => $key, 'value' => $value);
								}
							}
							$business->more_info = $biz_info;
						}
						else {
							$business->more_info = array();
						}
					   
						if( $business->gift_info ) {
							$business->gift_info = array_filter(unserialize($business->gift_info));
						}
						else {
							$business->gift_info = array();
						}
						$business->own_business = '0';
						if($request->input('apikey')!='' && count($user)>0){
							if( $business->user_id == $user->id ) {
								$business->own_business = '1';
							}
							if( isset($business->scam_id)) {
								$business->scam_id = $business->scam_id;
							}
							else
							{
								$business->scam_id		=	'';
								$business->scam_reason	=	'';
							}
						}
						else
						{
							
							$business->scam_id		=	'';
							$business->scam_reason	=	'';
					
						}
						
						$data['business']	= 	$business;
						
						$moreinfo		=	DB::table('businessInfo')
											->select('translation_of as id', 'info_title as title', 'info_vals as value')
											->where('translation_lang', $language_code)
											->where('active', 1)->get();
						
						if( count($moreinfo) ) {
							foreach( $moreinfo as $fields ) {
								if( $fields->value ) {
									$fields->value = unserialize($fields->value);
								}
							}
						}
						$busInfoA = [];
						$data['moreinfo']	= 	$moreinfo;
						
						$key_words 	= 	DB::table('categories');
						if( $language_code == 'ar' ) {
							$key_words 	= 	$key_words->select('translation_of as id', 'name as title');
						}
						else {
							$key_words 	= 	$key_words->select('id', 'name as title');
						}
						$key_words 	= 	$key_words->where('translation_lang', $language_code)->where('parent_id', '!=', 0)->where('active', 1)->get();
						if( count($key_words) ) {
							foreach( $key_words as $fields ) {
								if( $fields->title ) {
									$fields->title = ucwords($fields->title);
								}
							}
						}				
						$data['key_words']	= 	$key_words;
						
						$data['images']		=	DB::table('businessImages')
												->select('id', 'filename as image')
												->where('biz_id', $request->input('biz_id'))
												->where('active', 1)
												->get();
												
						$data['locations']	=	DB::table('businessLocations')
												->where('biz_id', $request->input('biz_id'))
												->where('active', 1)
												->get();
						//
						if(count($data['locations'])>0){
							foreach($data['locations'] as $k=>$val){
								$val->address_1  = ucfirst($val->address_1);
								$val->address_2  = ucfirst($val->address_2);
							}
						}
						//						
						$reviews			=	DB::table('review')
												->select('review.id', 'review.user_name as person', 'review.review', 'review.rating', 'review.expense', 'review.created_at as date', 'users.photo')
												->leftjoin('users', 'review.user_id', '=', 'users.id')
												->orderBy('review.created_at', 'DESC')
												->take(5)
												->where('biz_id', $request->input('biz_id'))
												->get();
						
						$business->nof_reviews 	= 0;
						$business->avg_ratings	= 0;
						$business->avg_expense	= 0;
						if( count($reviews) ) {
							
							foreach( $reviews as $key => $field ) {
								
								$business->nof_reviews = $business->nof_reviews + 1;
								if( $field->person ) {
									$field->person = ucwords($field->person);
								}
								if( $field->review ) {
									$field->review = ucwords($field->review);
								}
								if( $field->photo ) {
									$field->photo	= 'uploads/pictures/dp/'.$field->photo;
								}
								else {
									$field->photo	= 'uploads/pictures/dp/demo.jpg';
								}
								if( $field->date ) {
									$field->date	= date('d-m-Y', strtotime($field->date));
								}
								if( $field->rating ) {
									$business->avg_ratings 	= $business->avg_ratings + $field->rating;
								}
								if( $field->expense ) {
									$business->avg_expense 	= $business->avg_expense + $field->expense;
								}
							}
							if( $business->avg_ratings ) {
								$business->avg_ratings = $business->avg_ratings / $business->nof_reviews;
							}
							if( $business->avg_expense ) {
								$business->avg_expense = $business->avg_expense / $business->nof_reviews;
							}
						}					
						$data['reviews']	=	$reviews;
						
						$offers			    =	DB::table('businessOffers')
												->select('businessOffers.*', 'offer_type.title as offertype')
												->leftjoin('offer_type', 'businessOffers.offertype', '=', 'offer_type.translation_of')
												->where('businessOffers.biz_id', $request->input('biz_id'))
												->where('offer_type.translation_lang', $language_code)
												->where('businessOffers.active', 1)
												->get();
											
						$data['offers']		= $offers;
						$lang 				= 'en';
						$business_name  	= preg_replace("/[^a-zA-Z]+/", "", $business->biz_title);
						$data['biz_url']	= url('/'.$lang.'/'.$business_name.'/'.$business->id.'.html');
						
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			
			//}
			}
			else {
					$data['alerts'] = 'the biz_id is required.';
			}
			return json_encode($data);
		}
		
		/**
		 * Get the Business by category id.
		 *
		 * @return Response
		 */
		public function GetBusinessByCategory(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('category_id') ) {
					
					$country_code		=	$user->country_code;
					$city_code			=	'';
					if( $request->has('country_code') ) {
						$country_code	=	$request->input('country_code');
					}
					if( $request->has('city_code') ) {
						$city_code		=	$request->input('city_code');
					}
					
					$business			= 	DB::table('business')
											->select('business.*','cities.asciiname as city_name','businessImages.filename as images')
											->leftjoin('cities','business.city_id', '=', 'cities.id')
											->leftjoin('businessImages','business.id', '=', 'businessImages.biz_id');
											
					if( $country_code )	{					
						$business		= 	$business->where('business.country_code', '=', $country_code);
					}
											
					if( $city_code ) {					
						$business		= 	$business->where('business.city_id', '=', $city_code);
					}
					
					$data['business']	= 	$business->where('business.category_id', $request->input('category_id'))->where('business.active', 1)->get();
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the category_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the Business by category id.
		 *
		 * @return Response
		 */
		public function GetPendingBusiness(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$country_code		=	$user->country_code;
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$business			= 	DB::table('business');
				if( $language_code == 'ar' ) {
					$business		= 	$business->select('business.id as biz_id', 'business.title_ar as biz_title', 'business.visits as biz_visits','business.created_at as biz_date','businessImages.filename as biz_image', 'cities.name as city_title', 'subadmin1.name as location_title');
				}	
				else {
					$business		= 	$business->select('business.id as biz_id', 'business.title as biz_title', 'business.visits as biz_visits', 'business.created_at as biz_date','businessImages.filename as biz_image', 'cities.asciiname as city_title', 'subadmin1.asciiname as location_title');
				}					
				$business			= 	$business->leftjoin('cities','business.city_id', '=', 'cities.id')
										->leftjoin('subadmin1','business.subadmin1_code', '=', 'subadmin1.code')
										->leftjoin('businessImages','business.id', '=', 'businessImages.biz_id')
										->where('business.user_id', '=', $user->id)->where('business.active', 0)
										->get();
				
				if( count($business) ) {
					foreach( $business as $values ) {
						if( !$values->biz_image ) {
							$values->biz_image	=	'uploads/pictures/no-image.jpg';
						}
					}
				}
				
				$data['business']	= 	$business;
				$data['status']		= 	'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Get the create event.
		 *
		 * @return Response
		 */
		public function GetCreateEvent(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$country_code		=	$user->country_code;
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
							
				$data['eventtype']	= 	DB::table('event_type')->select('translation_of', 'name')->where('translation_lang', $language_code)->where('active', 1)->get();
				$countries 			=	DB::table('countries');
				if( $language_code == 'ar' ) {
					$countries = $countries->select('code', 'name as title');
				}
				else {
					$countries = $countries->select('code', 'asciiname as title');
				}
				$countries	= $countries->where('active', 1)->get();
				
				$data['countries'] 	= $countries;

				$cities	=	DB::table('cities');
				if( $language_code == 'ar') {
					$cities	=	$cities->select('id', 'name as title')->orderBy('name', 'asc');
				}
				else {
					$cities	=	$cities->select('id', 'asciiname as title')->orderBy('asciiname', 'asc');
				}
				$cities	=	$cities->where('country_code', $country_code)->where('active', 1)->get();
				
				$data['cities']		=	$cities;
					
				$data['apikey']		= 	$request->input('apikey');
				$data['status']		= 	'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Post the create event.
		 *
		 * @return Response
		 */
		public function PostCreateEvent(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
			
				$subadmin1_code	=	00;
				if( $request->has('city_code') ) {
					$city	=	DB::table('cities')->where('id', $request->input('city_code'))->first();
					if( count($city) ) {
						$subadmin1_code	=	$request->input('country_code').'.'.$city->subadmin1_code;
					}
				}
				
				$currency_code	=	'';
				if( $request->has('country_code') ) {
					$countries	=	DB::table('countries')->select('currencies.html_entity')->leftjoin('currencies', 'countries.currency_code', '=','currencies.code')->where('countries.code', $request->input('country_code'))->first();
					if( count($countries) ) {
						$currency_code	=	$countries->html_entity;
					}
				}
						
				$event_image	=	'';
				if( $request->has('event_image') ) {
					$event_image	=	$request->input('event_image');
				}
				
				$ticket_details	= array();
				if( $request->input('ticket_type') == 1 ) {
					$ticket_details = array('tickets' => $request->input('ticket_count'));
				}
				elseif( $request->input('ticket_type') == 2 ) {
					$ticket_details = array('tickets' => $request->input('ticket_count'), 'price' => $request->input('ticket_price'), 'currency' => "");
				}
				
				$visible_to = '';
				$visible_co	= '';
				if( (int)$request->input('event_privacy') ) {
					
					$visible_ar	= $request->input('visible_to');
					if( count($visible_ar) ) {
						$visible_co	=	getRandWord(8);
						$count		=	count($visible_ar);
						$link		= 	\URL::to('/')."/".$language_code."/preview/private/".$visible_co;
						for($i=0;$i < $count;$i++) {
							Mail::send('emails.event.eventapproval', ['link' => $link,'title' => $request->input('event_title'),'email' => $visible_ar[$i],'code' => $visible_co], function($message) use ($link, $visible_co, $visible_ar, $request, $i) {
								$message->to($visible_ar[$i]);
								$message->subject('Howlik Event Invitation!');		
							});
						}
					}
					$visible_to	= serialize($visible_ar);
				}
				
				$latitude	=	'';
				if( $request->has('latitude') ) {
					$latitude	=	$request->input('latitude');
				}
				$longitude	=	'';
				if( $request->has('longitude') ) {
					$longitude	=	$request->input('longitude');
				}
				
				$newOne						=	new Eventnew();
				$newOne->country_code		=	$request->input('country_code');
				$newOne->user_id			=	$user->id;
				$newOne->event_type_id		=	$request->input('event_type');
				$newOne->event_name			=	$request->input('event_title');
				$newOne->event_date			=	date("Y-m-d", strtotime($request->input('start_date')));
				$newOne->event_starttime	=	date('G:i:s', strtotime($request->input('start_date')));
				$newOne->eventEnd_date		=	date("Y-m-d", strtotime($request->input('end_date')));
				$newOne->event_endtime		=	date('G:i:s', strtotime($request->input('end_date')));
				$newOne->subadmin1_code		=	$subadmin1_code;
				$newOne->event_place		=	$request->input('city_code');
				$newOne->about_event		=	$request->input('event_details');
				$newOne->event_image1		=	$event_image;
				$newOne->org_description	=	$request->input('organization_details');
				$newOne->privacy			=	(int)$request->input('event_privacy');
				$newOne->social_share		=	(int)$request->input('social_share');
				$newOne->ticket_type		=	(int)$request->input('ticket_type');
				$newOne->ticket_details		=	serialize($ticket_details);
				$newOne->visible_to			=	$visible_to;
				$newOne->visible_code		=	$visible_co;
				$newOne->latitude			=	$latitude;
				$newOne->longitude			=	$longitude;
				$isSave = $newOne->save();
				
					$note 			= 	new NotifAll();
					$note->lang		=	$language_code;
					
					if($language_code=='en'){
						$note->title	=	'New Event added Successfully';
						$note->type		=	'Event';
					}else {
						$note->type		=	'???';
						$note->title	=	'??? ????? ??? ???? ?????';
					}
			
					$note->user_id	=	$user->id;
					$note->save();
			
				
				
				$data['status']		= 	'success';
				unset($data['alerts']);	
			}
			return json_encode($data);
		}
		
		/**
		 * Post the event image upload.
		 *
		 * @return Response
		 */
		public function UploadEventImage(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->hasFile('file') ) {
					
					$file			=	$request->file('file');
					$name			=	$file->getClientOriginalName();
					
					$check = Eventnew::where('event_image1', 'like', '%'.$name.'%')->first();
					if( count($check) ) {
						
						$destination	=	public_path().'/uploads/pictures/events';
						$extension		= 	$file->getClientOriginalExtension();
						$generator		=	time().'.'.$extension;
						$file->move($destination, $generator);
						$filename		=	'uploads/pictures/events/'.$generator;
						
						$check->update([ 'event_image1' => $filename ]);
					
						$data['status']	= 	'success';
						unset($data['alerts']);
					}	
					else {
						$data['alerts'] = 'event not found.';
					}
				}
				else {
					$data['alerts'] = 'file required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the update event.
		 *
		 * @return Response
		 */
		public function GetUpdateEvent(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$events = DB::table('events')->where('id', $request->input('event_id'))->first();
				if( count($events) ) {
					
					$country_code		=	$events->country_code;
					if( $request->has('country_code') ) {
						$country_code	=	$request->input('country_code');
					}
					
					$language_code		=	'en';
					if( $request->has('language_code') ) {
						$language_code	=	$request->input('language_code');
					}
								
					$data['eventtype']	= 	DB::table('event_type')->select('translation_of', 'name')->where('translation_lang', $language_code)->where('active', 1)->get();
					$countries 			=	DB::table('countries');
					if( $language_code == 'ar' ) {
						$countries = $countries->select('code', 'name as title');
					}
					else {
						$countries = $countries->select('code', 'asciiname as title');
					}
					$countries	= $countries->where('active', 1)->get();
					
					$data['countries'] 	= $countries;
	
					$cities	=	DB::table('cities');
					if( $language_code == 'ar') {
						$cities	=	$cities->select('id', 'name as title')->orderBy('name', 'asc');
					}
					else {
						$cities	=	$cities->select('id', 'asciiname as title')->orderBy('asciiname', 'asc');
					}
					$cities	=	$cities->where('country_code', $country_code)->where('active', 1)->get();
				
					$data['cities']		=	$cities;
					
					$events->ticket_count = '';
					$events->ticket_price = '';
					if( $events->ticket_details ) {
						$ticket_details = unserialize($events->ticket_details);
						if( count($ticket_details) ) {
							if( array_key_exists('tickets', $ticket_details) ) {
								$events->ticket_count = $ticket_details['tickets'];
							}
							if( array_key_exists('price', $ticket_details) ) {
								$events->ticket_price = $ticket_details['price'];
							}
						}
					}
					
					if( $events->visible_to ) {
						$visible_to = unserialize($events->visible_to);
						if( count($visible_to) ) {
							$events->visible_to = implode(',', $visible_to);
						}
					}
					
					$data['events']		=	$events;
						
					$data['apikey']		= 	$request->input('apikey');
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'event not found.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the update event.
		 *
		 * @return Response
		 */
		public function PostUpdateEvent(HttpRequest $request) {
			
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('event_id') ) {
					
					$event = Eventnew::where('id', $request->input('event_id'))->first();
					if( count($event) ) {
						
						$language_code		=	'en';
						if( $request->has('language_code') ) {
							$language_code	=	$request->input('language_code');
						}
					
						$subadmin1_code	=	$event->subadmin1_code;
						if( $request->has('city_code') ) {
							$city	=	DB::table('cities')->where('id', $request->input('city_code'))->first();
							if( count($city) ) {
								$subadmin1_code	=	$request->input('country_code').'.'.$city->subadmin1_code;
							}
						}
						
						$currency_code	=	'';
						if( $request->has('country_code') ) {
							$countries	=	DB::table('countries')->select('currencies.html_entity')->leftjoin('currencies', 'countries.currency_code', '=','currencies.code')->where('countries.code', $request->input('country_code'))->first();
							if( count($countries) ) {
								$currency_code	=	$countries->html_entity;
							}
						}
						
						$ticket_details	= array();
						if( $request->input('ticket_type') == 1 ) {
							$ticket_details = array('tickets' => $request->input('ticket_count'));
						}
						elseif( $request->input('ticket_type') == 2 ) {
							$ticket_details = array('tickets' => $request->input('ticket_count'), 'price' => $request->input('ticket_price'), 'currency' => "");
						}
						
						$visible_to = '';
						$visible_co	= '';
						$exist_arry	= array();
						if( $event->visible_to ) {
							$exist_arry	= array_filter(unserialize($event->visible_to));
						}
						$exist_code	= getRandWord(8);
						if( $event->visible_code ) {
							$exist_code	= $event->visible_code;
						}
						if( (int)$request->input('event_privacy') ) {
							$visible_ar	= $request->input('visible_to');
							$visible_co	= $exist_code;
							if( count($visible_ar) ) {
								$count		=	count($visible_ar);
								$link		= 	\URL::to('/')."/".$language_code."/preview/private/".$visible_co;
								for($i=0;$i < $count;$i++) {
									if ( !in_array($visible_ar[$i], $exist_arry) ) {
										Mail::send('emails.event.eventapproval', ['link' => $link,'title' => $request->input('event_title'),'email' => $visible_ar[$i],'code' => $visible_co], function($message) use ($link, $visible_co, $visible_ar, $request, $i) {
											$message->to($visible_ar[$i]);
											$message->subject('Howlik Event Invitation!');		
										});
									}
								}
							}
							$visible_to	= serialize($visible_ar);
						}
				
						$latitude	=	$event->latitude;
						if( $request->has('latitude') ) {
							$latitude	=	$request->input('latitude');
						}
						$longitude	=	$event->longitude;
						if( $request->has('longitude') ) {
							$longitude	=	$request->input('longitude');
						}
								
						$event_image	=	$event->event_image1;
						if( $request->has('event_image') ) {
							$event_image	=	$request->input('event_image');
						}
				
						$array = array(
							'country_code'		=>	$request->input('country_code'),
							'user_id'			=>	$user->id,
							'event_type_id'		=>	$request->input('event_type'),
							'event_name'		=>	$request->input('event_title'),
							'event_date'		=>	date("Y-m-d", strtotime($request->input('start_date'))),
							'event_starttime'	=>	date('G:i:s', strtotime($request->input('start_date'))),
							'eventEnd_date'		=>	date("Y-m-d", strtotime($request->input('end_date'))),
							'event_endtime'		=>	date('G:i:s', strtotime($request->input('end_date'))),
							'subadmin1_code'	=>	$subadmin1_code,
							'event_place'		=>	$request->input('city_code'),
							'about_event'		=>	$request->input('event_details'),
							'event_image1'		=>	$event_image,
							'org_description'	=>	$request->input('organization_details'),
							'privacy'			=>	(int)$request->input('event_privacy'),
							'social_share'		=>	(int)$request->input('social_share'),
							'ticket_type'		=>	(int)$request->input('ticket_type'),
							'ticket_details'	=>	serialize($ticket_details),
							'visible_to'		=>	$visible_to,
							'visible_code'		=>	$visible_co,
							'latitude'			=>	$latitude,
							'longitude'			=>	$longitude,
						);
						$event->update($array);
						
						$data['status']		= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'event not found.';
					}
				}
				else {
					$data['alerts'] = 'event_id required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the delete event.
		 *
		 * @return Response
		 */
		public function PostDeleteEvent(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('event_id') ) {
					
					$event = DB::table('events')->where('id', $request->input('event_id'))->first();
					if( count($event) ) {
						DB::table('events')->delete($request->input('event_id'));
						$data['status'] = 'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'event not found.';
					}
				}
				else {
					$data['alerts'] = 'the event_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the create business.
		 *
		 * @return Response
		 */
		public function GetCreateBusiness(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$country_code		=	$user->country_code;
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
							
				$data['categories']	= 	DB::table('categories')->select('translation_of as code', 'name')->where('translation_lang', $language_code)->where('parent_id', 0)->where('active', 1)->orderBy('name', 'asc')->get();
				
				$locations	= 	DB::table('subadmin1');
				$cities		=	DB::table('cities');
				if( $language_code == 'ar' ) {
					$locations	=	$locations->select('code as id', 'name as title')->orderBy('name', 'asc');
					$cities		=	$cities->select('id', 'name as title')->orderBy('name', 'asc');
				}
				else {
					$locations	=	$locations->select('code as id', 'asciiname as title')->orderBy('asciiname', 'asc');
					$cities		=	$cities->select('id', 'asciiname as title')->orderBy('asciiname', 'asc');
				}
				$cities		=	$cities->where('country_code', $country_code)->where('active', 1)->get();
				$locations	=	$locations->where('code','LIKE',"%{$country_code}%")->where('active', 1)->get();
				
				$data['locations']	=	$locations;
				/* $data['cities']		=	$cities; */
				
				$informations	=	DB::table('businessInfo')->select('translation_of as info_id', 'info_title', 'info_vals', 'info_type')->where('translation_lang', $language_code)->where('active', 1)->get();
				if( count($informations) ) {
					foreach( $informations as $values ) {
						
						if( $values->info_vals ) {
							$values->info_vals	= unserialize($values->info_vals);
						}
						
						if( $values->info_type == 1 ) {
							$values->info_type	= 'text box';
						}
						else if( $values->info_type == 2 ) {
							$values->info_type	= 'select box';
						}
						else if( $values->info_type == 3 ) {
							$values->info_type	= 'radio button';
						}
						else if( $values->info_type == 4 ) {
							$values->info_type	= 'check box';
						}
					}
				}
				
				$data['informations']	=	$informations;
				$data['apikey']		= 	$request->input('apikey');
				$data['status']		= 	'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Post the create business.
		 *
		 * @return Response
		 */
		public function PostCreateBusiness(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
					
				$country_code		=	$user->country_code;
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
					
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
			
				$keywords	= '';
				if ($request->has('keywords')) {
					$keywords = implode(',',$request->input('keywords'));
				}
	
				$biz_hours	= '';
				if ( $request->has('biz_hours') ) {
					$hours_str = '';
					$hours_arr = $request->input('biz_hours');
					if( count($hours_arr) ) {
						//for( $i=0;$i<7;$i++ ) {
						for( $i=0;$i<count($hours_arr);$i++ ) {
							if( $hours_arr[$i]['biz_start_hours'] != "" && $hours_arr[$i]['biz_end_hours'] != "" ) {
								$hours_str .= $hours_arr[$i]['biz_days'].' '.date("H.i", strtotime($hours_arr[$i]['biz_start_hours'])).' '.date("H.i", strtotime($hours_arr[$i]['biz_end_hours'])).',';
							}
						}
					}
					if( $hours_str ) {
						$biz_hours	= serialize(array_filter(explode(',', $hours_str)));
					}
				}
				
				$biz_info	= '';
				if ($request->has('biz_info')) {
					$infos	= $request->input('biz_info');
					if( count($infos) ) {
						$array	= array();
						foreach( $infos as $key => $value ) {
							$array[$value['id']] = $value['value'];
						}
						$biz_info = serialize($array);
					}
				}
				
				$latitude	= '';
				if( $request->has('latitude') ) {
					$latitude	=	$request->input('latitude');
				}
				$longitude	= '';
				if( $request->has('longitude') ) {
					$longitude	=	$request->input('longitude');
				}
				
				$array1 = array(
				
					'country_code' 		=> $country_code,
					'user_id' 			=> $user->id,
					'category_id' 		=> $request->input('category_id'),
					'keywords' 			=> $keywords,
					'title' 			=> ucwords($request->input('biz_title')),
					'description' 		=> $request->input('biz_desc'),
					'title_ar' 			=> $request->input('biz_title'),
					'description_ar' 	=> $request->input('biz_desc'),
					'biz_hours' 		=> $biz_hours,
					'phone' 			=> $request->input('phone'),
					'web' 				=> $request->input('website'),
					'address1' 			=> $request->input('address_one'),
					'address2' 			=> $request->input('address_two'),
					'zip' 				=> $request->input('zip_code'),
					'city_id' 			=> $request->input('city_code'),
					'subadmin1_code' 	=> $request->input('location_code'),
					'lat' 				=> $latitude,
					'lon' 				=> $longitude,
					'more_info' 		=> $biz_info,
					'ip_addr' 			=> Ip::get(),
					'activation_token' 	=> md5(uniqid()),
					'active' 			=> (config('settings.require_business_activation') == 1) ? 0 : 1,
		
				);
				$business = new Business($array1);
				$business->save();
				
				/* Save a reference of this Business to database table businessLocations */
				$array2 = array(
				
					'biz_id' 		=> $business->id,
					'address_1' 	=> $request->input('address_one'),
					'address_2' 	=> $request->input('address_two'),
					'phone' 		=> $request->input('phone'),
					'country_id' 	=> $country_code,
					'location_id' 	=> $request->input('location_code'),
					'city_id' 		=> $request->input('city_code'),
					'zip_code' 		=> $request->input('zip_code'),
					'lat' 			=> $latitude,
					'lon' 			=> $longitude,
					'active' 		=> 1,
				);
				$location = new BusinessLocation($array2);
				$location->save();
				
				if( config('settings.require_business_activation') == 1 ) {
					Event::fire(new BusinessWasPosted($business));
				}
				
				$note 			= 	new NotifAll();
				$note->lang		=	$language_code;
				if($language_code=='en'){
					$note->type		=	'Booking';
					$note->title	=	'New Business added Successfully';
				}else {
					$note->type		=	'?????';
					$note->title	=	'??? ????? ???? ????? ???? ?????';
				}
			
				$note->user_id	=	$user->id;
				
				$note->save();
				
				$data['status']		= 	'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Post the business image upload.
		 *
		 * @return Response
		 */
		public function UploadBusinessImage(HttpRequest $request) {
			
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->hasFile('image') ) {
					
					if( $request->has('biz_id') ) {
						
						$file			=	$request->file('image');
						$name			=	$file->getClientOriginalName();
						
						$check = Business::where('id', '=', $request->input('biz_id'))->first();
						if( count($check) ) {
							
							$destination	=	public_path().'/uploads/pictures/business';
							$extension		= 	$file->getClientOriginalExtension();
							$generator		=	time().'.'.$extension;
							$file->move($destination, $generator);
							$filename		=	'uploads/pictures/business/'.$generator;
							
							$newOne				=	new BusinessImage();
							$newOne->biz_id		=	$request->input('biz_id');
							$newOne->filename	=	$filename;
							$newOne->active		= 	1;
							$newOne->save();
						
							$data['status']	= 	'success';
							unset($data['alerts']);
						}	
						else {
							$data['alerts'] =	'business not found.';
						}
					}
					else {
						$data['alerts'] = 'biz_id required.';
					}
				}
				else {
					$data['alerts'] = 'image required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the update business.
		 *
		 * @return Response
		 */
		public function GetUpdateBusiness(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$country_code		=	$user->country_code;
					if( $request->has('country_code') ) {
						$country_code	=	$request->input('country_code');
					}
					
					$language_code		=	'en';
					if( $request->has('language_code') ) {
						$language_code	=	$request->input('language_code');
					}
								
					$categories	= 	DB::table('categories')->select('translation_of as code', 'name')->where('translation_lang', $language_code)->where('parent_id', 0)->where('active', 1)->orderBy('name', 'asc')->get();
					
					$locations	= 	DB::table('subadmin1');
					$cities		=	DB::table('cities');
					if( $language_code == 'ar' ) {
						$locations	=	$locations->select('code as id', 'name as title')->orderBy('name', 'asc');
						$cities		=	$cities->select('id', 'name as title')->orderBy('name', 'asc');
					}
					else {
						$locations	=	$locations->select('code as id', 'asciiname as title')->orderBy('asciiname', 'asc');
						$cities		=	$cities->select('id', 'asciiname as title')->orderBy('asciiname', 'asc');
					}
					$cities		=	$cities->where('country_code', $country_code)->where('active', 1)->get();
					$locations	=	$locations->where('code','LIKE',"%{$country_code}%")->where('active', 1)->get();
				
					$keywords	  	= 	DB::table('categories');
					if( $language_code == 'ar' ) {
						$keywords	= 	$keywords->select('translation_of as id', 'name');
					}
					else {
						$keywords	= 	$keywords->select('id', 'name');
					}
					$keywords		= 	$keywords->where('translation_lang', $language_code)
										->where('active', 1)->orderBy('name', 'asc')->get();
					
					$moreinfo		=	DB::table('businessInfo')->select('translation_of as id', 'info_title as title', 'info_vals as value')->where('translation_lang', $language_code)->where('active', 1)->get();
					if( count($moreinfo) ) {
						foreach( $moreinfo as $fields ) {
							if( $fields->value ) {
								$fields->value = unserialize($fields->value);
							}
						}
					}
					
					$business		=	DB::table('business')->where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
					
						if( $business->keywords ) {
							$business->keywords   = array_filter(explode(",", $business->keywords));
						}
						else {
							$business->keywords = array();
						}
						
						if( $business->biz_hours ) {
							$biz_hours = unserialize($business->biz_hours);
							$hours_arr = array();
							if( count($biz_hours) ) {
								for($i=0;$i<count($biz_hours);$i++) {
									$hours_sub  = explode(" ", $biz_hours[$i]);
									$hours_sup	= array();
									if( count($hours_sub) ) {
										$hours_sup['biz_days'] 			= $hours_sub[0];
										$hours_sup['biz_start_hours'] 	= date("g : i A", strtotime($hours_sub[1]));
										$hours_sup['biz_end_hours'] 	= date("g : i A", strtotime($hours_sub[2]));
									}
									$hours_arr[$i] = $hours_sup;
								}
							}
							$business->biz_hours  = $hours_arr;
						}
						else {
							$business->biz_hours = array();
						}
					
						if( $business->more_info ) {
							$biz_info	= array();
							$more_info  = array_filter(unserialize($business->more_info));
							if( count($more_info) ) {
								foreach( $more_info as $key => $value ) {
									$biz_info[] = array('id' => $key, 'value' => $value);
								}
							}
							$business->more_info = $biz_info;
						}
						else {
							$business->more_info = array();
						}
						
						if( $business->gift_info ) {
							$business->gift_info  = array_filter(unserialize($business->gift_info));
						}
						else {
							$business->gift_info = array();
						}
						
						$biz_images	=	DB::table('businessImages')->select( 'id', 'filename')->where('biz_id', $request->input('biz_id'))->where('active', 1)->get();
						if( count($biz_images) ) {
							$business->biz_images =	$biz_images;
						}
						
						$data['business']		=	$business;
						$data['cities']			=	$cities;
						$data['locations']		=	$locations;						
						$data['keywords']		= 	$keywords;
						$data['categories']		= 	$categories;
						$data['informations']	=	$moreinfo;
						$data['status']			= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the update business.
		 *
		 * @return Response
		 */
		public function PostUpdateBusiness(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$business = Business::where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						
						$country_code		=	$user->country_code;
						if( $request->has('country_code') ) {
							$country_code	=	$request->input('country_code');
						}
							
						$language_code		=	'en';
						if( $request->has('language_code') ) {
							$language_code	=	$request->input('language_code');
						}
					
						$keywords = '';
						if ( $request->has('keywords') ) {
							$kwArr = $request->input('keywords');
							if( count($kwArr) ) {
								$keywords	= implode(',', $kwArr);
							}
						}
			
						$array1 = array(
						
							'country_code' 		=> $country_code,
							'user_id' 			=> $user->id,
							'category_id' 		=> $request->input('category_id'),
							'keywords' 			=> $keywords,
							'title' 			=> $request->input('biz_title'),
							'description' 		=> $request->input('biz_desc'),
							'title_ar' 			=> $request->input('biz_title'),
							'description_ar' 	=> $request->input('biz_desc'),
							'phone' 			=> $request->input('phone'),
							'web' 				=> $request->input('website')
						);
						$business->update($array1);
						
						$data['status']	= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] =	'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the update business hours.
		 *
		 * @return Response
		 */
		public function PostUpdateBusinessHours(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$business = Business::where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						
						$country_code		=	$user->country_code;
						if( $request->has('country_code') ) {
							$country_code	=	$request->input('country_code');
						}
							
						$language_code		=	'en';
						if( $request->has('language_code') ) {
							$language_code	=	$request->input('language_code');
						}
					
						$biz_hours	= '';
						if ($request->has('biz_hours')) {
							$hours_str = '';
							$hours_arr = array_filter($request->input('biz_hours'));
							if( count($hours_arr) ) {
								for( $i=0;$i<7;$i++ ) {
									if( $hours_arr[$i]['biz_start_hours'] != "" && $hours_arr[$i]['biz_end_hours'] != "" ) {
										$hours_str .= $hours_arr[$i]['biz_days'].' '.date("H.i", strtotime($hours_arr[$i]['biz_start_hours'])).' '.date("H.i", strtotime($hours_arr[$i]['biz_end_hours'])).',';
									}
								}
							}
							
							if( $hours_str ) {
								$hours		=	array_filter(explode(',', $hours_str));
								$biz_hours	=	serialize($hours);
							}
						}
						$business->update([ 'biz_hours' => $biz_hours ]);
						
						$data['status']	= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] =	'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the update business informations.
		 *
		 * @return Response
		 */
		public function PostUpdateBusinessInfos(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$business = Business::where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						
						$country_code		=	$user->country_code;
						if( $request->has('country_code') ) {
							$country_code	=	$request->input('country_code');
						}
							
						$language_code		=	'en';
						if( $request->has('language_code') ) {
							$language_code	=	$request->input('language_code');
						}
						
				
						$biz_infos	= '';
						if ($request->has('biz_infos')) {
							$infos	= $request->input('biz_infos');
							if( count($infos) ) {
								$array	= array();
								foreach( $infos as $key => $value ) {
									$array[$value['id']] = $value['value'];
								}
								$biz_infos = serialize($array);
							}
						}
						$business->update([ 'more_info' => $biz_infos ]);
						
						$data['status']	= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] =	'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the update business.
		 *
		 * @return Response
		 */
		public function PostUpdateBusinessBasic(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$business = Business::where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						
						$country_code		=	$user->country_code;
						if( $request->has('country_code') ) {
							$country_code	=	$request->input('country_code');
						}
							
						$language_code		=	'en';
						if( $request->has('language_code') ) {
							$language_code	=	$request->input('language_code');
						}
					
						$array = array(
							'address1' 			=> $request->input('address_one'),
							'address2' 			=> $request->input('address_two'),
							'zip' 				=> $request->input('zip_code'),
							'city_id' 			=> $request->input('city_code'),
							'subadmin1_code' 	=> $request->input('location_code'),
							'lat' 				=> $request->input('latitude'),
							'lon' 				=> $request->input('longitude')
						);
						$business->update($array);
						
						if( $request->has('location_code') && $request->has('city_code') ) {
							$location = BusinessLocation::where('biz_id', $request->input('biz_id'))->where('location_id', $request->input('location_code'))->where('city_id', $request->input('city_code'))->first();
							if( count($location) ) {
								$array2 = array(
								
									'address_1' 	=> $request->input('address_one'),
									'address_2' 	=> $request->input('address_two'),
									'phone' 		=> $business->phone,
									'country_id' 	=> $country_code,
									'location_id' 	=> $request->input('location_code'),
									'city_id' 		=> $request->input('city_code'),
									'zip_code' 		=> $request->input('zip_code'),
									'lat' 			=> $request->input('latitude'),
									'lon' 			=> $request->input('longitude')
								);
								$location->update($array2);
							}
						}
						
						$data['status']	= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] =	'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the delete business.
		 *
		 * @return Response
		 */
		public function PostDeleteBusiness(HttpRequest $request)
		{
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					//$business = Business::findorFail($request->input('biz_id'));
					 $business = \DB::table('business')->where('id',$request->input('biz_id'))
											->where('user_id',$user->id)
											->first(); 
					
					if( count($business)>0 ) {
						\DB::table('business')->where('id',$request->input('biz_id'))
											->where('user_id',$user->id)
											->delete();
						$data['status'] = 'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}	
			}
			return json_encode($data);
		}
		
		/**
		 * Get the gift certificate.
		 *
		 * @return Response
		 */
		public function GetCreateCertificate(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$check = DB::table('business')->where('id', $request->input('biz_id'))->first();
					if( count($check) ) {
						
						if( $check->gifting ) {
							
							$country_code		=	$user->country_code;
							if( $request->has('country_code') ) {
								$country_code	=	$request->input('country_code');
							}
							
							if( $country_code ) {
								$data['currency']	=	DB::table('countries')
														->select('countries.currency_code', 'currencies.html_entity')
														->leftjoin('currencies', 'countries.currency_code', '=', 'currencies.code')
														->where('countries.code', $country_code)
														->first();
							}
							
							$language_code		=	'en';
							if( $request->has('language_code') ) {
								$language_code	=	$request->input('language_code');
							}
							
							$business			=	DB::table('business')
													->leftjoin('cities', 'business.city_id', '=', 'cities.id');
							if( $language_code == 'ar' ) {
								$business		=	$business->select('business.*', 'cities.name as city_name');
							}
							else {
								$business		=	$business->select('business.*', 'cities.asciiname as city_name');
							}
							$business			=	$business->where('business.country_code', $country_code)->where('business.id', $request->input('biz_id'))->first();
							
							$prices				=	DB::table('gift_price')->select('id', 'price')->where('country', 'DEFLT')->where('active', 1)->get();
							if( count($business) ) {
								if( $business->gift_info ) {
									$array1			=	array_filter(unserialize($business->gift_info));
									$array2			=	$prices;
									if( count($array1) && count($array2) ) {
										$prices		=	array();
										foreach( $array2 as $value ) {
											if( in_array($value->id, $array1) ) {
												$prices[] = $value;
											}
										}
									}
								}
							}
							
							$data['business']	=	$business;
							$data['prices']		=	$prices;
							$data['status']		= 	'success';
							unset($data['alerts']);
						}
						else {
							$data['alerts'] = 'gift certificate not available for this business.';
						}
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the gift certificate.
		 *
		 * @return Response
		 */
		public function PostCreateCertificate(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$business 	= 	DB::table('business')
									->select('business.*', 'businessImages.filename')
									->leftjoin('businessImages', 'business.id', '=', 'businessImages.biz_id')
									->where('business.id', $request->input('biz_id'))
									->where('businessImages.active', 1)
									->latest()->first();
								
					if( count($business) ) {
						
						if( $business->gifting ) {
							
							$country_code		=	$user->country_code;
							if( $request->has('country_code') ) {
								$country_code	=	$request->input('country_code');
							}
							
							$language_code		=	'en';
							if( $request->has('language_code') ) {
								$language_code	=	$request->input('language_code');
							}
							
							if( $request->has('biz_loc_id') ) {
								
								$location =	DB::table('businessLocations')
											->select('cities.name', 'cities.asciiname')
											->leftjoin('cities', 'businessLocations.city_id', '=', 'cities.id')
											->where('businessLocations.id', $request->input('biz_loc_id'))
											->first();
											
								if( count($location) ) {
									
									if( $language_code == 'ar' ) {
										$biz_title		= $business->title_ar;
										$biz_location	= $location->name;
									}
									else {
										$biz_title		= $business->title;
										$biz_location	= $location->asciiname;
									}
				
									if( $request->has('gift_quantity') ) {
										
										if( $request->has('gift_amount') ) {
											
											$url 			= 'http://www.howlik.com/api/giftpay/index.php';
											unset($_POST['recipient_name']);
											unset($_POST['recipient_email']);
											unset($_POST['recipient_message']);
											unset($_POST['sender_name']);
											$post			= $_POST;
											$response		= Curl::curl_fetch($url, $refUrl = '');
											
											$data['status'] = 'success';
											unset($data['alerts']);
										}
										else {
											$data['alerts'] = 'the gift_amount is required.';
										}
									}
									else {
										$data['alerts'] = 'the gift_quantity is required.';
									}
								}
								else {
									$data['alerts'] = 'business location not found.';
								}
							}
							else {
								$data['alerts'] = 'the biz_loc_id is required.';
							}
						}
						else {
							$data['alerts'] = 'gift purchase not available.';
						}
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Send the gift certificate.
		 *
		 * @return Response
		 */
		public function GetSendCertificate(HttpRequest $request) {
			
			$pay_id		=	$request->segment(3);
			$paypal		=	PaypalLog::where('id', $pay_id)->where('pl_status', '1')->first();
			
			/* Unserialize the details */
			if( count($paypal) ) {
				$data	=	unserialize($paypal['pl_details']);
			}
			
			/* Business the details */
			if( count($data) ) {
				$business	=	DB::table('business')
								->select('business.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname')
								->leftjoin('cities', 'business.city_id', '=', 'cities.id')
								->where('business.id', $data['biz_id'])
								->first();
			}
			
			/* get location details from session if exist */
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
			
			/* Store New Gift Certificate */
			if( count($data) ) {
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
			
			/* Store New Gift Recipient */
			if( count($data) ) {
				
				$total	=	$data['gift_quantity'];
				if( $total ) {
					
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
		
		/**
		 * Get the offer create.
		 *
		 * @return Response
		 */
		public function GetCreateOffer(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$country_code		=	'IN';
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				if( $request->has('biz_id') ) {
					
					$data['offers']		=	DB::table('businessOffers')->where('biz_id', $request->input('biz_id'))->where('active', 1)->get();
					$data['types']		=	DB::table('offer_type')->select('translation_of', 'title')->where('translation_lang', $language_code)->where('active', 1)->get();
					$data['apikey']		=	$request->input('apikey');
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the offer create.
		 *
		 * @return Response
		 */
		public function PostCreateOffer(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$array = array(
					
						'biz_id'	=>	$request->input('biz_id'),
						'offertype'	=>	$request->input('offer_type'),
						'percent'	=>	$request->input('offer_percent'),
						'content'	=>	$request->input('offer_content'),
						'details'	=>	$request->input('offer_desc'),
						'active'	=>	1
					);
					$offer = new BusinessOffer($array);
					$offer->save();
					
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the offer update.
		 *
		 * @return Response
		 */
		public function GetUpdateOffer(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$country_code		=	$user->country_code;
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				if( $request->has('offer_id') ) {
					
					$offer	=	BusinessOffer::where('id', $request->input('offer_id'))->first();
					if( count($offer) ) {
					
						$data['offer']		=	$offer;
						$data['types']		=	DB::table('offer_type')->select('translation_of', 'title')->where('translation_lang', $language_code)->where('active', 1)->get();
						$data['apikey']		=	$request->input('apikey');
						$data['status']		= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'offer not found.';
					}
				}
				else {
					$data['alerts'] = 'the offer_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the offer update.
		 *
		 * @return Response
		 */
		public function PostUpdateOffer(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('offer_id') ) {
					
					$offer = BusinessOffer::where('id', $request->input('offer_id'))->first();
					if( count($offer) ) {
						$array = array(
						
							'offertype'	=>	$request->input('offer_type'),
							'percent'	=>	$request->input('offer_percent'),
							'content'	=>	$request->input('offer_content'),
							'details'	=>	$request->input('offer_desc')
						);
						$offer->update($array);
					
						$data['status']		= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'offer not found.';
					}
				}
				else {
					$data['alerts'] = 'the offer_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the offer delete.
		 *
		 * @return Response
		 */
		public function PostDeleteOffer(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('offer_id') ) {
					
					$offer = BusinessOffer::where('id', $request->input('offer_id'))->first();
					if( count($offer) ) {
						
						$offer->delete();
						
						$data['status']	=	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'offer not found.';
					}
				}
				else {
					$data['alerts'] = 'the offer_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the business reservation.
		 *
		 * @return Response
		 */
		public function GetReserveTimeSlot(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$country_code		=	$user->country_code;
				if( $request->has('language_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				$today_dt = Carbon::now();
				$tomorrow = Carbon::tomorrow();
				$timezone = DB::table('time_zones')->where('country_code', $country_code)->first();
				if( count($timezone) ) {
					$today_dt = Carbon::now($timezone->time_zone_id);
					$tomorrow = Carbon::tomorrow($timezone->time_zone_id);
				}
				
				if( $request->has('biz_id') ) {
					
					$business	=	DB::table('business')->where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						
						$biz_id =	$request->input('biz_id');
						if( $business->booking ) {
							
							$data['type']		=	$business->booking_type;
							if( $business->booking_type == 3 ) {
								
								$data['name']	=	'Time Slot Booking';
								$informations	=	DB::select( DB::raw("SELECT bbs.id as tsb_id, bbs.*,
													(SELECT COUNT(id) as booking FROM businessTimeslotBooking btb WHERE btb.time_id=bbs.id AND created_at BETWEEN '$today_dt' AND '$tomorrow') as booking
													FROM businessBookingTmSettings bbs WHERE bbs.biz_id = '$biz_id' ORDER BY bbs.tm_from") );
								
								if( count($informations) ) {
										
									$timenow = date("H.i", strtotime($today_dt));
									foreach( $informations as $key => $field ) {
										
										$field->status = 1;
										$field->alerts = "proceed";
										if( $field->tm_from <= $timenow ) {
											$field->status = 0;
											$field->alerts = "passed";
										}
										if( $field->tm_from ) {
											$field->tm_from = date('h:i A', strtotime($field->tm_from));
										}
										if( $field->tm_to ) {
											$field->tm_to = date('h:i A', strtotime($field->tm_to));
										}
										/* else if( $field->booking <= $field->slots ) {
											$field->status = 2;
											$field->alerts = "filled";
										} */
									}
								}
								
								$data['info'] 	=	$informations;
								$data['status'] = 	'success';
								unset($data['alerts']);
							}
							else {
								$data['alerts'] = 'type not matched.';
							}
						}
						else {
							$data['alerts'] = 'reservation not available.';
						}
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the business reservation.
		 *
		 * @return Response
		 */
		public function PostReserveTimeSlot(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$country_code		=	$user->country_code;
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				$currency	= 	DB::table('countries')->select('currencies.*')
								->leftjoin('currencies', 'countries.currency_code', '=', 'currencies.code')
								->where('countries.code', $country_code)->first();
				
				$today_dt = Carbon::now();
				$tomorrow = Carbon::tomorrow();
				$timezone = DB::table('time_zones')->where('country_code', $country_code)->first();
				if( count($timezone) ) {
					$today_dt = Carbon::now($timezone->time_zone_id);
					$tomorrow = Carbon::tomorrow($timezone->time_zone_id);
				}
				
				if( $request->has('biz_id') ) {
					
					$business	=	DB::table('business')->where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						if( $business->booking ) {
							
							if( $business->booking_type == 3 ) {
							
								$tsbid 		= $request->input('tsb_id');
								$tb_name	= $request->input('tsb_name');
								$tb_email 	= $request->input('tsb_email');
								$tb_mobile 	= $request->input('tsb_mobile');
								$tb_message = $request->input('tsb_message');
								 
								$bbtsSettings 			= BusinessBookingTmSettings::where('id', $tsbid)->first();
								$extraInfoA['time'] 	= $bbtsSettings->tm_from.'-'.$bbtsSettings->tm_to;
								$extraInfoA['price'] 	= $bbtsSettings->price;
								$extraInfoA['cur'] 		= array(
															'code' 	=> 	$currency->code, 
															'html'	=>	$currency->html_entity
														  );
														  
								$biz_id = $business->id;
								
								// get location details from session if exist
								$biz_loc 	= $request->input('biz_loc');
								$location 	= '';
								if( $biz_loc ) {
									$loc_arr	=	DB::table('businessLocations')
													->select('businessLocations.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname', 'subadmin1.name as loname', 'subadmin1.asciiname as loasciiname', 'countries.name as coname', 'countries.asciiname as coasciiname', 'countries.phone as tele')
													->leftjoin('cities', 'businessLocations.city_id', '=', 'cities.id')
													->leftjoin('subadmin1', 'businessLocations.location_id', '=', 'subadmin1.code')
													->leftjoin('countries', 'businessLocations.country_id', '=', 'countries.code')
													->where('businessLocations.biz_id', $biz_id)
													->where('businessLocations.id', $biz_loc)
													->where('businessLocations.active', 1)
													->orderBy('businessLocations.created_at', 'asc')
													->get();
									if( count($loc_arr) ) {
										$location	=	serialize($loc_arr);
									}
								}
								
								$bookOrder 				= new BusinessBookingOrder();
								$bookOrder->settings_id = $tsbid;
								$bookOrder->biz_id 		= $biz_id;
								$bookOrder->biz_loc 	= $location;
								$bookOrder->user_id 	= $user->id;
								$bookOrder->extraInfo 	= serialize($extraInfoA);
								$bookOrder->name 		= $tb_name;
								$bookOrder->email 		= $tb_email;
								$bookOrder->mobile 		= $tb_mobile;
								$bookOrder->notes 		= $tb_message;
								$bookOrder->book_date 	= date("Y-m-d", strtotime($today_dt));
								$bookOrder->created_at 	= $today_dt;
								$bookOrder->save();
								
								/* BOF Notification email to business owner */
								$biz_owner 			= User::select('name', 'email')->where('id', $business->user_id)->first();
								$subject 			= 'Howlik: New business reservation'.' '.date('m/d/Y h:i A', time());
								$pass['subject']	= $subject;
								$pass['email'] 		= $biz_owner->email;
								$pass['name'] 		= $biz_owner->name;
								$link    			= "/".str_replace(' ', '-', $business->title)."/".$business->id.".html";
								
								$template['biz_owner'] 		= $biz_owner->name;
								$template['biz_link'] 		= "<a href='".lurl($link)."' target='_blank'>".$business->title."</a>";
								$template['your_orders'] 	= "<a href='".lurl('account/businessbooking/'.$business->id)."' target='_blank'>".trans('mail.Your Orders')."</a>";
								$template['site_url'] 		= "<a href='".lurl('/')."' target='_blank'>Howlik.com</a>";
								
								Mail::send('emails.business.bookinginfo', ['title' => $subject, 'template' => $template], function ($m) use ($pass) {
									$m->to($pass['email'], $pass['name'])->subject($pass['subject']);
								});
								/* EOF Notification email to business owner */
								
								/* BOF GCM Notification */
								$eventParetUser = User::where('id', $business->user_id)->first(); 
								if(count($eventParetUser)) {
									//Notification
										  $contents 						= array();
										  $title                            = "New Booking"; 
										  $message_content  				= 'Booking a business';
										  $contents['data']['title']        = $title;
										  $contents['data']['message']      = $message_content;
										  $contents['data']['popup_type']   = 'message';
										  $msg	  = $contents;
										 
									if($eventParetUser->gcm_token !='') {
										  $to 	  = $eventParetUser->gcm_token;
										  $this->sendPushNotification($to,$msg);
									}
									if($eventParetUser->ios_token !='')
									{
										  $to 	  = $eventParetUser->ios_token;
										  $this->sendIOsPushNotification($to,$msg);
									}
									 //Notification
								}
								/* EOF GCM Notification */
								
								$data['status']		= 	'success';
								unset($data['alerts']);
							}
							else {
								$data['alerts'] = 'type not found.';
							}
						}
						else {
							$data['alerts'] = 'reservation not available.';
						}
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the business reservation.
		 *
		 * @return Response
		 */
		public function GetReserveTable(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$country_code		=	$user->country_code;
				if( $request->has('language_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				$today_dt = Carbon::now();
				$tomorrow = Carbon::tomorrow();
				$timezone = DB::table('time_zones')->where('country_code', $country_code)->first();
				if( count($timezone) ) {
					$today_dt = Carbon::now($timezone->time_zone_id);
					$tomorrow = Carbon::tomorrow($timezone->time_zone_id);
				}
				
				if( $request->has('biz_id') ) {
					
					$business	=	DB::table('business')->where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						if( $business->booking ) {
							
							$data['type']		=	$business->booking_type;
							if( $business->booking_type == 5 ) {
								
								$data['name']	=	'Table Booking';
								$data['info'] 	=	BusinessBookingTblSettings::select(DB::raw('min(tbl_from) as min_time, max(tbl_to) as max_time, min(seat_min) as min_seat, max(seat_max) as max_seat'))->where('biz_id', $business->id)->get();
						
								$data['status']	= 	'success';
								unset($data['alerts']);
							}
							else {
								$data['alerts'] = 'type not matched.';
							}
						}
						else {
							$data['alerts'] = 'reservation not available.';
						}
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		function CheckReserveTable(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$business	=	DB::table('business')->where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						
						if( $request->input('sr_date') ) {
						
							if( $request->input('sr_time') ) {
						
								if( $request->input('sr_people') ) {
							
									$sr_date 	= 	date('Y-m-d', strtotime($request->input('sr_date')));
									$sr_time 	= 	date('H.i', strtotime($request->input('sr_time')));
									$sr_people 	= 	$request->input('sr_people');
									$biz_id 	= 	$request->input('biz_id');
									
									$model 		= 	BusinessBookingTblSettings::select('id', 'tbl_table')
													->where('biz_id', $biz_id)
													->where('tbl_from', '<=', $sr_time)
													->where('tbl_to', '>=', $sr_time)
													->where('seat_min', '<=', $sr_people)
													->where('seat_max', '>=', $sr_people)
													->first();
												
									if( count($model) ) {
										
										$data['tsbid'] 	= 	$model->id;
										$dt_from 		= 	$sr_date.' 00:00:00';
										$dt_to 			= 	$sr_date.' 23:59:59';
										$bookingCount 	=	BusinessBookingOrder::where('settings_id', $model->id)
															->where('biz_id', $biz_id)
															->whereBetween('book_date', [$dt_from, $dt_to])
															->count();
															
										if( $bookingCount < $model->tbl_table ) {
											$data['status'] = 'success';
											unset($data['alerts']);
										}
										else {
											$data['alerts'] = 'reached maximum no.of booking.';
										}
									}
									else {
										$data['alerts'] = 'booking not available.';
									}
								}
								else {
									$data['alerts'] = 'sr_people required.';
								}
							}
							else {
								$data['alerts'] = 'sr_time required.';
							}
						}
						else {
							$data['alerts'] = 'sr_date required.';
						}
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'biz_id required.';
				}
			}
			return json_encode($data);
		}
	
		/**
		 * Post the business reservation.
		 *
		 * @return Response
		 */
		public function PostReserveTable(HttpRequest $request) {
			
			
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$country_code		=	$user->country_code;
				if( $request->has('language_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				$currency	= 	DB::table('countries')->select('currencies.*')
								->leftjoin('currencies', 'countries.currency_code', '=', 'currencies.code')
								->where('countries.code', $country_code)->first();
				
				$today_dt = Carbon::now();
				$tomorrow = Carbon::tomorrow();
				$timezone = DB::table('time_zones')->where('country_code', $country_code)->first();
				if( count($timezone) ) {
					$today_dt = Carbon::now($timezone->time_zone_id);
					$tomorrow = Carbon::tomorrow($timezone->time_zone_id);
				}
				
				if( $request->has('biz_id') ) {
					
					$business	=	DB::table('business')
									->where('id', $request->input('biz_id'))
									->first();
									
					if( count($business) ) {
						if( $business->booking ) {
							
							if( $business->booking_type == 5 ) {
							
								$extraInfoA = array();
								
								$tsbid 		= $request->input('tsb_id');
								$tb_name 	= $request->input('tsb_name');
								$tb_email 	= $request->input('tsb_email');
								$tb_mobile 	= $request->input('tsb_mobile');
								$tb_message = $request->input('tsb_message');
								$sr_date 	= date('Y-m-d', strtotime($request->input('sr_date')));
								$sr_time 	= date('H.i', strtotime($request->input('sr_time')));
								$sr_people 	= $request->input('sr_people');
								
								$biz_id 			= $business->id;
								$biz_loc 			= $request->input('biz_loc');
								$bbTblSettings 		= BusinessBookingTblSettings::where('id', $tsbid)->first();
								if( count($bbTblSettings) ) {
									
									$extraInfoA['time'] 	 = $bbTblSettings->tbl_from.'-'.$bbTblSettings->tbl_to;
									$extraInfoA['seat'] 	 = $bbTblSettings->seat_min.'-'.$bbTblSettings->seat_max;
									$extraInfoA['sr_date'] 	 = $sr_date;
									$extraInfoA['sr_time'] 	 = $sr_time;
									$extraInfoA['sr_people'] = $sr_people;
								}
								
								$location = '';
								if( $biz_loc ) {
									$loc_arr	=	DB::table('businessLocations')
													->select('businessLocations.*', 'cities.name as ciname', 'cities.asciiname as ciasciiname', 'subadmin1.name as loname', 'subadmin1.asciiname as loasciiname', 'countries.name as coname', 'countries.asciiname as coasciiname', 'countries.phone as tele')
													->leftjoin('cities', 'businessLocations.city_id', '=', 'cities.id')
													->leftjoin('subadmin1', 'businessLocations.location_id', '=', 'subadmin1.code')
													->leftjoin('countries', 'businessLocations.country_id', '=', 'countries.code')
													->where('businessLocations.biz_id', $biz_id)
													->where('businessLocations.id', $biz_loc)
													->where('businessLocations.active', 1)
													->orderBy('businessLocations.created_at', 'asc')
													->get();
									if( count($loc_arr) ) {
										$location	=	serialize($loc_arr);
									}
								}
								
								$bookOrder 				= new BusinessBookingOrder();
								$bookOrder->settings_id = $tsbid;
								$bookOrder->biz_id 		= $biz_id;
								$bookOrder->biz_loc 	= $location;
								$bookOrder->book_type 	= 5;
								$bookOrder->user_id 	= $user->id;
								$bookOrder->extraInfo 	= serialize($extraInfoA);
								$bookOrder->name 		= $tb_name;
								$bookOrder->email 		= $tb_email;
								$bookOrder->mobile 		= $tb_mobile;
								$bookOrder->notes 		= $tb_message;
								$bookOrder->book_date 	= $sr_date;
								$bookOrder->created_at 	= $today_dt;
								$bookOrder->save();
								
								/* BOF Notification email to business owner */
								$biz_owner 			= User::select('name', 'email')->where('id', $business->user_id)->first();
								$subject 			= trans('mail.Howlik: New business reservation').' '.date('m/d/Y h:i A', time());
								$pass['subject']	= $subject;
								$pass['email'] 		= $biz_owner->email;
								$pass['name'] 		= $biz_owner->name;
								$link    			= "/".str_replace(' ', '-', $business->title)."/".$business->id.".html";
								
								$template['biz_owner'] 		= $biz_owner->name;
								$template['biz_link'] 		= "<a href='".lurl($link)."' target='_blank'>".$business->title."</a>";
								$template['your_orders'] 	= "<a href='".lurl('account/businessbooking/'.$business->id)."' target='_blank'>".trans('mail.Your Orders')."</a>";
								$template['site_url'] 		= "<a href='".lurl('/')."' target='_blank'>Howlik.com</a>";
								
								Mail::send('emails.business.bookinginfo', ['title' => $subject, 'template' => $template], function ($m) use ($pass) {
									$m->to($pass['email'], $pass['name'])->subject($pass['subject']);
								});
								/* EOF Notification email to business owner */
								/* BOF GCM Notification */
								$eventParetUser = User::where('id', $business->user_id)->first(); 
								if(count($eventParetUser)) {
									//Notification
										  $contents 						= array();
										  $title                            = "New Booking"; 
										  $message_content  				= 'Booking a business Table';
										  $contents['data']['title']        = $title;
										  $contents['data']['message']      = $message_content;
										  $contents['data']['popup_type']   = 'message';
										  $msg	  = $contents;
										 
									if($eventParetUser->gcm_token !='') {
										  $to 	  = $eventParetUser->gcm_token;
										 $this->sendPushNotification($to,$msg);
									}
									if($eventParetUser->ios_token !='')
									{
										  $to 	  = $eventParetUser->ios_token;
										  $this->sendIOsPushNotification($to,$msg);
									}
									 //Notification
								}
								/* EOF GCM Notification */
								$data['status']		= 	'success';
								unset($data['alerts']);
							}
							else {
								$data['alerts'] = 'type not found.';
							}
						}
						else {
							$data['alerts'] = 'reservation not available.';
						}
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the owned business bookings.
		 *
		 * @return Response
		 */
		public function GetOwnBusinessBooking(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$language_code		=	'en';
					if( $request->has('language_code') ) {
						$language_code	=	$request->input('language_code');
					}
					
					$query		=	DB::table('businessBookingOrder as bk');
					if( $language_code == 'ar' ) {
						$query	=	$query->select('bk.*', 'b.title_ar as title', 'b.country_code', 'c.name as city_name', 'bb.title as type_name');
					}
					else {
						$query	=	$query->select('bk.*', 'b.title', 'b.country_code', 'c.asciiname as city_name', 'bb.title as type_name');
					}	
					$query		=	$query->join('business as b', 'b.id','=', 'bk.biz_id')
									->join('cities as c', 'c.id', '=', 'b.city_id')
									->join('businessBooking as bb', 'b.booking_type', '=', 'bb.id')
									->where('bk.biz_id', $request->input('biz_id'))
									->where('b.user_id', $user->id)
									->orderBy('bk.created_at', 'desc')			
									->get();
					
					if( count($query) ) {
						
						foreach( $query as $field ) {
							
							if( $field->biz_loc ) {
								$field->biz_loc = unserialize($field->biz_loc);
							}
							if( $field->extraInfo ) {
								$resArr = array();
								 /* commented on 18-04-2017 YK
									$field->extraInfo = unserialize($field->extraInfo);
								 */
								//START 18-04-2017 ADDED BY YK								 
								$resArr['time'] ='';
								$resArr['price'] ='';
								$resArr['seat'] ='';
								$resArr['sr_date'] ='';
								$resArr['sr_time'] ='';
								$resArr['sr_people'] ='';
								$resArr['code'] ='';
								$resArr['html'] ='';
								$resArr['symbol'] ='';
								$extrArr = unserialize($field->extraInfo);
								
								if(isset($extrArr['time'])){
									$resArr['time']  = $extrArr['time']; }
								if(isset($extrArr['price'])){
									$resArr['price'] = $extrArr['price']; } 
								if(isset($extrArr['seat'])){
									$resArr['seat'] = $extrArr['seat']; }
								if(isset($extrArr['sr_date'])){
									$resArr['sr_date'] = $extrArr['sr_date']; }  
								if(isset($extrArr['sr_time'])){
									$resArr['sr_time'] = $extrArr['sr_time']; }  
								if(isset($extrArr['sr_people'])){
									$resArr['sr_people'] = $extrArr['sr_people']; }
								if(isset($extrArr['cur']) && isset($extrArr['cur']['code'])){
									$resArr['code'] = $extrArr['cur']['code']; }
								if(isset($extrArr['cur']) && isset($extrArr['cur']['html'])){
									$resArr['html'] = $extrArr['cur']['html']; }
								if(isset($extrArr['cur']) && isset($extrArr['cur']['symbol'])){
									$resArr['symbol'] = $extrArr['cur']['symbol']; }
								$field->extraInfo = $resArr;
								//END YK
							}
							if( $field->book_date ) {
								$field->book_date = date("d-m-Y", strtotime($field->book_date));
							}
							if( $field->title ) {
								$field->title = ucwords($field->title);
							}
							if( $field->name ) {
								$field->name = ucwords($field->name);
							}
						}
					}
					
					$data['booking']	= $query;
					$data['status']		= 'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the other business bookings.
		 *
		 * @return Response
		 */
		public function GetMyBusinessBooking(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$query		=	DB::table('businessBookingOrder as bk');
				if( $language_code == 'ar' ) {
					$query	=	$query->select('bk.*', 'b.title_ar as title', 'b.country_code', 'c.name as city_name', 'bb.title as type_name');
				}
				else {
					$query	=	$query->select('bk.*', 'b.title', 'b.country_code', 'c.asciiname as city_name', 'bb.title as type_name');
				}	
				$query		=	$query->join('business as b', 'b.id','=', 'bk.biz_id')
								->join('cities as c', 'c.id', '=', 'b.city_id')
								->join('businessBooking as bb', 'b.booking_type', '=', 'bb.id')
								->where('bk.user_id', $user->id)
								->orderBy('bk.created_at', 'desc')			
								->get();
				
				if( count($query) ) {
					
					foreach( $query as $field ) {
						
						if( $field->biz_loc ) {
							$field->biz_loc   = unserialize($field->biz_loc);
						}
						if( $field->extraInfo ) {
						
							/* commented on 18-04-2017 YK
									$field->extraInfo = unserialize($field->extraInfo);
								 */
								//START 18-04-2017 ADDED BY YK								 
								$resArr['time'] ='';
								$resArr['price'] ='';
								$resArr['seat'] ='';
								$resArr['sr_date'] ='';
								$resArr['sr_time'] ='';
								$resArr['sr_people'] ='';
								$resArr['code'] ='';
								$resArr['html'] ='';
								$resArr['symbol'] ='';
								$extrArr = unserialize($field->extraInfo);
								
								if(isset($extrArr['time'])){
									$resArr['time']  = $extrArr['time']; }
								if(isset($extrArr['price'])){
									$resArr['price'] = $extrArr['price']; } 
								if(isset($extrArr['seat'])){
									$resArr['seat'] = $extrArr['seat']; }
								if(isset($extrArr['sr_date'])){
									$resArr['sr_date'] = $extrArr['sr_date']; }  
								if(isset($extrArr['sr_time'])){
									$resArr['sr_time'] = $extrArr['sr_time']; }  
								if(isset($extrArr['sr_people'])){
									$resArr['sr_people'] = $extrArr['sr_people']; }
								if(isset($extrArr['cur'])){
									$resArr['code'] = $extrArr['cur']['code']; }
								if(isset($extrArr['cur'])){
									$resArr['html'] = $extrArr['cur']['html']; }
								$field->extraInfo = $resArr;
								//END YK
							
							
						}
						if( $field->book_date ) {
							$field->book_date = date("d-m-Y", strtotime($field->book_date));
						}
						if( $field->title ) {
							$field->title 	  = ucwords($field->title);
						}
						if( $field->name ) {
							$field->name 	  = ucwords($field->name);
						}
					}
				}
					
				$data['booking']	= $query;
				$data['status']		= 'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Get the owned events bookings.
		 *
		 * @return Response
		 */
		public function GetOwnEventsBooking(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('event_id') ) {
					
					$country_code		=	$user->country_code;
					if( $request->has('country_code') ) {
						$country_code	=	$request->input('country_code');
					}
					
					$language_code		=	'en';
					if( $request->has('language_code') ) {
						$language_code	=	$request->input('language_code');
					}
					
					$query	=	DB::table('event_tickets as et')
								->select('e.event_name', 'e.event_date', 'e.event_starttime', 'e.eventEnd_date', 'e.event_endtime', 'et.*', 'users.name as user_name')
								->leftjoin('events as e', 'et.event_id', '=', 'e.id')
								->leftjoin('users', 'et.user_id', '=', 'users.id');
								
					if( $request->has('country_code') ) {
						
						$query->where('e.country_code', $country_code);
					}			
					
					$query = $query->where('et.event_id', $request->input('event_id'))
								->orderBy('et.created_at', 'desc')
								->get();
					
					if( count($query) ) {
						
						foreach( $query as $field ) {
							
							if( $field->event_name ) {
								$field->event_name = ucwords($field->event_name);
							}
							if( $field->event_date ) {
								$field->event_date = date('d-m-Y', strtotime($field->event_date));
							}
							if( $field->event_starttime ) {
								$field->event_starttime = date('h:i A', strtotime($field->event_starttime));
							}
							if( $field->eventEnd_date ) {
								$field->eventEnd_date = date('d-m-Y', strtotime($field->eventEnd_date));
							}
							if( $field->event_endtime ) {
								$field->event_endtime = date('h:i A', strtotime($field->event_endtime));
							}
						}
					}
				
					$data['booking']	= 	$query;
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the event_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the other events bookings.
		 *
		 * @return Response
		 */
		public function GetMyEventsBooking(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$country_code		=	$user->country_code;
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				$query	=	DB::table('event_tickets as et')
							->select('e.event_name', 'e.event_date', 'e.event_starttime',
							'e.eventEnd_date', 'e.event_endtime', 'et.*')
							->leftjoin('events as e', 'et.event_id', '=', 'e.id')
							->where('et.user_id', $user->id);
				 if( $request->has('country_code') ) {
					$query->where('e.country_code', $country_code);
				}			
				$query = 	$query->orderBy('et.created_at', 'desc')
							->get();
				
				if( count($query) ) {
					
					foreach( $query as $field ) {
						
						if( $field->event_name ) {
							$field->event_name = ucwords($field->event_name);
						}
						if( $field->event_date ) {
							$field->event_date = date('d-m-Y', strtotime($field->event_date));
						}
						if( $field->event_starttime ) {
							$field->event_starttime = date('h:i A', strtotime($field->event_starttime));
						}
						if( $field->eventEnd_date ) {
							$field->eventEnd_date = date('d-m-Y', strtotime($field->eventEnd_date));
						}
						if( $field->event_endtime ) {
							$field->event_endtime = date('h:i A', strtotime($field->event_endtime));
						}
					}
				}
				
				$data['booking']	= $query;
				$data['status']		= 'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Get the owned gift purchases.
		 *
		 * @return Response
		 */
		public function GetOwnGiftPurchases(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					$confirm	= DB::table('business')->where('id', $request->input('biz_id'))->where('user_id', $user->id)->first();
					if( count($confirm) ) {
						$array				=	GiftCertificate::where('biz_id', $request->input('biz_id'))
												->where('active', '1')->orderBy('created_at', 'desc')->get();
						
						$data['booking']	= 	$array;
						$data['status']		= 	'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'disowned business.';
					}
				}
				else {
					$data['alerts'] = 'the biz_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Get the other gift purchases.
		 *
		 * @return Response
		 */
		public function GetMyGiftPurchases(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$country_code		=	$user->country_code;
				if( $request->has('country_code') ) {
					$country_code	=	$request->input('country_code');
				}
				
				if( $user->user_type_id > 2 ) {
		
					$array	=	DB::table('gift_recipients as gr')
								->select('gr.*', 'b.title', 'b.country_code', 'gc.each_price')
								->leftjoin('gift_certificates as gc', 'gr.gift_id', '=', 'gc.id')
								->leftjoin('business as b', 'gr.biz_id', '=', 'b.id')
								->where('gr.recipient_email', $user->email)
								->where('b.country_code', $country_code)
								->orderBy('gr.created_at', 'desc')
								->get();
				}
				else {
					
					$array	=	DB::table('gift_certificates as gc')
								->select('gc.*','b.title')
								->leftjoin('business as b', 'gc.biz_id', '=', 'b.id')
								->where('b.country_code', $country_code)
								->where('b.gifting', 1)
								->where('gc.user_id', $user->id)
								->orderBy('gc.created_at', 'desc')
								->groupBy('b.title')
								->get();
				}
				
				$data['booking']	= $array;
				$data['status']		= 'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		
		
		/**
		 * Enable/Disable the business bookings.
		 *
		 * @return Response
		 */
		public function BizBookingStatus(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$status = 0;
					if( $request->has('status') ) {
						$status = $request->input('status');
					}
					$model	=	Business::where('id', $request->input('biz_id'))->where('user_id', $user->id)->first();
					if( count($model) ) {
						$model->update(['booking' => $status]);
						$data['status']		= 'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'access denied.';
					}
				}
				else {
					$data['alerts'] = 'biz_id required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Edit the business booking.
		 *
		 * @return Response
		 */
		public function BizBookingEdit(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$country_code		=	$user->country_code;
					if( $request->has('country_code') ) {
						$country_code	=	$request->input('country_code');
					}
					
					$language_code		=	'en';
					if( $request->has('language_code') ) {
						$language_code	=	$request->input('language_code');
					}
					
					$bookings			=	BusinessBooking::select('translation_of as id', 'title')->where('translation_lang', $language_code)->where('active', 1)->get();
					$business			=	Business::where('id', $request->input('biz_id'))->where('user_id', $user->id)->first();
					if( count($business) ) {
						
						if( $business->booking ) {
							
							if( $business->booking_type == 3 ) {
								$table = "businessBookingTmSettings";
							}
							else if( $business->booking_type == 5 ) {
								$table = "businessBookingTblSettings";
							}
							$model	=	DB::table($table)->where('biz_id', $request->input('biz_id'))->get();
							
							$data['type']	= $bookings;
							$data['data']	= $model;
							
							$data['status']	= 'success';
							unset($data['alerts']);
						}
						else {
							$data['alerts'] = 'booking disabled.';
						}
					}
					else {
						$data['alerts'] = 'access denied.';
					}
				}
				else {
					$data['alerts'] = 'biz_id required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post a review for business.
		 *
		 * @return Response
		 */
		public function PostReview(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('biz_id') ) {
					
					$business =	Business::where('id', $request->input('biz_id'))->first();
					if( count($business) ) {
						
						$check = Review::where('biz_id', $request->input('biz_id'))->where('user_id', $user->id)->first();
						if( count($check) ) {
							$data['alerts'] = 'You can\'t add more than one review to same business.';
						}
						else {
							
							$model 				= new Review();
							$model->biz_id		= $request->input('biz_id');
							$model->user_id		= $user->id;
							$model->user_name	= ucwords($user->name);
							$model->review		= $request->input('review');
							$model->rating		= $request->input('rating');
							$model->expense		= $request->input('expense');
							$model->save();
							/* BOF GCM Notification */
							$eventParetUser = User::where('id', $business->user_id)->first(); 
							if(count($eventParetUser)) {
								//Notification
									  $contents 						= array();
									  $title                            = "New Review"; 
									  $message_content  				= 'Added a new review';
									  $contents['data']['title']        = $title;
									  $contents['data']['message']      = $message_content;
									  $contents['data']['popup_type']   = 'message';
									  $msg	  = $contents;
									 
								if($eventParetUser->gcm_token !='') {
									  $to 	  = $eventParetUser->gcm_token;
									  $this->sendPushNotification($to,$msg);
								}
								if($eventParetUser->ios_token !='')
								{
									  $to 	  = $eventParetUser->ios_token;
									  $this->sendIOsPushNotification($to,$msg);
								}
								 //Notification
							}
							/* EOF GCM Notification */
							$data['status']	= 'success';
							unset($data['alerts']);
						}
					}
					else {
						$data['alerts'] = 'business not found.';
					}
				}
				else {
					$data['alerts'] = 'biz_id required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Load a for book events.
		 *
		 * @return Response
		 */
		public function BookEvents(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
							
				if( $request->has('eve_id') ) {
					
					$country_code		=	$user->country_code;
					if( $request->has('country_code') ) {
						$country_code	=	$request->input('country_code');
					}
					
					$currency	=	DB::table('countries')
									->select('countries.currency_code')
									->where('code', $country_code)
									->get();
					
					$language_code		=	'en';
					if( $request->has('language_code') ) {
						$language_code	=	$request->input('language_code');
					}
					
					$event =	DB::table('events')->where('id', $request->input('eve_id'))->where('country_code', $country_code)->first();
					if( count($event) ) {
						
						if( $event->ticket_type ) {
							
							$tickets 	=	DB::table('event_tickets')
											->select('event_tickets.ticket_quantity')
											->where('event_id', $event->id)->get();
								
							$total		=	'';
							if( count($tickets) ) {
								foreach($tickets as $value) { 
									foreach($value as $value1) {
										$total += $value1;
									}
								}
							}
							$event->decrement =	$total;
							
							if( $event->ticket_details ) {
								
								$event->ticket_details = unserialize($event->ticket_details);
							}
							
							$data['events']		= $event;
							$data['currency']	= $currency;
							
							$data['status']		= 'success';
							unset($data['alerts']);
						}
						else {
							$data['alerts'] = 'booking not available.';
						}
					}
					else {
						$data['alerts'] = 'event not found.';
					}
				}
				else {
					$data['alerts'] = 'event_id required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Load a for book events.
		 *
		 * @return Response
		 */
		public function BookEventsPost(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('eve_id') ) {
					
					$event =	Eventnew::find($request->input('eve_id'));
					if( count($event) ) {
						
						if( $request->has('ticket_quantity') ) {
						
							if( $event->ticket_type == 1 ) {
								
								$eventTicket					=	new EventTicket();
								$eventTicket->user_id			=	$user->id;
								$eventTicket->event_id			=	$request->input('eve_id');
								$eventTicket->ticket_quantity	=	$request->input('ticket_quantity');
								$eventTicket->ticket_amount		=	0;
								$eventTicket->total_amount		=	0;
								$eventTicket->active			=	1;
								$eventTicket->save();
								//$isSave =  $eventTicket->save();
								$eventParetUser = User::where('id', $eventTicket->user_id)->first(); 
								if(count($eventParetUser)) {
									//if($eventParetUser->gcm_token !='') {
										//Notification
										  $contents 						= array();
										  $title                            = "New Event"; 
										  $message_content  				= 'Booked an event';
										  $contents['data']['title']        = $title;
										  $contents['data']['message']      = $message_content;
										  $contents['data']['popup_type']   = 'message';
										  
										  $msg	  = $contents;
									    if($eventParetUser->gcm_token !='') {
											  $to 	  = $eventParetUser->gcm_token;
											  $this->sendPushNotification($to,$msg);
										}
										if($eventParetUser->ios_token !='')
										{
											  $to 	  = $eventParetUser->ios_token;
											  $this->sendIOsPushNotification($to,$msg);
										}
										//Notification
									//}
								}
								$data['status']	= 'success';
								unset($data['alerts']);
							}
							else {
								$data['alerts'] = 'booking not allowed.';
							}
						}
						else {
							$data['alerts'] = 'ticket_quantity required.';
						}
					}
					else {
						$data['alerts'] = 'event not found.';
					}
				}
				else {
					$data['alerts'] = 'event_id required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the generate country name from country.
		 *
		 * @return Response
		 */
		public function GenerateCountry(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				if( $request->has('country_code') ) {
					
					$code		 =	strtoupper($request->input('country_code'));
					
					$country	 =	DB::table('countries');
					if( $language_code == 'ar' ) {
						$country =	$country->select('name as title', 'phone');
					}
					else {
						$country =	$country->select('asciiname as title', 'phone');
					}
					$country	 =	$country->where('code', $code)->first();
					
					$data['country']	= $country;
					$data['status']		= 'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the country_code is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the generate locations from country.
		 *
		 * @return Response
		 */
		public function GenerateLocation(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				if( $request->has('country_code') ) {
					
					$country_code	=	$request->input('country_code');
				
					$locations		= 	DB::table('subadmin1');
					if( $language_code == 'ar' ) {
						$locations	=	$locations->select('id', 'name as title')->orderBy('name', 'asc');
					}
					else {
						$locations	=	$locations->select('id', 'asciiname as title')->orderBy('asciiname', 'asc');
					}
					$locations		=	$locations->where('code','LIKE',"%{$country_code}%")->where('active', 1)->get();
				
					$data['locations']	=	$locations;
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the country_code is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the generate city from country or loaction.
		 *
		 * @return Response
		 */
		public function GenerateCity(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				if( $request->has('country_code') ) {
					
					$country_code	=	$request->input('country_code');
				
					$cities		=	DB::table('cities');
					if( $language_code == 'ar' ) {
						$cities	=	$cities->select('id', 'name as title')->orderBy('name', 'asc');
					}
					else {
						$cities	=	$cities->select('id', 'asciiname as title')->orderBy('asciiname', 'asc');
					}
					$cities		=	$cities->where('country_code', '=', $country_code)->where('active', 1)->get();
				
					$data['cities']		=	$cities;
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else if( $request->has('location_code') ) {
					
					$location_code	=	$request->input('location_code');
				
					$cities		=	DB::table('cities');
					if( $language_code == 'ar' ) {
						$cities	=	$cities->select('id', 'name as title')->orderBy('name', 'asc');
					}
					else {
						$cities	=	$cities->select('id', 'asciiname as title')->orderBy('asciiname', 'asc');
					}
					$cities		=	$cities->where('subadmin1_code', substr($location_code, 3))->where('active', 1)->get();
				
					$data['cities']	=	$cities;
					$data['status']	=	'success';
					unset($data['alerts']);
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the generate keywords from category.
		 *
		 * @return Response
		 */
		public function GenerateKeyword(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$language_code		=	'en';
				if( $request->has('language_code') ) {
					$language_code	=	$request->input('language_code');
				}
				
				if( $request->has('category_id') ) {
					
					$keywords	  	= 	DB::table('categories');
					if( $language_code == 'ar' ) {
						$keywords	= 	$keywords->select('translation_of as id', 'name');
					}
					else {
						$keywords	= 	$keywords->select('id', 'name');
					}
					$keywords		= 	$keywords->where('translation_lang', $language_code)
										->where('parent_id', $request->input('category_id'))
										->where('active', 1)->orderBy('name', 'asc')->get();
					
					$data['keywords']	= 	$keywords;
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the category_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * List of messages.
		 *
		 * @return Response
		 */
			
		public function ListOfMessages(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$inbox	= 	\DB::select(\DB::raw("SELECT r.parent_id as id, count(r.reply) as count, MAX(r.created_at) as datetime, u.name, u.photo, 
							(SELECT m.subject FROM friends_messages m WHERE m.id=r.parent_id LIMIT 1) as subject, 
							(SELECT m.reply FROM friends_messages m WHERE m.id=r.parent_id LIMIT 1) as notify, 
							(SELECT reply FROM message_replay r1 WHERE r1.parent_id=r.parent_id AND r1.to_id='".$user->id."' ORDER BY r1.created_at DESC LIMIT 1) as message
							FROM message_replay r, users u WHERE r.from_id=u.id AND r.to_id='".$user->id."' GROUP BY r.parent_id ORDER BY datetime DESC"));
				
				if( count($inbox) ) {
					foreach( $inbox as $field ) {
						if( $field->name ) {
							$field->name = ucwords($field->name);
						}
						if( $field->datetime ) {
							$field->datetime = date('M d h:i A', strtotime($field->datetime));
						}
						if( $field->photo ) {
							$field->photo = URL::to('/').'/uploads/pictures/dp/'.$field->photo;
						}
					}
				}
				
				$sent	= 	\DB::select(\DB::raw("SELECT r.parent_id as id, count(r.reply) as count, MAX(r.created_at) as datetime, u.name, u.photo, 
							(SELECT m.subject FROM friends_messages m WHERE m.id=r.parent_id LIMIT 1) as subject, 
							(SELECT reply FROM message_replay r1 WHERE r1.parent_id=r.parent_id AND r1.from_id='".$user->id."' ORDER BY r1.created_at DESC LIMIT 1) as message
							FROM message_replay r, users u WHERE r.to_id=u.id AND r.from_id='".$user->id."' GROUP BY r.parent_id ORDER BY datetime DESC"));
			
				if( count($sent) ) {
					foreach( $sent as $field ) {
						if( $field->name ) {
							$field->name = ucwords($field->name);
						}
						if( $field->datetime ) {
							$field->datetime = date('M d h:i A', strtotime($field->datetime));
						}
						if( $field->photo ) {
							$field->photo = URL::to('/').'/uploads/pictures/dp/'.$field->photo;
						}
					}
				}
				
				$data['inbox']	= 	$inbox;
				$data['sent']	= 	$sent;
				$data['status']	= 	'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}	
		
		/**
		 * View of messages.
		 *
		 * @return Response
		 */
		public function ViewOfMessages(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('msg_id') ) {
					
					$message	= 	\DB::table('message_replay')
									->select('message_replay.id', 'message_replay.from_id', 'message_replay.to_id', 'message_replay.reply', 'message_replay.read', 'users.name as username','users.photo as userphoto','message_replay.created_at as datetime', 'friends_messages.subject as subject')
									->leftjoin('users', 'message_replay.from_id', '=', 'users.id')
									->leftjoin('friends_messages', 'message_replay.parent_id','=', 'friends_messages.id')
									->where('message_replay.parent_id', $request->input('msg_id'))
									->orderBy('message_replay.created_at', 'ASC')
									->get();
					
					if( count($message) ) {
						foreach( $message as $field ) {
							if( $field->username ) {
								$field->username = ucwords($field->username);
							}
							if( $field->datetime ) {
								$field->datetime = date('M d h:i A', strtotime($field->datetime));
							}
							if( $field->userphoto ) {
								$field->userphoto = URL::to('/').'/uploads/pictures/dp/'.$field->userphoto;
							}
						}
					}
							
					$data['message']	= 	$message;
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the msg_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Send messages.
		 *
		 * @return Response
		 */
		public function SendMessages(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			    
			if( count($user) ) {
				
				if( $request->has('user_ids') ) {
					
					$ids = array_filter($request->get('user_ids'));
					//$ids = array('120');
					if( is_array($ids) && count($ids) ) {
						foreach( $ids as $key => $to ) {
							
							$subject	=	$request->input('subject');
							$message	= 	$request->input('message');
							$parent_id 	= 	DB::table('friends_messages')
											->insertGetId(['from_id' => $user->id,'to_id' => $to,'subject' => $subject,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
							
							 DB::table('message_replay')->insert(['parent_id' => $parent_id,'from_id' => $user->id,'to_id' => $to,'reply' => $message,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
							
							 $result     =   Event::fire(new SendMessage($to, $subject, $message,$user->id));
							 $data['status']		= 	$result[0]['status'];
							 
							 /* BOF GCM Notification */
							 $eventParetUser = User::where('id', $to)->first(); 
							 if(count($eventParetUser)) {
								//Notification
									  $contents 						= array();
									  $title                            = "New Message from"; 
									  $message_content  				= $message;
									  $contents['data']['title']        = $title;
									  $contents['data']['message']      = $message_content;
									  $contents['data']['popup_type']   = 'message';
									  $msg	  = $contents;
									 
								if($eventParetUser->gcm_token !='') {
									  $to 	  = $eventParetUser->gcm_token;
									  $this->sendPushNotification($to,$msg);
								}
								if($eventParetUser->ios_token !='')
								{
									  $to 	  = $eventParetUser->ios_token;
									  $this->sendIOsPushNotification($to,$msg);
								}
								 //Notification
							}
							/* EOF GCM Notification */
							 
							 
							/*MESSAGE
								$toArr   = User::find($to)->toArray();
								$fromArr = User::find($user->id)->toArray();
								if($subject!=''){
									
									$mailArr = array('name'=>$fromArr['name'],'email' => $toArr['email'],'subject' => $subject,'message' => $message);
									
									Mail::send('emails.friends.message', ['user12' => $mailArr,'mess' => $mailArr['message'],'sub' => $mailArr['subject']], function($message) use ($mailArr) {
										$message->to($mailArr['email']);
										$message->subject($mailArr['subject']);
										
									});
									$data['status']		= 	'status';
								}else {
									$s = \DB::table('friends_messages')
												->select('friends_messages.*','friends_messages.to_id as to_message','conversation.*',
																		'conversation.id as conversation_id')
												->join('conversation','conversation.id','=','friends_messages.from_id')
												->where('friends_messages.to_id',$user->id)
												->first();
									if($s->reply == 1)
									{
										$abc  = \DB::table('friends_messages')
												->select('id','subject')
												->where('from_id',$s->conversation_id)->first();
										
										$mailArr = array('name'=>$fromArr['name'],'email' => $toArr['email'],'subject' => $abc->subject,'message' => $message);
									    
										Mail::send('emails.friends.message', ['user12' => $mailArr,'mess_id' => $s->id ,'mess' => $mailArr['message'],'sub' => $abc->subject], function($message) use ($mailArr) {
											$message->to($mailArr['email']);
											$message->subject('RE : ' . $mailArr['subject']);
										});
										$data['status']		= 	'status';
									}
								}
							*/ //MESSAGE
							
						} // END FOREACH
						//$data['status']		= 	'success';
						unset($data['alerts']);
					}   
					else {
						$data['alerts'] = 'the user_ids are not in array format.';
					}
				}
				else {
					$data['alerts'] = 'the user_ids are required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Reply of messages.
		 *
		 * @return Response
		 */
		public function ReplyOfMessages(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('msg_id') ) {
					
					$msg_id		=	$request->input('msg_id');
					$from 		= 	$user->id;
					$to			= 	$request->input('to');
					$message	=	$request->input('message');
					$subject	=	$request->input('subject');
					
					DB::table('message_replay')->insert(['parent_id' => $msg_id,'from_id' => $from,'to_id' => $to,'reply' => $message,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
					DB::table('friends_messages')->where('id',$msg_id)->update(['reply' => '1']);
					
					//Event::fire(new SendMessage($from, $subject, $message,$from));
					Event::fire(new SendMessage($to, $subject, $message,$from));
			
					/* BOF GCM Notification */
					 $eventParetUser = User::where('id', $to)->first(); 
					 if(count($eventParetUser)) {
						//Notification
							  $contents 						= array();
							  $title                            = "New Message from"; 
							  $message_content  				= $message;
							  $contents['data']['title']        = $title;
							  $contents['data']['message']      = $message_content;
							  $contents['data']['popup_type']   = 'message';
							  $msg	  = $contents;
							 
						if($eventParetUser->gcm_token !='') {
							  $to 	  = $eventParetUser->gcm_token;
							  $this->sendPushNotification($to,$msg);
						}
						if($eventParetUser->ios_token !='')
						{
							  $to 	  = $eventParetUser->ios_token;
							  $this->sendIOsPushNotification($to,$msg);
						}
						 //Notification
					}
					/* EOF GCM Notification */
					$data['status']		= 	'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the msg_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Delete messages.
		 *
		 * @return Response
		 */
		public function DeleteMessages(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('msg_id') ) {
					
					DB::table('friends_messages')->where('id', $request->input('msg_id'))->delete();
					DB::table('message_replay')->where('parent_id', $request->input('msg_id'))->delete();
					
					$data['status'] = 'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'the msg_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * List of active users.
		 *
		 * @return Response
		 */
		public function ListOfUsers(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$check = DB::table('users')->select('id', 'name', 'email')->where('active', 1)->whereNotNull('name')->orderBy('name')->get();
				if( count($check) ) {
					foreach($check as $row => $field) {
						if( $field->id == $user->id ) {
							unset($check[$row]);
						}
						if( $field->name ) {
							$field->name = ucwords($field->name);
						}
					}
				}
				$users = array_values($check);
				
				$data['users']		= 	$users;
				$data['status']		= 	'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Busniess Graph.
		 *
		 * @return Response
		 */
		public function BusinessGraph(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $user->user_type_id == 2 ) {
					
					$business	=	DB::table('business')->select('id', 'title')->where('user_id', $user->id)->where('active', 1)->get();
					if( count($business) ) {
						foreach($business as $row => $field) {
							if( $field->title ) {
								$field->title = ucwords($field->title);
							}
						}
					}
					$data['business'] 	= $business;
					$data['status']		= 'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'available only for business users.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Busniess Graph in Month wise.
		 *
		 * @return Response
		 */
		public function BusinessGraphView(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $user->user_type_id == 2 ) {
					
					if( $request->has('biz_id') ) {
						
						if( $request->has('month') ) {
							
							$month = array('1', '12');
							if( in_array($request->input('month'), $month) ) {
							
								$today	= Carbon::today()->toDateString();
								$result	= array();
								if( $request->input('month') == 1 ) {
									
									$date	=	date("Y-m-d", strtotime("-30 day", strtotime($today)));
									
									$viewAr	=	DB::table('business_visits')
												->select(DB::raw("count(ip_address) as value, DATE_FORMAT(created_at, '%e') as day"))
												->where('biz_id', $request->input('biz_id'))
												->whereDate('created_at', '>=', $date)
												->groupBy('day')
												->get();
										
									$giftAr	=	DB::table('gift_certificates')
												->select(DB::raw("sum(total_quantity) as value, DATE_FORMAT(created_at, '%e') as day"))
												->where('biz_id', $request->input('biz_id'))
												->where('active', 1)
												->whereDate('created_at', '>=', $date)
												->groupBy('day')
												->get();	
												
									$rateAr	=	DB::table('review')
												->select(DB::raw("avg(rating) as value, DATE_FORMAT(created_at, '%e') as day"))
												->where('biz_id', $request->input('biz_id'))
												->whereDate('created_at', '>=', $date)
												->groupBy('day')
												->get();
									
									$j = $date;
									for($i=1;$i<=31;$i++) {
										$k	= date("j", strtotime($j));
										$views[$k]	= "0";
										$gifts[$k]	= "0";
										$rates[$k]	= "0";
										$j	= date("Y-m-d", strtotime("+1 day", strtotime($j)));
									}
									
									foreach($viewAr as $key => $val) {
										if( isset($val->day) && $val->day ){
											$views[$val->day] = $val->value;
										}
									}
									
									foreach($giftAr as $key => $val) {
										if( isset($val->day) && $val->day ) {
											$gifts[$val->day] = $val->value;
										}
									}
									
									foreach($rateAr as $key => $val) {
										if( isset($val->day) && $val->day ){
											$rates[$val->day] = $val->value;
										}
									}
									
									$i = 0;
									foreach($views as $key => $val) {
										$result[$i]["field"] = $key;
										$result[$i]["views"] = $val;
										$result[$i]["gifts"] = $gifts[$key];
										$result[$i]["rates"] = $rates[$key];
										$i++;
									}
		
								}
								else {
									
									$date	=	date("Y-m-d", strtotime("-11 month", strtotime($today)));
									
									$viewAr	=	DB::table('business_visits')
												->select(DB::raw("count(ip_address) as value, DATE_FORMAT(created_at, '%c') as month"))
												->where('biz_id', $request->input('biz_id'))
												->whereDate('created_at', '>=', $date)
												->groupBy('month')
												->get();
										
									$giftAr	=	DB::table('gift_certificates')
												->select(DB::raw("sum(total_quantity) as value, DATE_FORMAT(created_at, '%c') as month"))
												->where('biz_id', $request->input('biz_id'))
												->where('active', 1)
												->whereDate('created_at', '>=', $date)
												->groupBy('month')
												->get();	
												
									$rateAr	=	DB::table('review')
												->select(DB::raw("avg(rating) as value, DATE_FORMAT(created_at, '%c') as month"))
												->where('biz_id', $request->input('biz_id'))
												->whereDate('created_at', '>=', $date)
												->groupBy('month')
												->get();
									
									
									$j = $date;
									for($i=1;$i<=12;$i++) {
										$k	= date("n", strtotime($j));
										$views[$k] = "0";
										$gifts[$k] = "0";
										$rates[$k] = "0";
										$j	= date("Y-m-d", strtotime("+1 month", strtotime($j)));
									}		
									
									foreach($viewAr as $key => $val) {
										if( isset($val->month) && $val->month ){
											$views[$val->month] = $val->value;
										}
									}
									
									foreach($giftAr as $key => $val) {
										if( isset($val->month) && $val->month ){
											$gifts[$val->month] = $val->value;
										}
									}
									
									foreach($rateAr as $key => $val) {
										if( isset($val->month) && $val->month ){
											$rates[$val->month] = $val->value;
										}
									}
									
									$months  =	array(
										'1'  => 'Jan',
										'2'  => 'Feb',
										'3'  => 'Mar',
										'4'  => 'Apr',
										'5'  => 'May',
										'6'  => 'Jun',
										'7'  => 'Jul',
										'8'  => 'Aug',
										'9'  => 'Sep',
										'10' => 'Oct',
										'11' => 'Nov',
										'12' => 'Dec'
									);
									
									$i = 0;
									foreach($views as $key => $val) {
										$result[$i]["field"] = $months[$key];
										$result[$i]["views"] = $val;
										$result[$i]["gifts"] = $gifts[$key];
										$result[$i]["rates"] = $rates[$key];
										$i++;
									}
		
								}
								$data['result'] = $result;
								$data['status']	= 'success';
								unset($data['alerts']);
								
							}
							else {
								$data['alerts'] = 'the month value should be 1 or 12.';
							}
						}
						else {
							$data['alerts'] = 'the month is required.';
						}
					}
					else {
						$data['alerts'] = 'the biz_id is required.';
					}
				}
				else {
					$data['alerts'] = 'available only for business users.';
				}
			}
			return json_encode($data);
		}
		//
		public function BusinessGraphViewA(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $user->user_type_id == 2 ) {
					
					if( $request->has('biz_id') ) {
						
						if( $request->has('month') ) {
							
						if( $request->has('graph_type') ) {
							
							$month = array('1', '12');
							if( in_array($request->input('month'), $month) ) {
							
								$today	= Carbon::today()->toDateString();
								$result	= array();
								$graphType = $request->input('graph_type');
								if( $request->input('month') == 1 ) {
									
									$date	=	date("Y-m-d", strtotime("-30 day", strtotime($today)));
									
									if($graphType == 'view') {
										$resArr	=	DB::table('business_visits')
													->select(DB::raw("count(ip_address) as value, DATE_FORMAT(created_at, '%e') as day"))
													->where('biz_id', $request->input('biz_id'))
													->whereDate('created_at', '>=', $date)
													->groupBy('day')
													->get();
									}else if($graphType == 'gift') {	
										$resArr	=	DB::table('gift_certificates')
													->select(DB::raw("sum(total_quantity) as value, DATE_FORMAT(created_at, '%e') as day"))
													->where('biz_id', $request->input('biz_id'))
													->where('active', 1)
													->whereDate('created_at', '>=', $date)
													->groupBy('day')
													->get();	
									}else if($graphType == 'review') {		
										$resArr	=	DB::table('review')
													->select(DB::raw("avg(rating) as value, DATE_FORMAT(created_at, '%e') as day"))
													->where('biz_id', $request->input('biz_id'))
													->whereDate('created_at', '>=', $date)
													->groupBy('day')
													->get();
									}
									$j = $date;
									for($i=1;$i<=31;$i++) {
										$k	= date("j", strtotime($j));
										$views[$k]	= "0";
										$gifts[$k]	= "0";
										$rates[$k]	= "0";
										$j	= date("Y-m-d", strtotime("+1 day", strtotime($j)));
									}
									
									foreach($resArr as $key => $val) {
										if($graphType == 'view' && isset($val->day) && $val->day ){
											$views[$val->day] = $val->value;
										}
										if($graphType == 'gift' && isset($val->day) && $val->day ){
											$gifts[$val->day] = $val->value;
										}
										if($graphType == 'review' && isset($val->day) && $val->day ){
											$rates[$val->day] = $val->value;
										}
									}
									
									$i = 0;
									foreach($views as $key => $val) {
										$result[$i]["field"] = ''.$key.'';
										if($graphType == 'view') {
											$result[$i]["value"] = $val;
										}
										if($graphType == 'gift') {
											$result[$i]["value"] = $gifts[$key];
										}
										if($graphType == 'review') {
											$result[$i]["value"] = $rates[$key];
										}
										$i++;
									}
		
								}
								else {
									
									$date	=	date("Y-m-d", strtotime("-11 month", strtotime($today)));
									if($graphType == 'view') {
										
										$resArr	=	DB::table('business_visits')
													->select(DB::raw("count(ip_address) as value, DATE_FORMAT(created_at, '%c') as month"))
													->where('biz_id', $request->input('biz_id'))
													->whereDate('created_at', '>=', $date)
													->groupBy('month')
													->get();
													
									} else if($graphType == 'gift') {
										
										$resArr	=	DB::table('gift_certificates')
													->select(DB::raw("sum(total_quantity) as value, DATE_FORMAT(created_at, '%c') as month"))
													->where('biz_id', $request->input('biz_id'))
													->where('active', 1)
													->whereDate('created_at', '>=', $date)
													->groupBy('month')
													->get();
												
									} else if($graphType == 'review') {
										
										$resArr	=	DB::table('review')
													->select(DB::raw("avg(rating) as value, DATE_FORMAT(created_at, '%c') as month"))
													->where('biz_id', $request->input('biz_id'))
													->whereDate('created_at', '>=', $date)
													->groupBy('month')
													->get();
									
									}
									$j = $date;
									for($i=1;$i<=12;$i++) {
										$k	= date("n", strtotime($j));
										$views[$k] = "0";
										$gifts[$k] = "0";
										$rates[$k] = "0";
										$j	= date("Y-m-d", strtotime("+1 month", strtotime($j)));
									}		
									
									
									/* foreach($viewAr as $key => $val) {
										if( isset($val->month) && $val->month ){
											$views[$val->month] = $val->value;
										}
									} */
									foreach($resArr as $key => $val) {
										if($graphType == 'view' && isset($val->month) && $val->month ){
											$views[$val->month] = $val->value;
										}
										if($graphType == 'gift' && isset($val->month) && $val->month ){
											$gifts[$val->month] = $val->value;
										}
										if($graphType == 'review' && isset($val->month) && $val->month ){
											$rates[$val->month] = $val->value;
										}
									}
									
									/* foreach($giftAr as $key => $val) {
										if( isset($val->month) && $val->month ){
											$gifts[$val->month] = $val->value;
										}
									}
									
									foreach($rateAr as $key => $val) {
										if( isset($val->month) && $val->month ){
											$rates[$val->month] = $val->value;
										}
									}
									 */
									$months  =	array(
										'1'  => 'Jan',
										'2'  => 'Feb',
										'3'  => 'Mar',
										'4'  => 'Apr',
										'5'  => 'May',
										'6'  => 'Jun',
										'7'  => 'Jul',
										'8'  => 'Aug',
										'9'  => 'Sep',
										'10' => 'Oct',
										'11' => 'Nov',
										'12' => 'Dec'
									);
									
									$i = 0;
									/* foreach($views as $key => $val) {
										$result[$i]["field"] = $months[$key];
										$result[$i]["views"] = $val;
										$result[$i]["gifts"] = $gifts[$key];
										$result[$i]["rates"] = $rates[$key];
										$i++;
									} */
									foreach($views as $key => $val) {
										$result[$i]["field"] = ''.$months[$key].'';
										if($graphType == 'view') {
											$result[$i]["value"] = $val;
										}
										if($graphType == 'gift') {
											$result[$i]["value"] = $gifts[$key];
										}
										if($graphType == 'review') {
											$result[$i]["value"] = $rates[$key];
										}
										$i++;
									}
		
								}
								$data['result'] = $result;
								$data['status']	= 'success';
								unset($data['alerts']);
								
							}
							else {
								$data['alerts'] = 'the month value should be 1 or 12.';
							}
						}
						else {
							$data['alerts'] = 'the graph type is required.';
							}
						}
						else {
							$data['alerts'] = 'the month is required.';
						}
					}
					else {
						$data['alerts'] = 'the biz_id is required.';
					}
				}
				else {
					$data['alerts'] = 'available only for business users.';
				}
			}
			return json_encode($data);
		}
		//
		/**
		 * Event Graph.
		 *
		 * @return Response
		 */
		public function EventGraph(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$events	=	DB::table('events')->select('id', 'event_name as title')->where('user_id', $user->id)->get();
				if( count($events) ) {
					foreach($events as $row => $field) {
						if( $field->title ) {
							$field->title = ucwords($field->title);
						}
					}
				}
				$data['events'] 	= $events;
				$data['status']		= 'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Event Graph in Month wise.
		 *
		 * @return Response
		 */
		 public function EventGraphViewA(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('eve_id') ) {
					
					if( $request->has('month') ) {
						
						if( $request->has('graph_type') ) {
						
						  $month = array('1', '12');
						  $graphType = $request->input('graph_type');
						  
						  if( in_array($request->input('month'), $month) ) {
						
							$today	= Carbon::today()->toDateString();
							$result	= array();
							if( $request->input('month') == 1 ) {
								
								$date	=	date("Y-m-d", strtotime("-30 day", strtotime($today)));
								
								if($graphType == 'view') {
									
									$resArr	=	DB::table('event_visits')
													->select(DB::raw("count(ip_address) as value, DATE_FORMAT(created_at, '%e') as day"))
													->where('event_id', $request->input('eve_id'))
													->whereDate('created_at', '>=', $date)
													->groupBy('day')
													->get();
												
								}else if($graphType == 'ticket') {	
								
									 $resArr	=	DB::table('event_tickets')
													->select(DB::raw("sum(ticket_quantity) as value, DATE_FORMAT(created_at, '%e') as day"))
													->where('event_id', $request->input('eve_id'))
													->where('active', 1)
													->whereDate('created_at', '>=', $date)
													->groupBy('day')
													->get();
								}
								
								$j = $date;
								for($i=1;$i<=31;$i++) {
									$k	= date("j", strtotime($j));
									$views[$k] = "0";
									$tckts[$k] = "0";
									$j	= date("Y-m-d", strtotime("+1 day", strtotime($j)));
								}	
								
								foreach($resArr as $key => $val) {
									
									if( $graphType == 'view' && isset($val->day) && $val->day ){
										$views[$val->day] = $val->value;
									}
								
									if( $graphType == 'ticket' && isset($val->day) && $val->day ){
										$tckts[$val->day] = $val->value;
									}
								}
								
								$i = 0;
								foreach($views as $key => $val) {
										$result[$i]["field"] = ''.$key.'';   
									if($graphType == 'view') {
										$result[$i]["value"] = $val;
									}else if($graphType == 'ticket') {
										$result[$i]["value"] = $tckts[$key];
									}
									$i++;
								}
							}
							else {
								
								$date	=	date("Y-m-d", strtotime("-11 month", strtotime($today)));
								
								if($graphType == 'view') {
									
									$resArr	=	DB::table('event_visits')
												->select(DB::raw("count(ip_address) as value, DATE_FORMAT(created_at, '%c') as month"))
												->where('event_id', $request->input('eve_id'))
												->whereDate('created_at', '>=', $date)
												->groupBy('month')
												->get();
											
								} else if($graphType == 'ticket') {	
								
									$resArr	=	DB::table('event_tickets')
												->select(DB::raw("sum(ticket_quantity) as value, DATE_FORMAT(created_at, '%c') as month"))
												->where('event_id', $request->input('eve_id'))
												->where('active', 1)
												->whereDate('created_at', '>=', $date)
												->groupBy('month')
												->get();
								}
								   
								$j = $date;
								for($i=1;$i<=12;$i++) {
									$k	= date("n", strtotime($j));
									$views[$k] = "0";
									$tckts[$k] = "0";
									$j	= date("Y-m-d", strtotime("+1 month", strtotime($j)));
								}	
								
								foreach($resArr as $key => $val) {
									
									if($graphType == 'view' && isset($val->month) && $val->month ){
										$views[$val->month] = $val->value;
									}
								
									if($graphType == 'ticket' && isset($val->month) && $val->month ){
										$tckts[$val->month] = $val->value;
									}
									
								}
								
								$months  =	array(
									'1'  => 'Jan',
									'2'  => 'Feb',
									'3'  => 'Mar',
									'4'  => 'Apr',
									'5'  => 'May',
									'6'  => 'Jun',
									'7'  => 'Jul',
									'8'  => 'Aug',
									'9'  => 'Sep',
									'10' => 'Oct',
									'11' => 'Nov',
									'12' => 'Dec'
								);
								
								$i = 0;
								foreach($views as $key => $val) {  
										$result[$i]["field"] = ''.$months[$key].'';
									if($graphType == 'view'){
										$result[$i]["value"] = $val;
									}else if($graphType == 'ticket'){
										$result[$i]["value"] = $tckts[$key];
									}
									$i++;
								}
	
							}
							$data['result'] = $result;
							$data['status']	= 'success';
							unset($data['alerts']);
							
							}
							else {
								$data['alerts'] = 'the month value should be 1 or 12.';
							}
						}
						else {
							$data['alerts'] = 'the graph_type field is required';
						}
					}  
					else {
						$data['alerts'] = 'the month is required.';
					}
				}
				else {
					$data['alerts'] = 'the eve_id is required.';
				}
			}
			return json_encode($data);
		}
		public function EventGraphView(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('eve_id') ) {
					
					if( $request->has('month') ) {
						
						$month = array('1', '12');
						if( in_array($request->input('month'), $month) ) {
						
							$today	= Carbon::today()->toDateString();
							$result	= array();
							if( $request->input('month') == 1 ) {
								
								$date	=	date("Y-m-d", strtotime("-30 day", strtotime($today)));
								
								$viewAr	=	DB::table('event_visits')
											->select(DB::raw("count(ip_address) as value, DATE_FORMAT(created_at, '%e') as day"))
											->where('event_id', $request->input('eve_id'))
											->whereDate('created_at', '>=', $date)
											->groupBy('day')
											->get();
									
								$tcktAr	=	DB::table('event_tickets')
											->select(DB::raw("sum(ticket_quantity) as value, DATE_FORMAT(created_at, '%e') as day"))
											->where('event_id', $request->input('eve_id'))
											->where('active', 1)
											->whereDate('created_at', '>=', $date)
											->groupBy('day')
											->get();
								
								$j = $date;
								for($i=1;$i<=31;$i++) {
									$k	= date("j", strtotime($j));
									$views[$k] = "0";
									$tckts[$k] = "0";
									$j	= date("Y-m-d", strtotime("+1 day", strtotime($j)));
								}	
								
								foreach($viewAr as $key => $val) {
									if( isset($val->day) && $val->day ){
										$views[$val->day] = $val->value;
									}
								}
								
								foreach($tcktAr as $key => $val) {
									if( isset($val->day) && $val->day ){
										$tckts[$val->day] = $val->value;
									}
								}
								
								$i = 0;
								foreach($views as $key => $val) {
									$result[$i]["field"] = $key;
									$result[$i]["views"] = $val;
									$result[$i]["tckts"] = $tckts[$key];
									$i++;
								}
							}
							else {
								
								$date	=	date("Y-m-d", strtotime("-11 month", strtotime($today)));
								
								$viewAr	=	DB::table('event_visits')
											->select(DB::raw("count(ip_address) as value, DATE_FORMAT(created_at, '%c') as month"))
											->where('event_id', $request->input('eve_id'))
											->whereDate('created_at', '>=', $date)
											->groupBy('month')
											->get();
									
								$tcktAr	=	DB::table('event_tickets')
											->select(DB::raw("sum(ticket_quantity) as value, DATE_FORMAT(created_at, '%c') as month"))
											->where('event_id', $request->input('eve_id'))
											->where('active', 1)
											->whereDate('created_at', '>=', $date)
											->groupBy('month')
											->get();
								
								$j = $date;
								for($i=1;$i<=12;$i++) {
									$k	= date("n", strtotime($j));
									$views[$k] = "0";
									$tckts[$k] = "0";
									$j	= date("Y-m-d", strtotime("+1 month", strtotime($j)));
								}	
								
								foreach($viewAr as $key => $val) {
									if( isset($val->month) && $val->month ){
										$views[$val->month] = $val->value;
									}
								}
								
								foreach($tcktAr as $key => $val) {
									if( isset($val->month) && $val->month ){
										$tckts[$val->month] = $val->value;
									}
								}
								
								$months  =	array(
									'1'  => 'Jan',
									'2'  => 'Feb',
									'3'  => 'Mar',
									'4'  => 'Apr',
									'5'  => 'May',
									'6'  => 'Jun',
									'7'  => 'Jul',
									'8'  => 'Aug',
									'9'  => 'Sep',
									'10' => 'Oct',
									'11' => 'Nov',
									'12' => 'Dec'
								);
								
								$i = 0;
								foreach($views as $key => $val) {
									$result[$i]["field"] = $months[$key];
									$result[$i]["views"] = $val;
									$result[$i]["tckts"] = $tckts[$key];
									$i++;
								}
	
							}
							$data['result'] = $result;
							$data['status']	= 'success';
							unset($data['alerts']);
							
						}
						else {
							$data['alerts'] = 'the month value should be 1 or 12.';
						}
					}
					else {
						$data['alerts'] = 'the month is required.';
					}
				}
				else {
					$data['alerts'] = 'the eve_id is required.';
				}
			}
			return json_encode($data);
		}
		
		
		/**
		 * Friends List.
		 *
		 * @return Response
		 */
		public function FriendList(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$user_id = $user->id;
				if( $request->has('user_id') ) {
					$user_id = $request->input('user_id');
				}
				
				//if(  $request->input('user_id') )
				$friends	=	DB::table('add_friend')
								->select('add_friend.id', 'add_friend.friend_id', 'add_friend.status', 'users.name', 'users.photo', 'countries.asciiname as country')
								->leftjoin('users', 'add_friend.friend_id', '=', 'users.id')
								->leftjoin('countries', 'users.country_code', '=', 'countries.code')
								->where('add_friend.user_id', '=', $user_id);
				if( $request->has('user_id') ) {				
					$friends	=	$friends->where('add_friend.status', '=', 'Accepted');
				}   
				$friends	=	$friends->get();
				/* $friendArr	=	DB::table('add_friend')
								->select('add_friend.id', 'add_friend.friend_id', 'add_friend.status', 'users.name', 'users.photo', 'countries.asciiname as country')
								->leftjoin('users', 'add_friend.friend_id', '=', 'users.id')
								->leftjoin('countries', 'users.country_code', '=', 'countries.code')
								->where('add_friend.user_id', '=', $user_id);
				if( $request->has('user_id') ) {				
					$friendArr->where('add_friend.status', '=', 'Accepted');
				}
				$friends	=	$friendArr->get(); */
								
				if( count($friends) ) {
					foreach($friends as $row => $field) {
						if( $field->name ) {
							$field->name = ucwords($field->name);
						}
						if( $field->photo ) {
							$field->photo = URL::to('/').'/uploads/pictures/dp/'.$field->photo;
						}
					}
				}
				$data['friend']	= $friends;
				$data['status']	= 'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Friends List Manage.
		 *
		 * @return Response
		 */
		public function FriendListManage(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('request_id') ) {
				
					if( $request->has('status') ) {
				
						$model	=	DB::table('add_friend')
											->where('id', $request->input('request_id'))
											->where('friend_id', $user->id)
											->first();
						if( count($model) ) {
							
							DB::table('add_friend')->where('id', $request->input('request_id'))->update(['status' => ucwords($request->input('status'))]);
							
							$data['status']	= 'success';
							unset($data['alerts']);
						}
						else {
							$data['alerts']	= 'the request was not found.';
						}
					}
					else {
						$data['alerts']	= 'the status is required.';
					}
				}
				else {
					$data['alerts']	= 'the request_id is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Find Friends.
		 *
		 * @return Response
		 */
		public function FindFriends(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				$data['status']	= 'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Invite Friends.
		 *
		 * @return Response
		 */
		public function InviteFriends(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('emails') ) {
				
				   $emails = $request->input('emails');
					if( is_array($emails) ) {
						
						
						foreach( $emails as $to) {
							
							$check = DB::table('invited_friends')->where('invited_by', $user->id)->where('email', $to)->count();
							$users = DB::table('users')->where('email', $to)->count();
							if( !$check && !$users ) {
								DB::table('invited_friends')->insert(['email' => $to, 'invited_by' => $user->id, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
							}
						}

						$data['status']	= 'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts']	= 'the emails are may empty or not in array format.';
					}
				}
				else {
					$data['alerts']	= 'the emails are required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Update Country.
		 *
		 * @return Response
		 */
		public function UpdateCountry(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				if( $request->has('country_code') ) {
				
					$user = $user->update(['country_code' => $request->input('country_code')]);
					
					$data['status']	= 'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts']	= 'the country_code is required.';
				}
			}
			return json_encode($data);
		}
		
		/**
		 * List Notifications.
		 *
		 * @return Response
		 */
		public function Notifications(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				$notify	=	DB::table('add_friend')
							->select('add_friend.id','user_id','status','users.name','users.photo','countries.asciiname')
							->leftjoin('users', 'add_friend.user_id', '=', 'users.id')
							->leftjoin('countries', 'users.country_code', '=', 'countries.code')
							->where('status', '=', 'Send')
							->where('friend_id', '=', $user->id)
							->get();
					
				$data['notify']	= $notify;
				$data['status']	= 'success';
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		//MAIL
		public function MailCompose(HttpRequest $request) {
			
			 
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			if( $request->has('apikey') ) {
				$user			= User::where('api_key', $request->input('apikey'))->first();
				if( count($user) ) {
					$usersArr			=	User::select('id','email','name')
														->where('active',1)->get();
					$data['status']		= 	'success';
					$data['users']		=	$usersArr;
					
					unset($data['alerts']);
				}
			}
			return json_encode($data);
		}
		//MAIL
		
		/**
		 * UPDATE GCM TOKEN
		 * @return Response
		 */
		public function UpdateGcmToken(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$userModel		= User::where('api_key', $request->input('apikey'))->first();
			 if( count($userModel) ) {
				
				if( $request->has('device') && $request->has('token')) {
					
					if($request->input('device') == "ios") {
						$userModel->ios_token	 = $request->input('token');
					}
					if($request->input('device') == "android") {
						$userModel->gcm_token 	 = $request->input('token');
					}
					$userModel->device 		  	 = $request->input('device');
					$userModel->save();
					
					$data['status']		 = 	'success';
					unset($data['alerts']);
					
				}
				else {
					$data['alerts'] = 'The device is required.';
				}
			}
			return json_encode($data);
		}
		
	   /****
		*   Update Live Location 
		*/
		public function UpdateUserLocation(HttpRequest $request) {
		
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				if( $request->has('device_id')) {
					if( $request->has('device')) {
						if( $request->has('latitude') && $request->has('longitude')) {
							
							$device			= $request->input('device');
							$device_id		= $request->input('device_id');
							$latitude		= $request->input('latitude');
							$longitude		= $request->input('longitude');
							$locArr  		= UserLocation::where('device_type',$device)
														   ->where('device_id',$device_id)
														   ->where('user_id',$user->id)
														   ->first();  
							if(count($locArr)>0) {
								
								$locArr->update(['device_id' => $device_id,'latitude' => $latitude,'longitude' => $longitude]);
								$data['status']		= 	'success';
								unset($data['alerts']);
								
							} else {
								
								$locArr 		   	 = new UserLocation();
								$locArr->user_id 	 = $user->id;
								$locArr->device_type = $device;
								$locArr->device_id 	 = $device_id;
								$locArr->latitude 	 = $latitude;
								$locArr->longitude 	 = $longitude;
								$locArr->save();
								$data['status']		 = 	'success';
								unset($data['alerts']);
							}
							$data['location']		 =	$locArr;
						}
						else {
							$data['alerts'] = 'The latitude and longitude is required';
						}
					}else {
						$data['alerts'] = 'The device is required';
					}
				}else {
					$data['alerts'] = 'The device id is required';
				}
			}
			return json_encode($data);
		}
		public function CheckGCM(HttpRequest $request) 
		{
				$data 			= [];
				$data['status'] = 'error';
				$data['alerts'] = 'invalid credential.';
			     $user			= User::where('id', 34)->first();
				if( count($user) ) {
			    //CHECK
				  $contents 						= array();
				  $title                            = "Hi Sanju "; 
				  $message_content  				= 'Test Notification';
				  $contents['data']['title']        = $title;
				  $contents['data']['message']      = $message_content;
				  $contents['data']['popup_type']   = 'message';
				  $contents['data']['sound']   	= 1;
				  $msg	  = $contents;
				  /* if($user->gcm_token !='') {
					  $to 	  = $user->gcm_token;
					  $data['status']		= 	'success';
					  $data['alerts'] = 'Successfully worked';
					  $this->sendPushNotification($to,$msg);
				  } 
				  if($user->ios_token !='')
				  {
					  $to 	  = $user->ios_token;
					  $data['status']		= 	'success';
					  $data['alerts'] = 'Successfully worked';
					  $this->sendIOsPushNotification($to,$msg);
					  
				  }*/
				//CHECK
					
				 }
				 return json_encode($data);
				
		}
	   /*
		*  Send Notification
		*/
		function sendPushNotification($to,$message) {
       
			if (!defined('FIREBASE_API_KEY')) 
				define('FIREBASE_API_KEY', 'AAAA46ctEUM:APA91bFXdd3t-Ux6w6DGFYyNrbHMLKLMGJSONXgGKY8B1XiMOEP9wW51dLnZA5WFLTBeiSk_2wQA-FknGmuiFzglv6GDD34PBkJ9ed7jYqRE-9WapeCqV3IEvP-RUrEsb0qM_U6WQ7Jr');
			$url = 'https://fcm.googleapis.com/fcm/send';    
			$fields = array(   
				'to' => $to,
				'data' => $message,
			);
			
			$headers = array(
				'Authorization: key=' . FIREBASE_API_KEY,
				'Content-Type: application/json'
			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
			$result = curl_exec($ch);
			if ($result === FALSE) {
				die('Curl failed: ' . curl_error($ch));
			}
			curl_close($ch);
			$response = json_decode($result, true); 
			//echo"<pre>";print_r($response);die; 
			$response = (object)$response;
			$success  = $response->success;
			//return;
			
			 //print_r(json_encode($message));
			 return $success;
			//exit;
		}
	 function sendIOsPushNotification($to_ios,$message)
	 {
		 
		
		define( 'API_ACCESS_KEY', 'AAAAat5FrqA:APA91bGS1ATAO-Pw-9EFnF2TfzxOwwzPcTnPQUkoeSjKxUu_kddR_SSiSJkhaynvpaoP_dNQOLPDh1qG58PC7451YM3Ai143IcteLNxCs_IUkeYRm_qhUxmMkOWQNHoghbTHyWks4DtYaRQw2vWa5_Ian85DvbpODw');
		
		$fields = array(
					'to'  		=> $to_ios,
					//'aps'		=> $message
					'content_available'=> true,
					'priority'	=> 'high',
					'notification'=> array("title" => $message['data']['title'], "body"=> $message['data']['message'])
				);

		$headers = array(
					'Authorization: key=' . API_ACCESS_KEY,
					'Content-Type: application/json'
				);

		$ch = curl_init();
		curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		curl_setopt( $ch,CURLOPT_POST, true );
		curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		$result = curl_exec($ch);
		 if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
		curl_close( $ch );
		//echo $result;
		
		 $response = json_decode($result, true);                             
		 $response = (object)$response;
		 $success = $response->success;
         //echo json_encode($result); 
		 //print_r($response);
		 return $success;
		// exit;
		
		
		 //echo "<pre>";print_r($message);
		 //print_r(json_encode($message));
	 }
	 
	public function ReviewsList(HttpRequest $request) {
		
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key',$request->input('apikey'))->first();
			
			
			if( count($user) ) {
				
				/*if( $user->user_type_id == 2 ) {
					
					$reviews	=	DB::table('review')
									->select('id','user_id','user_name','biz_id','review','created_at')
									->where('user_id', $user->id)
									->get();
					if( count($reviews) ) {
						foreach($reviews as $row => $field) {
							if( $field->user_name ) {
								$field->user_name = ucwords($field->user_name);
							}
								$field->created_at = date('d F Y',strtotime($field->created_at));
						}
					}
					$data['img_url'] 	= url('uploads/pictures/dp/'.$user->photo);
					$data['reviews'] 	= $reviews;
					$data['status']		= 'success';
					unset($data['alerts']);
				}
				else {
					$data['alerts'] = 'available only for business users.';
				}*/
				
				$reviews	= 	\DB::table('review')
									->where('review.user_id',$user->id)
									->join('business','business.id','=','review.biz_id')
									->leftjoin('businessImages','businessImages.biz_id','=','review.biz_id')
									->orderBy('review.created_at','DESC')
									->groupBy('review.biz_id')
									->select('review.*', 'business.title as biz_title', 'businessImages.filename as biz_image')
									->get();
									
				if( count($reviews) ) {
							
							foreach( $reviews as $key => $field ) {
								
								if( $field->biz_image ) {
									$field->biz_image	= 'https://www.howlik.com/'.$field->biz_image;
								}
								else {
									$field->biz_image	= 'https://www.howlik.com/uploads/pictures/no-image.jpg';
								}
								
							}
						}

				$data['reviews']	=	$reviews; 
				$data['status'] = 'success';
				$data['alerts'] = 'success';
									
				
			}
			return json_encode($data);
		}
	
	public function ActivityList(HttpRequest $request) {
		
			
		$data 			= [];
		$data['status'] = 'error';
		$data['alerts'] = 'invalid credential.';
		$user			= User::where('api_key',$request->input('apikey'))->first();
		
		if( count($user) ) {
			
			if( $user->user_type_id == 2 ) {
				
				$activity	=	\DB::table('events')
									->select('event_image1','id','user_id','event_name','created_at','about_event')
									->where('events.user_id',$user->id)
									->orderBy('events.created_at','DESC')->get();
							
				if( count($activity) ) {
					foreach($activity as $row => $field) {
						if( $field->event_name ) {
							$field->event_name  = ucwords($field->event_name);
						}
							$field->created_at 	= date('d F Y',strtotime($field->created_at));
							if($field->event_image1!=''){
								$field->event_image = url($field->event_image1);
							}else{
								
								$field->event_image = '';
							}
					}
				}
				$data['activity'] 	= $activity;
				$data['status']		= 'success';
				unset($data['alerts']);
			}
			else {
				$data['alerts'] = 'available only for business users.';
			}
		}
		return json_encode($data);
	}
	public function UserIntrests(HttpRequest $request) {
		
		$data 			= [];
		$resVal			= array();
		$data['status'] = 'error';
		$data['alerts'] = 'invalid credential.';
		$user			= User::where('api_key',$request->input('apikey'))->first();
		//
		$resVal = array();
		if( count($user) ) {
			
			if( $user->user_type_id == 2 ) {
				
				$userArr        =  unserialize($user->interests); 
				if(count($userArr)>0 && !empty($userArr)) {
					foreach($userArr as $key=>$val){
						$resVal[] = $key;
					}
				}
				
				if($resVal!='') {
					
					$user_interest	= \DB::table('user_interest')
										->where('active',1)
										->where('translation_lang', $request->input('lang'))
										//->whereIn('id', $resVal)
										->get();
					//
					$resA = array();
					$interestA = unserialize($user->interests);
					if(count($interestA)>0 && count($user_interest)>0){
						foreach($user_interest as $key=>$interest){
							if(isset($interestA[$interest->translation_of]) && $interestA[$interest->translation_of] == 1){
										$resA[] = array(
													'id'=>$interest->id,
													'translation_lang'=>$interest->translation_lang,
													'translation_of'=>$interest->translation_of,
													'int_title'=>$interest->int_title,
													'int_img'=>$interest->int_img,
													'active'=>$interest->active,
													'created_at'=>$interest->created_at,
													'updated_at'=>$interest->updated_at
												);
								
								
								}
						}
					}
					
					
					
					$data['user_interest_old'] 	 	= $user_interest;
					$data['status']		= 'success';
					unset($data['alerts']);
					$data['user_interest'] 	 	= (array)$resA;
				}else {
				
					$data['user_interest'] 	 	 = '';
				}
				
				$data['status']				 = 'success';
				unset($data['alerts']);
			}
			else {
				$data['alerts'] = 'available only for business users.';
			}
		}
		return json_encode($data);
	}
	public function NotificationsAll(HttpRequest $request) {
		
		$data 			= [];
		$data['status'] = 'error';
		$data['alerts'] = 'invalid credential.';
		if($request->input('apikey')!='') {
		$user			= User::where('api_key',$request->input('apikey'))->first();
		
			if( count($user)>0 ) {
				/* $notifications	= NotificationsAll::where('user_id',$user->id)->get(); */
				$notifications = DB::table('notifications_all')->where('user_id',$user->id);
				if( $request->has('language_code') ) {
					$notifications->where('lang',$request->input('language_code'));
				}
				$notifications  = $notifications->get();
				if(count($notifications)>0) {
					$data['notifications'] 	 	 = $notifications;
				
				}else {
					$data['notifications'] 	 	 = [];   
				} 
				$data['status']				     = 'success';
				unset($data['alerts']);
			}
			
			
		}else { $data['alerts'] = 'apikey is required';}
		
		return json_encode($data);
	}	
	
	public function GetBusinessReviews(HttpRequest $request) 
	{
			$data 			= [];
			$data['status'] = 'error';
				
			if($request->has('biz_id') && $request->input('biz_id')!='' && $request->has('page') && $request->input('page')!='' )
			{
				if($request->has('apikey') && $request->input('apikey')!='')
				{
					$user			= User::where('api_key', $request->input('apikey'))->first();
					//if( count($user) ) {
				}
				
				$biz_id = $request->input('biz_id');
				$page	= $request->input('page');
				$take	= 15;
				$skip	= 15 * ($page - 1);
				
				$reviews	= DB::table('review')
								->select('review.id', 'review.user_name as person', 'review.review', 'review.rating', 'review.expense', 'review.created_at as date', 'users.photo')
								->leftjoin('users', 'review.user_id', '=', 'users.id')
								->orderBy('review.created_at', 'DESC')
								->where('biz_id', $request->input('biz_id'))
								->take($take)
								->skip($skip)
								->get();	
						
				if( count($reviews) ) {
							
							foreach( $reviews as $key => $field ) {
								
								if( $field->person ) {
									$field->person = ucwords($field->person);
								}
								if( $field->review ) {
									$field->review = ucwords($field->review);
								}
								if( $field->photo ) {
									$field->photo	= 'https://www.howlik.com/uploads/pictures/dp/'.$field->photo;
								}
								else {
									$field->photo	= 'https://www.howlik.com/uploads/pictures/dp/demo.jpg';
								}
								if( $field->date ) {
									$field->date	= date('d-m-Y', strtotime($field->date));
								}
							}
						}

				$data['reviews']	=	$reviews;
				$data['status'] = 'success';
				
			}
			
			return json_encode($data);
			
		}
	
}	