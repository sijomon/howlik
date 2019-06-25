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

namespace App\Http\Requests\Admin;

use App\Larapen\Models\User;
use Backpack\CRUD\app\Http\Requests\CrudRequest as BackpackCrudRequest;
use Illuminate\Support\Facades\Request;

class UserRequest extends BackpackCrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (is_numeric(Request::segment(3))) {
            $uniqueEmailIsRequired = true;
            
            $user = User::find(Request::segment(3));
            if (!is_null($user)) {
                if ($user->email == $this->email) {
                    $uniqueEmailIsRequired = false;
                }
            }
            
            return [
                'gender_id' => 'required|not_in:0',
                'name' => 'required|min:3|max:100',
                'country_code' => 'sometimes|required|not_in:0',
                'email' => ($uniqueEmailIsRequired) ? 'required|email|unique:users,email' : 'required|email',
                //'password' => 'required|between:5,15',
            ];
        } else {
            return [
                'gender_id' => 'required|not_in:0',
                'name' => 'required|min:3|max:100',
                'user_type_id' => 'required|not_in:0',
                'country_code' => 'sometimes|required|not_in:0',
                'email' => 'required|email|unique:users,email',
                //'password' => 'required|between:5,15',
            ];
        }
    }
}
