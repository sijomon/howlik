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
	
	// use App\Larapen\Events\EventWasPosted;
	use App\Larapen\Events\BusinessWasPosted;
	use App\Larapen\Events\SendMessage;
	
	class TestController extends Controller 
	{
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
				$take	= 20;
				$skip	= 20 * ($page - 1);
				
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
									$field->photo	= 'uploads/pictures/dp/'.$field->photo;
								}
								else {
									$field->photo	= 'uploads/pictures/dp/demo.jpg';
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
									$field->biz_image	= $field->biz_image;
								}
								else {
									$field->biz_image	= 'uploads/pictures/no-image.jpg';
								}
								
							}
						}

				$data['reviews']	=	$reviews; 
				$data['status'] = 'success';
				$data['alerts'] = 'success';
									
				
			}
			return json_encode($data);
		}
	}