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

use App\Larapen\Helpers\Ip;
use Auth;
use App\Http\Controllers\FrontController;
use App\Larapen\Models\User;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;
use Laracasts\Flash\Flash;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends FrontController
{
    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    protected $redirectPath = '/account';
    private $network = ['facebook', 'google', 'twitter'];
    
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        //$this->middleware('guest');
    }
    
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        $provider = Request::segment(2);
        if (!in_array($provider, $this->network)) {
            $provider = Request::segment(3);
        }
        if (!in_array($provider, $this->network)) {
            abort(404);
        }
        
        return Socialite::driver($provider)->redirect();
    }
    
    /**
     * Obtain the user information from Provider.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $provider = Request::segment(2);
        if (!in_array($provider, $this->network)) {
            $provider = Request::segment(3);
        }
        if (!in_array($provider, $this->network)) {
            abort(404);
        }
        
        // Country Code
        if (isset($this->country) and $this->country) {
            $country_code = $this->country->get('code');
        } else {
            $country_code = (isset($this->ip_country) and $this->ip_country) ? $this->ip_country->get('code') : null;
        }
        
        // API CALL - GET USER FROM PROVIDER
        try {
            $user_data = Socialite::driver($provider)->user();

            // Data not found
            if (!$user_data) {
                flash()->error(t("Unknown error. Please try again in a few minutes."));
                return redirect($this->lang->get('abbr') . '/' . trans('routes.login'));
            }

            // Email not found
            if (!$user_data OR !filter_var($user_data->getEmail(), FILTER_VALIDATE_EMAIL)) {
                flash()->error(t("Email address not found. You can't use your :provider account on our website.", ['provider' => ucfirst($provider)]));
                return redirect($this->lang->get('abbr') . '/' . trans('routes.login'));
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (is_string($msg) and !empty($msg)) {
                flash()->error($msg);
            } else {
                flash()->error("Unknown error. The service does not work.");
            }
            
            return redirect($this->lang->get('abbr') . '/' . trans('routes.login'));
        }
        
        // Debug
        // dd($user_data);
        
        // DATA MAPPING
        try {
            $map_user = [];
            if ($provider == 'facebook') {
                $map_user['gender_id'] = (isset($user_data->user['gender']) and $user_data->user['gender'] == 'male') ? 1 : 2;
                $map_user['name'] = (isset($user_data->user['name'])) ? $user_data->user['name'] : '';
                if ($map_user['name'] == '') {
                    if (isset($user_data->user['first_name']) and isset($user_data->user['last_name'])) {
                        $map_user['name'] = $user_data->user['first_name'] . ' ' . $user_data->user['last_name'];
                    }
                }
            } else {
                if ($provider == 'google') {
                    $map_user = [
                        'gender_id' => (isset($user_data->user['gender']) and $user_data->user['gender'] == 'male') ? 1 : 2,
                        'name'      => (isset($user_data->name)) ? $user_data->name : '',
                    ];
                }
            }

            // GET LOCAL USER
            $user = User::where('provider', $provider)->where('provider_id', $user_data->getId())->first();

            // CREATE LOCAL USER IF DON'T EXISTS
            if (!$user) {
                // Before... Check if user has not signup with an email
                $user = User::where('email', $user_data->getEmail())->first();
                if (!$user) {
                    $user_info = [
                        'country_code' => $country_code,
                        'gender_id'    => $map_user['gender_id'],
                        'name'         => $map_user['name'],
                        'email'        => $user_data->getEmail(),
                        'ip_addr'      => Ip::get(),
                        'active'       => 1,
                        'provider'     => $provider,
                        'provider_id'  => $user_data->getId(),
                        'created_at'   => date('Y-m-d H:i:s'),
                    ];
                    $user = new User($user_info);
                    $user->save();
                } else {
                    // Update 'created_at' if empty (for time ago module)
                    if (empty($user->created_at)) {
                        $user->created_at = date('Y-m-d H:i:s');
                        $user->save();
                    }
                }
            }

            // GET A SESSION FOR USER
            if (Auth::loginUsingId($user->id)) {
                return redirect()->intended($this->lang->get('abbr') . '/account');
            } else {
                flash()->error("The Email Address or Password don't match.");

                return redirect($this->lang->get('abbr') . '/' . trans('routes.login'));
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            if (is_string($msg) and !empty($msg)) {
                flash()->error($msg);
            } else {
                flash()->error("Unknown error. The service does not work.");
            }

            return redirect($this->lang->get('abbr') . '/' . trans('routes.login'));
        }
    }
}
