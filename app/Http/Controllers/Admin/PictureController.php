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
use App\Http\Requests\Admin\PictureRequest as StoreRequest;
use App\Http\Requests\Admin\PictureRequest as UpdateRequest;


class PictureController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Picture",
        "entity_name" => "picture",
        "entity_name_plural" => "pictures",
        "route" => "admin/picture",
        "reorder" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'id',
                'label' => "ID"
            ],
            [
                'name' => 'filename',
                'label' => "Filename",
                'type' => "model_function",
                'function_name' => 'getFilenameHtml',
            ],
            [
                'name' => 'ad_id',
                'label' => "Ad",
                'type' => "model_function",
                'function_name' => 'getAdTitleHtml',
            ],
            [
                'name' => 'active',
                'label' => "Active",
                'type' => "model_function",
                'function_name' => 'getActiveHtml',
            ],
        ],
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
            [
                'name' => 'ad_id',
                'label' => 'Ad',
                'model' => "App\Larapen\Models\Ad",
                'entity' => 'ad',
                'attribute' => 'title',
                'type' => 'select2',
            ],
            [
                'name' => 'filename',
                'label' => 'Picture',
                'type' => 'browse'
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
