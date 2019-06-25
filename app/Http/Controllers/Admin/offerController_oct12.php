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

use App\Larapen\Models\Offer;
use Illuminate\Support\Facades\Request;
use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\OfferRequest as StoreRequest;
use App\Http\Requests\Admin\OfferRequest as UpdateRequest;
use Input;

class offerController extends CrudController
{
	//public  $tab = [];
	
    public $crud = array(
        "model" => "App\Larapen\Models\Offer",
        "entity_name" => "Offer",
        "entity_name_plural" => "Offer",
        "route" => "admin/offers",
        "reorder" => true,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "details_row" => true,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'id',
                'label' => "ID"
            ],
            [
                'name' => 'offer',
                'label' => "Offer Name"
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
                'name' => 'offer',
                'label' => 'Offer',
                'type' => 'text',
                'placeholder' => 'Enter a title'
            ],
            
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'placeholder' => 'Enter a description'
            ],
            [
                'name' => 'image',
                'label' => 'Picture',
                'type' => 'browse'
            ],
            /*[
                'name' 			=> 'css_class',
                'label' 		=> 'CSS Class',
                'type' 			=> 'text',
                'placeholder' 	=> 'CSS Class'
            ],
           [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'enum',
            ],*/
            [
                'name' => 'active',
                'label' => "Active",
                'type' => 'checkbox'
            ],
        ],
    );
    
    public function __construct()
    {
       /* if (Request::segment(3) == 'create') {
				//echo "hello";die;
			
			$offer = [
                'name' => 'offer',
                'label' => 'Offer',
                'type' => 'text',
                'placeholder' => 'Enter a title'
            ];
			
            //array_unshift($this->crud['fields'], $parentField1,$parentField);
			 array_unshift($this->crud['fields'],$offer);
			
        }*/
        
      
        parent::__construct();
		//echo "hello";die;
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
