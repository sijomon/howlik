<?php
/**
 * LaraClassified - Geo Classified Ads CMS
 * Copyright (c) Mayeul Akpovi. All Rights Reserved
 *
 * Email: mayeul.a@larapen.com
 * Website: http://larapen.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace Larapen\Base\app\Http\Controllers\Auth;

use App\Larapen\Models\User;
use Validator;
use Illuminate\Http\Request;
use Backpack\Base\app\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    protected $data = []; // the information we send to the view
    protected $redirectAfterLogout = 'admin/login';
    
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'admin';
    
    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
    
    // -------------------------------------------------------
    // Laravel overwrites for loading backpack views
    // -------------------------------------------------------
    /**
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $view = property_exists($this, 'loginView') ? $this->loginView : 'auth.authenticate';
        
        if (view()->exists($view)) {
            return view($view);
        }
        
        $this->data['title'] = "Login";
        
        return view('backpack::auth.login', $this->data);
    }
    
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        // if registration is closed, deny access
        if (!config('base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }
        
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }
        
        $this->data['title'] = "Register";
        
        return view('backpack::auth.register', $this->data);
    }
    
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // if registration is closed, deny access
        if (!config('base.registration_open')) {
            abort(403, trans('backpack::base.registration_closed'));
        }
        
        $validator = $this->validator($request->all());
        
        if ($validator->fails()) {
            $this->throwValidationException($request, $validator);
        }
        
        Auth::guard($this->getGuard())->login($this->create($request->all()));
        
        return redirect($this->redirectPath());
    }
}
