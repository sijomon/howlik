<?php

	namespace App\Http\Controllers\Api;
	use App\Http\Controllers\Controller;

	use Auth;
	use Mail;
	use Hash;
	use App\Larapen\Events\UserWasRegistered;
	use App\Larapen\Helpers\Ip;
	use App\Larapen\Helpers\Rules;
	use App\Larapen\Scopes\ActiveScope;
	use App\Larapen\Scopes\ReviewedScope;
	use App\Larapen\Models\Ad;
	use App\Larapen\Models\Gender;
	use App\Larapen\Models\UserType;
	use App\Larapen\Models\User;
	use App\Larapen\Events\UserWasLogged;
	use Illuminate\Support\Facades\Event;
	use Illuminate\Support\Facades\Password;
	use Illuminate\Http\Request as HttpRequest;
	use Illuminate\Support\Facades\Request as Request;
	use Illuminate\Support\Collection;
	use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
	use Illuminate\Support\Facades\Validator;
	use Illuminate\Support\Facades\View;
	use Torann\LaravelMetaTags\Facades\MetaTag;
	use Larapen\CountryLocalization\Facades\CountryLocalization;
	use Larapen\CountryLocalization\Helpers\Country;

	use Illuminate\Foundation\Auth\ResetsPasswords;
	
	class AuthController extends Controller {
		
		use AuthenticatesAndRegistersUsers;
		
		/**
		 * Get the registration form.
		 *
		 * @return Response
		 */
		public function GetRegister(HttpRequest $request) {
			
			$data 				= [];
			$data['status']		= 'success';
			
			$language_code		=	'en';
			if( $request->has('language_code') ) {
				$language_code	=	$request->input('language_code');
			}
			
			$order = array('KW', 'SA', 'AE', 'BH', 'QA', 'OM', 'IN');
			$countries 	= \DB::table('countries');
			if( $language_code == 'ar' ) {
				$countries = $countries->select('code', 'name as title');
			}
			else {
				$countries = $countries->select('code', 'asciiname as title');
			}
			$countries	= $countries->where('active', 1)->orderBy('order')->get();
			
			$data['countries'] 	= $countries;
			$data['genders'] 	= Gender::select('translation_of', 'name')->where('translation_lang', $language_code)->get();
			$data['usertypes'] 	= UserType::select('id', 'name')->where('active', 1)->get();
			
			return json_encode($data);
		}
		
		/**
		 * Post the registration form.
		 *
		 * @return Response
		 */
		public function PostRegister(HttpRequest $request) {
			
			$data 				= [];
			$data['status']		= 'error';
				
			$notifications['receive_emails']	= 1;
			$notifications['friend_requests']	= 1;
			$notifications['messages']			= 1;
			$notifications['order_updates']		= 1;
			$notifications['disc_promo']		= 1;
			
			$customer	= User::where("email", $request->input('email'))->first();
			if( count($customer) ) {
				$data['status']		= 'error';
				$data['alerts']		= 'This email address already exist.';
				return json_encode($data);
			}
			
			$apikey = rand(11111,99999).time();
			
			// Store User
			$userInfo = array(
				'api_key'     			=> $apikey,
				'country_code'     		=> $request->input('country'),
				'gender_id'        		=> $request->input('gender'),
				'name'             		=> $request->input('name'),
				'user_type_id'     		=> $request->input('usertype'),
				'phone'            		=> $request->input('phone'),
				'email'            		=> $request->input('email'),
				'password'         		=> bcrypt($request->input('password')),
				'ip_addr'          		=> Ip::get(),
				'activation_token' 		=> md5(uniqid()),
				'email_notifications'	=> serialize($notifications),
				'active'				=> (config('settings.require_users_activation') == 1) ? 0 : 1,
			);
			$user = new User($userInfo);
			$user->save();
			
			// Update Ads created by this email
			if (isset($user->id) and $user->id > 0) {
				Ad::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->where('seller_email', $request->input('email'))->update(['user_id' => $user->id]);
			}
			
			// Send Welcome Email
			//if (config('settings.require_users_activation') == 1) {
				Event::fire(new UserWasRegistered($user));
			//}
			
			// BOF new code to show add business page after business user signup.
			if( $request->input('user_type') == 2 ){
				
				$credentials = $this->getCredentials($request);
			
				if (Auth::attempt($credentials, $request->has('remember'))) {
					// Update last user logged Date
					Event::fire(new UserWasLogged(User::find(Auth::user()->id)));
				}
			}
			// EOF new code to show add business page after business user signup.
			
			if( !empty($user) ) {
				$data['status']	= 'success';
				$data['key']	= $apikey;
				$data['user']	= $user;
				unset($data['alerts']);
			}
			return json_encode($data);
		}
		
		/**
		 * Post the login form.
		 *
		 * @return Response
		 */
		public function PostLogin(HttpRequest $request) {  
			
			$data 				= [];
			$data['status']		= 'error';
			$data['alerts']		= 'invalid credentials.';
			if( $request->has('email') && $request->has('password') ) {
				
				$email 		= $request->input('email');
				$password	= $request->input('password');
				$customer	= User::where("email", $email)->first();
				
				if( count($customer) ) {
					
					if( Hash::check($request->input('password'), $customer->password) ) { 
						
						if( $customer->active == 1 ) {
								
							$apikey 						= rand(11111,99999).time();
							$customer->api_key				= $apikey; 
							$customer->apikey_updated_at	= date("Y-m-d H:i:s", time());
							$customer->save();
							
							$data['status']	= 'success';
							$data['user']	= $customer;
							unset($data['alerts']);
							$data['apikey']	= $apikey;
						}
						else {
							$data['alerts'] = 'please confirm your email to continue.';
						}
					}
					else {
						$data['alerts'] = 'please confirm your password to continue.';
					}
				}			
			}
			return json_encode($data);
		}
		
		/**
		 * Post the forgot password.
		 *
		 * @return Response
		 */
		public function ForgotPassword(HttpRequest $request) {
			
			$data 				= [];
			$data['status']		= 'error';
			$data['alerts']		= 'invalid credentials.';
			if($request->has('email')) {
				
				$email 		= $request->input('email');
				$customer	= User::where("email", $email)->first();
				if( count($customer) ) {  
				
					$apikey 						= rand(11111,99999).time();
					$customer->api_key				= $apikey; 
					$customer->apikey_updated_at	= date("Y-m-d H:i:s", time());
					$customer->save();
					
					$data['url'] = 'http://www.howlik.com/en/password/reset/'.str_random(50);
					Mail::send('emails.forgot', $data, function($message) use ($data, $request) {
						$message->to($request->input('email'))->subject("Your Password Reset Link"); 
					});
					$data['status']		= 'success';
					unset($data['alerts']);
				}
			}
			return json_encode($data);
		}
		
		/**
		 * Post the change password.
		 *
		 * @return Response
		 */
		public function ChangePassword(HttpRequest $request) {
			
			$data 			= [];
			$data['status'] = 'error';
			$data['alerts'] = 'invalid credential.';
			$user			= User::where('api_key', $request->input('apikey'))->first();
			if( count($user) ) {
				
				/* $date 			= new \DateTime();
				$updated_at 	= new \DateTime($user->apikey_updated_at);
				$time_now 	    = new \DateTime($date->format('Y-m-d h:i:s'));
				$interval 		= $updated_at->diff($time_now);
			    $elapsed 		= $interval->format('%h hours %i minutes %S seconds');
			    $expire_time 	= $interval->h;
			    $expire_date	= $interval->d;
				if( ( $expire_time < 24 ) && ( $expire_date == 0 ) ) { */
					
					$new_p  = Hash::make($request->input('new_password'));
					if( Hash::check($request->input('old_password'), $user->password )) {
						
						$user->password = $new_p;
						$user->save();
						
						$data['status'] = 'success';
						unset($data['alerts']);
					}
					else {
						$data['alerts'] = 'check your old password.';
					}
				/* }
				else {
					$data['alerts'] = 'inactive credential.';
				} */
			}
			return json_encode($data);
		}
		
	}	