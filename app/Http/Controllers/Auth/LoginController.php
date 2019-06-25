<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\FrontController;
use App\Larapen\Events\UserWasLogged;
use App\Larapen\Helpers\Rules;
use Auth;
use App\Larapen\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Validator;
use Laracasts\Flash\Flash;
use Torann\LaravelMetaTags\Facades\MetaTag;
class LoginController extends FrontController
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    protected $loginPath = '/login';
    protected $redirectPath = '/account';
    
    public function __construct(HttpRequest $request)
    {
        $this->loginPath = '/' . Request::segment(1) . '/' . trans('routes.login');
        $this->redirectPath = '/' . Request::segment(1) . '/account';
        
        parent::__construct($request);
		$this->redirectTo = url()->previous();
        $this->middleware('guest', ['except' => 'getLogout']);
    }
    
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function getLogin()
    {
        // Remembering Users
        if (Auth::viaRemember()) {
            return redirect()->intended($this->lang->get('abbr') . '/account');
        }
        
        // Meta Tags
        MetaTag::set('title', t('Login'));
        MetaTag::set('description', t('Log in to :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.auth.login');
    }
    
    public function postLogin(HttpRequest $request)
    {
		
		
		
        // Form validation
        $validator = Validator::make($request->all(), Rules::Login($request));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Check if this is Throttle Attack
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();
        
        if ($throttles && $this->hasTooManyLoginAttempts($request)) {
            return $this->sendLockoutResponse($request);
        }
        
        $credentials = $this->getCredentials($request);
        
        if (Auth::attempt($credentials, $request->has('remember'))) {
			
			//if usertype = 2 then redirect to vendor side
			
			//if( )
			
            return $this->handleUserWasAuthenticated($request, $throttles);
        }
        
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles) {
            $this->incrementLoginAttempts($request);
        }
        
        // Auth the User
        if ($user = Auth::attempt([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'active' => 1
        ], $request->input('remember'))
        ) {
			
			
			
			
            // Update last user logged Date
            Event::fire(new UserWasLogged(User::find(Auth::user()->id)));
			
			
            
            return redirect()->intended($this->lang->get('abbr') . '/account');
        } else {
            flash()->error(t("The Email Address or Password don't match."));
            
            return redirect($this->lang->get('abbr') . '/' . trans('routes.login'));
        }
    }
    
    public function getLogout()
    {
        unset($this->user->account);
        Auth::logout();
        flash()->success(t('You have been logged out.'));
        
        return redirect($this->lang->get('abbr') . '/' . trans('routes.login'));
    }
}
