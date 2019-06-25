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
use App\Http\Requests\Admin\PackRequest as StoreRequest;
use App\Http\Requests\Admin\PackRequest as UpdateRequest;

class PackController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Pack",
        "entity_name" => "pack",
        "entity_name_plural" => "packs",
        "route" => "admin/pack",
        "reorder" => true,
        "reorder_label" => "name",
        "reorder_max_level" => 1,
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
            [
                'name' => 'price',
                'label' => "Price"
            ],
            [
                'name' => 'currency_code',
                'label' => "Currency"
            ],
            [
                'name' => 'active',
                'label' => "Active",
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
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'text',
                'placeholder' => 'Enter a description'
            ],
            [
                'name' => 'price',
                'label' => 'Price',
                'type' => 'text',
                'placeholder' => 'Enter a price'
            ],
            [
                'label' => "Currency",
                'name' => 'currency_code',
                'model' => "App\Larapen\Models\Currency",
                'entity' => 'currency',
                'attribute' => 'name',
                'type' => 'select2',
            ],
            [
                'name' => 'active',
                'label' => "Active",
                'type' => 'checkbox'
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
