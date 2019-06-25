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

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Larapen\Models\User;
use Auth;
use Illuminate\Support\Facades\Request;

class CloseController extends AccountBaseController
{
    public function index()
    {
        return view('classified.account/close');
    }
    
    public function submit()
    {
        if (Request::input('close_account_confirmation') == 1) {
            // Get User
            $user = User::find($this->user->id);
            if (is_null($user)) {
                abort(404);
            }

            // Don't delete admin users
            if ($user->is_admin or $user->is_admin == 1) {
                flash()->error("Admin users can't be deleted by this way.");
                return redirect($this->lang->get('abbr') . '/account');
            }
            
            // Delete User
            $user->delete();
            
            // Close User's session
            Auth::logout();
            
            flash()->success(t("Your account has been deleted. We regret you. <a href=\":url\">Re-register</a> if that is a mistake.", [
                'url' => url($this->lang->get('abbr') . '/' . trans('routes.signup'))
            ]));
        }
        
        return redirect($this->lang->get('abbr') . '/');
    }
}
