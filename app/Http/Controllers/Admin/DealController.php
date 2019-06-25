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

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use App\Larapen\Models\Deal;
use Larapen\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\DealRequest as StoreRequest;
use App\Http\Requests\Admin\DealRequest as UpdateRequest;

class DealController extends CrudController
{
	
	
    public $crud = array(
        "model" => "App\Larapen\Models\Deal",
        "entity_name" => "deal",
        "entity_name_plural" => "deals",
        "route" => "admin/deal",
		"reorder" => false,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "details_row" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => "id",
                'label' => "ID"
            ],
            [
                'name' => "deal_name",
                'label' => "Deal name",
            ],
            [
                'label' => "Country",
                'name' => "country_code",
                'model' => "App\Larapen\Models\Country",
                'entity' => "country",
                'attribute' => "asciiname",
                'type' => "select",
            ],
          
        ],
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
           
            [
                'name' => "deal_name",
                'label' => "Deal name",
                'type' => "text",
                'placeholder' => "Deal Name",
            ],
			[
                'name' => "deal_price",
                'label' => "Deal Price",
				'type' => 'number',
				'placeholder' => "Deal Price",
            ],
            [
                'name' => "deal_discription",
                'label' => "Deal Discription",
                'type' => "textarea",
                'placeholder' => "Deal Discription",
            ],
           
            [
                'name' => "deal_image",
                'label' => "Deal image",
				'type' => 'browse',
            ],
			 [
                'name' => "deal_datetime",
                'label' => "Deal Date & Time",
                'type' => "datetime",
            ],
            [
                'label' => "Country",
                'name' => "country_code",
                'model' => "App\Larapen\Models\Country",
                'entity' => "country",
                'attribute' => "asciiname",
                'type' => "select",
            ],
           
        ],
        
        
       
    );
    
    public function __construct()
    {
        
        parent::__construct();
        
    }
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    

    
   
}
