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

namespace App\Http\Controllers\Admin;

use App\Larapen\Models\Gender;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Larapen\CRUD\app\Http\Controllers\CrudController;
use Auth;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\UserRequest as StoreRequest;
use App\Http\Requests\Admin\UserRequest as UpdateRequest;

class UserController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\User",
        "entity_name" => "user",
        "entity_name_plural" => "users",
        "route" => "admin/user",
        "reorder" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => "id",
                'label' => "ID"
            ],
            [
                'name' => "name",
                'label' => "Name",
            ],
            [
                'name' => "email",
                'label' => "Email",
            ],
            [
                'name' => "user_type_id",
                'label' => "Type",
                'model' => "App\Larapen\Models\UserType",
                'entity' => "userType",
                'attribute' => "name",
                'type' => "select",
            ],
            [
                'label' => "Country",
                'name' => "country_code",
                'model' => "App\Larapen\Models\Country",
                'entity' => "country",
                'attribute' => "asciiname",
                'type' => "select",
            ],
            [
                'name' => "active",
                'label' => "Active",
                'type' => "model_function",
                'function_name' => "getActiveHtml",
            ],
        ],
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "create_fields" => [
            [
                'name' => "email",
                'label' => "Email Address",
                'type' => "email",
                'placeholder' => "Admin user's Email Address",
            ],
            [
                'name' => "password",
                'label' => "Password",
                'type' => "password",
                'placeholder' => "Enter a password",
            ],
            [
                'label' => "Gender",
                'name' => "gender_id",
                'type' => "select_from_array",
                'options' => [],
                'allows_null' => false,
            ],
            [
                'name' => "name",
                'label' => "Name",
                'type' => "text",
                'placeholder' => "First Name and Last Name",
            ],
            [
                'name' => "about",
                'label' => "About",
                'type' => "textarea",
                'placeholder' => "About the user",
            ],
            [
                'name' => "phone",
                'label' => "Phone",
                'type' => "text",
                'placeholder' => "Phone",
            ],
            [
                'name' => "phone_hidden",
                'label' => "Phone hidden",
                'type' => "checkbox",
            ],
            [
                'label' => "Country",
                'name' => "country_code",
                'model' => "App\Larapen\Models\Country",
                'entity' => "country",
                'attribute' => "asciiname",
                'type' => "select2",
            ],
            [
                'name' => "user_type_id",
                'label' => "Type",
                'model' => "App\Larapen\Models\UserType",
                'entity' => "userType",
                'attribute' => "name",
                'type' => "select2",
            ],
            [
                'name' => "is_admin",
                'label' => "Is admin",
                'type' => "checkbox",
            ],
            [
                'name' => "receive_newsletter",
                'label' => "Receive newsletter",
                'type' => "checkbox",
            ],
            [
                'name' => "receive_advice",
                'label' => "Receive advice",
                'type' => "checkbox",
            ],
            [
                'name' => "blocked",
                'label' => "Blocked",
                'type' => "checkbox",
            ],
            [
                'name' => "active",
                'label' => "Active",
                'type' => "checkbox",
            ],
        ],
        
        
        "update_fields" => [
            [
                'name' => "email",
                'label' => "Email Address",
                'type' => "email",
                'placeholder' => "Admin user's Email Address",
            ],
            [
                'label' => "Gender",
                'name' => "gender_id",
                'type' => "select_from_array",
                'options' => [],
                'allows_null' => false,
            ],
            [
                'name' => "name",
                'label' => "Name",
                'type' => "text",
                'placeholder' => "First Name and Last Name",
            ],
            [
                'name' => "about",
                'label' => "About",
                'type' => "textarea",
                'placeholder' => "About the user",
            ],
            [
                'name' => "phone",
                'label' => "Phone",
                'type' => "text",
                'placeholder' => "Phone",
            ],
            [
                'name' => "phone_hidden",
                'label' => "Phone hidden",
                'type' => "checkbox",
            ],
            [
                'label' => "Country",
                'name' => "country_code",
                'model' => "App\Larapen\Models\Country",
                'entity' => "country",
                'attribute' => "asciiname",
                'type' => "select2",
            ],
            [
                'name' => "user_type_id",
                'label' => "Type",
                'model' => "App\Larapen\Models\UserType",
                'entity' => "userType",
                'attribute' => "name",
                'type' => "select2",
            ],
            [
                'name' => "is_admin",
                'label' => "Is admin",
                'type' => "checkbox",
            ],
            [
                'name' => "receive_newsletter",
                'label' => "Receive newsletter",
                'type' => "checkbox",
            ],
            [
                'name' => "receive_advice",
                'label' => "Receive advice",
                'type' => "checkbox",
            ],
            [
                'name' => "blocked",
                'label' => "Blocked",
                'type' => "checkbox",
            ],
            [
                'name' => "active",
                'label' => "Active",
                'type' => "checkbox",
            ],
        ],
    );
    
    public function __construct()
    {
        // Create
        $newFields = [];
        foreach ($this->crud['create_fields'] as $field) {
            if ($field['name'] == 'gender_id') {
                $field['options'] = $this->gender();
            }
            $newFields[] = $field;
        }
        $this->crud['create_fields'] = $newFields;
        
        // Update
        $newFields = [];
        foreach ($this->crud['update_fields'] as $key => $field) {
            if ($field['name'] == 'gender_id') {
                $field['options'] = $this->gender();
            }
            /* Security for SuperAdmin */
            if (Request::segment(3) == 1) {
                if (in_array($field['name'], ['user_type_id', 'is_admin', 'blocked', 'active'])) {
                    continue;
                }
            }
            $newFields[] = $field;
        }
        $this->crud['update_fields'] = $newFields;
        
        
        parent::__construct();


        // Encrypt password
        if (Input::has('password')) {
            Input::merge(array('password' => bcrypt(Input::get('password'))));
        }
    }
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    
    public function account()
    {
		
		
        $this->data['crud']['update_fields'] = [
            [
                'label' => "Gender",
                'name' => "gender_id",
                'type' => "select_from_array",
                'options' => $this->gender(),
                'allows_null' => false,
            ],
            [
                'name' => "name",
                'label' => "Local Name",
                'type' => "text",
                'placeholder' => "Your First Name and Last Name",
            ],
            [
                'name' => "about",
                'label' => "About",
                'type' => "textarea",
                'placeholder' => "About you",
            ],
            [
                'name' => "email",
                'label' => "Email",
                'type' => "text",
                'placeholder' => "Your Email Address",
            ],
            [
                'name' => "password",
                'label' => "Password",
                'type' => "password",
                'placeholder' => "Your Password",
            ],
            [
                'name' => "phone",
                'label' => "Phone",
                'type' => "text",
                'placeholder' => "Your phone number",
            ],
            [
                'name' => "phone_hidden",
                'label' => "Phone hidden",
                'type' => "checkbox",
            ],
            [
                'label' => "Country",
                'name' => "country_code",
                'model' => "App\Larapen\Models\Country",
                'entity' => "country",
                'attribute' => "asciiname",
                'type' => "select2",
            ],
            [
                'name' => "receive_newsletter",
                'label' => "Receive newsletter",
                'type' => "checkbox",
            ],
            [
                'name' => "receive_advice",
                'label' => "Receive advice",
                'type' => "checkbox",
            ]
        ];
        
        // Get logged user
        if (Auth::check()) {
            return $this->edit(Auth::user()->id);
        } else {
            abort(403, 'Not allowed.');
        }
    }
    
    public function gender()
    {
        $entries = Gender::where('translation_lang', config('app.locale'))->get();
        if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        foreach ($entries as $entry) {
            $tab[$entry->translation_of] = $entry->name;
        }
        
        return $tab;
    }
}
