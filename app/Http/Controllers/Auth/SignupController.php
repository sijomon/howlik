<?php

namespace App\Http\Controllers\Auth;

use App\Larapen\Events\UserWasRegistered;
use App\Larapen\Helpers\Ip;
use App\Larapen\Helpers\Rules;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use App\Larapen\Models\Ad;
use App\Larapen\Models\Gender;
use App\Larapen\Models\UserType;
use App\Larapen\Models\User;
use App\Http\Controllers\FrontController;
use App\Larapen\Events\UserWasLogged;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;

class SignupController extends FrontController
{
	use AuthenticatesAndRegistersUsers;
    public $msg = [];
    
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        
        /*
         * Messages
         */
        $this->msg['signup']['success'] = "Your account has been created.";
        $this->msg['activation']['success'] = "Congratulation :first_name ! Your account has been activated.";
        $this->msg['activation']['multiple'] = "Your account is already activated.";
        $this->msg['activation']['error'] = "Your account's activation has failed.";
    }
    
    /**
     * Show the form the create a new user account.
     *
     * @return Response
     */
    public function getRegister()
    {
        $data = [];
        
        // References
        $data['countriess'] = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'))->lists('name', 'code');
        $data['genders'] 	= Gender::where('translation_lang', $this->lang->get('abbr'))->get();
        $data['userTypes'] 	= UserType::all();
        
        // Meta Tags
        MetaTag::set('title', t('Sign Up'));
        MetaTag::set('description', t('Sign Up on :app_name !', ['app_name' => mb_ucfirst(config('settings.app_name'))]));
        
        return view('classified.auth.signup.index', $data);
    }
    
    /**
     * Store a new ad post.
     *
     * @param  Request $request
     * @return Response
     */
    public function postRegister(HttpRequest $request)
    {
        // Form validation
        $validator = Validator::make($request->all(), Rules::Signup($request));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
		$email_notificationsA['receive_emails'] = 1;
		$email_notificationsA['friend_requests'] = 1;
		$email_notificationsA['messages'] = 1;
		$email_notificationsA['order_updates'] = 1;
		$email_notificationsA['disc_promo'] = 1;
        
        // Store User
        $userInfo = array(
            'country_code'     		=> $request->input('country'),//$this->country->get('code') vin edit to fix country select
            'gender_id'        		=> $request->input('gender'),
            'name'             		=> $request->input('name'),
            'user_type_id'     		=> $request->input('user_type'),
            'phone'            		=> $request->input('phone'),
            'email'            		=> $request->input('email'),
            'password'         		=> bcrypt($request->input('password')),
            'phone_hidden'     		=> $request->input('phone_hidden'),
            'ip_addr'          		=> Ip::get(),
            'activation_token' 		=> md5(uniqid()),
			'email_notifications'	=> serialize($email_notificationsA),
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
        
		// BOF new code to show add business page after business user signup. 21/7/17
		if($request->input('user_type')==2){
			
			$credentials = $this->getCredentials($request);
        
			if (Auth::attempt($credentials, $request->has('remember'))) {
				// Update last user logged Date
				Event::fire(new UserWasLogged(User::find(Auth::user()->id)));
				return redirect()->intended($this->lang->get('abbr') . '/add-business')->with(['success' => 1, 'message' => t($this->msg['signup']['success'])]);
			}
		}
		// EOF new code to show add business page after business user signup. 21/7/17
		
        return redirect($this->lang->get('abbr') . '/signup/success')->with(['success' => 1, 'message' => t($this->msg['signup']['success'])]);
    }
    
    public function success()
    {
        if (!session('success')) {
            return redirect('/');
        }
        
        // Meta Tags
        MetaTag::set('title', session('message'));
        MetaTag::set('description', session('message'));
        
        return view('classified.auth.signup.success');
    }
    
    public function activation()
    {
        $token = Request::segment(4);
        if (trim($token) == '') {
            abort(404);
        }
        
        $user = User::withoutGlobalScope(ActiveScope::class)->where('activation_token', $token)->first();
        
        if ($user) {
            if ($user->active != 1) {
                // Activate
                $user->active = 1;
                $user->save();
                flash()->success(t($this->msg['activation']['success'], ['first_name' => $user->name]));
            } else {
                flash()->error(t($this->msg['activation']['multiple']));
            }
            // Connect the User
            if (Auth::loginUsingId($user->id)) {
                //$this->user = Auth::user();
                //View::share('user', $this->user);
                return redirect($this->lang->get('abbr') . '/account');
            } else {
                return redirect($this->lang->get('abbr') . '/login');
            }
        } else {
            $data = ['error' => 1, 'message' => t($this->msg['activation']['error'])];
        }
        
        // Meta Tags
        MetaTag::set('title', $data['message']);
        MetaTag::set('description', $data['message']);
        
        return view('classified.auth.signup.activation', $data);
    }
}
