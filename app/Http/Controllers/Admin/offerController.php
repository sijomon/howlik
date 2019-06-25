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
	
    public $curd;
    
    public function __construct()
    {
       $this->crud = array(
        "model" => "App\Larapen\Models\Offer",
        "entity_name" => "Offer",
        "entity_name_plural" => "Offer",
        "route" => "admin/offers",
        "reorder" => false,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "details_row" => false,
        
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
                'name' => 'offer_location',
                'label' => "Location"
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
                'type' => 'ckeditor',
                'placeholder' => 'Enter a description'
            ],
            [
                'name'  => 'image',
                'label' => 'Picture',
                'type'  => 'browse'
            ],
			/*[
				'id'	=>"country_code",
				'name' => "country_code",
                'label' => "Country",
               	'type' => 'select_from_array',
				'options' => $this->countries(),
				'allows_null' => false,
				               
            ],*/
			
			[
				'name' => 'offer_location',
                'label' => 'Location',
                'type' => 'text',
                'placeholder' => 'Enter location'
			],
           [
                'name'        => 'company_name',
                'label'       => 'Company name',
                'type'        => 'text',
                'placeholder' => 'Enter company name'
            ],
			 [
                'name'  => 'company_logo',
                'label' => 'Company logo',
                'type'  => 'browse',
            ],
			[
                'name'  => 'compony_url',
                'label' => 'Company Url',
                'type'  => 'text',
            ],
            [
                'name'  => 'offer_percentage',
                'label' => 'Offer Percentage',
                'type'  => 'text'
            ],
            [
                'name'  => 'active',
                'label' => "Active",
                'type'  => 'checkbox'
            ],
        ],
    );
        
      
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
    
	public function countries()
	{
		$entries = \DB::table('countries')->select('code','asciiname')->where('active',1)->get();
      	if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        $tab[0] = 'Country';
        foreach ($entries as $entry) {
            //if ($entry->id != $currentId) {
                $tab[$entry->code] = '- ' . $entry->asciiname;
			// }
        }
        // echo "<pre>";print_r($tab);die;
        return $tab;
	}

}
