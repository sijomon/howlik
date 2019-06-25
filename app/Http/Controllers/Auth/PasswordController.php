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

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Password;
use Torann\LaravelMetaTags\Facades\MetaTag;

class PasswordController extends FrontController
{
    use ResetsPasswords;
    
    protected $redirectPath = '/account';
    protected $redirectTo = '/account';
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->middleware('guest');
    }
    
    public function getEmail()
    {
        // Meta Tags
        MetaTag::set('title', t('Lost your password?'));
        MetaTag::set('description', t('Lost your password?'));
        
        return view('classified.auth.password.index');
    }
    
    public function postEmail(Request $request)
    {
        // validation
        $this->validate($request, [
            'email' => 'required|email',
        ]);
        
        $response = Password::sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });
        
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return redirect()->back()->with('status', trans($response));
            
            case Password::INVALID_USER:
                return redirect()->back()->withErrors(['email' => trans($response)]);
        }
    }
    
    public function getReset($token = null)
    {
        if (is_null($token)) {
            abort(404);
        }
        
        return view('classified.auth.password.reset', ['token' => $token]);
    }
    
    public function postReset(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ]);
        
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');
        
        $response = Password::reset($credentials, function ($user, $password) {
            $this->resetPassword($user, $password);
        });
        
        switch ($response) {
            case Password::PASSWORD_RESET:
                return redirect($this->redirectPath());
            
            default:
                return redirect()->back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
        }
    }
}
