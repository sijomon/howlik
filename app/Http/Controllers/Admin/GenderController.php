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

use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Requests\CrudRequest as StoreRequest;
use Backpack\CRUD\app\Http\Requests\CrudRequest as UpdateRequest;

class GenderController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Gender",
        "entity_name" => "gender",
        "entity_name_plural" => "genders",
        "route" => "admin/gender",
        "reorder" => false,
        "details_row" => true,
        "add_permission" => false,
        "delete_permission" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'id',
                'label' => "ID"
            ],
            [
                'name' => 'name',
                'label' => "Name"
            ],
        ],
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
                'placeholder' => 'Enter a name'
            ],
        ],
    );
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}
