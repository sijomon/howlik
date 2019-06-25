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

use Larapen\Base\app\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class PasswordController extends Controller
{
    use ResetsPasswords;
    
    protected $redirectPath = '/admin';
    protected $redirectTo = '/admin';
    protected $data = [];
    
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->middleware('guest');
    }
    
    // -------------------------------------------------------
    // Laravel overwrites for loading backpack views
    // -------------------------------------------------------
    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $this->data['title'] = "Reset password";
        
        if (property_exists($this, 'linkRequestView')) {
            return view($this->linkRequestView);
        }
        
        if (view()->exists('backpack::auth.passwords.email')) {
            return view('backpack::auth.passwords.email', $this->data);
        }
        
        return view('backpack::auth.password', $this->data);
    }
    
    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null $token
     * @return \Illuminate\Http\Response
     */
    public function showResetForm(Request $request, $token = null)
    {
        $this->data['title'] = "Reset password";
        
        if (is_null($token)) {
            return $this->getEmail();
        }
        
        $email = $request->input('email');
        
        if (property_exists($this, 'resetView')) {
            return view($this->resetView)->with(compact('token', 'email'));
        }
        
        if (view()->exists('backpack::auth.passwords.reset')) {
            return view('backpack::auth.passwords.reset', $this->data)->with(compact('token', 'email'));
        }
        
        return view('backpack::auth.reset', $this->data)->with(compact('token', 'email'));
    }
}
