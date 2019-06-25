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

use App\Larapen\Models\AdType;
use App\Larapen\Models\Category;
use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\AdRequest as StoreRequest;
use App\Http\Requests\Admin\AdRequest as UpdateRequest;

class AdController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Ad",
        "entity_name" => "ad",
        "entity_name_plural" => "ads",
        "route" => "admin/ad",
        "reorder" => false,
        "add_permission" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'created_at',
                'label' => "Date",
            ],
            [
                'name' => 'title',
                'label' => "Title",
                'type' => "model_function",
                'function_name' => 'getTitleHtml',
            ],
            [
                'name' => 'price',
                'label' => "Price",
            ],
            [
                'name' => 'seller_name',
                'label' => "Saller Name",
            ],
            [
                'name' => 'country_code',
                'label' => "Country",
            ],
            [
                'name' => 'city_id',
                'label' => "City",
                'type' => "model_function",
                'function_name' => 'getCityHtml',
            ],
            [
                'name' => 'active',
                'label' => "Active",
                'type' => "model_function",
                'function_name' => 'getActiveHtml',
            ],
            [
                'name' => 'reviewed',
                'label' => "Reviewed",
                'type' => "model_function",
                'function_name' => 'getReviewedHtml',
            ],
			[
                'name' => 'Ratings',
                'label' => "Ratings",
                'type' => "model_function",
                'function_name' => 'getRatingsHtml',
            ],
        ],
        
		'fields' =>[
			[   // Hidden
						'name' => 'id',
						'label' => "id",
						'type' => 'hidden'
					],
		
		],
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "update_fields" => [
            [
                'label' => "Pictures",
                'name' => 'pictures', // Entity method
                'entity' => 'pictures', // Entity method
                'attribute' => 'filename',
                'type' => 'read_images',
            ],
            [
                'label' => "Ad Type",
                'name' => 'ad_type_id',
                'type' => 'select_from_array',
                'options' => [],
                'allows_null' => false,
            ],
            [
                'label' => "Category",
                'name' => 'category_id',
                'type' => 'select_from_array',
                'options' => [],
                'allows_null' => false,
            ],
            [
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
                'placeholder' => 'Ad title',
            ],
            [
                'name' => 'description',
                'label' => "Description",
                'type' => 'textarea',
                'placeholder' => 'Description',
            ],
            [
                'name' => 'price',
                'label' => "Price",
                'type' => 'text',
                'placeholder' => 'Price',
            ],
            [
                'name' => 'negotiable',
                'label' => "Negotiable Price",
                'type' => 'checkbox',
            ],
            [
                'name' => 'new',
                'label' => "Is New",
                'type' => 'checkbox',
            ],
            [
                'name' => 'resume',
                'label' => 'Resume (Only if need - Supported file extensions: pdf, doc, docx, jpg or png)',
                'type' => 'browse',
            ],
            [
                'name' => 'seller_name',
                'label' => 'User Name',
                'type' => 'text',
                'placeholder' => 'User Name',
            ],
            [
                'name' => 'seller_email',
                'label' => 'User Email',
                'type' => 'text',
                'placeholder' => 'User Email',
            ],
            [
                'name' => 'seller_phone',
                'label' => 'User Phone',
                'type' => 'text',
                'placeholder' => 'User Phone',
            ],
            [
                'name' => 'seller_phone_hidden',
                'label' => "Hide seller phone",
                'type' => 'checkbox',
            ],
           
            [
                'name' => 'archived',
                'label' => "Archived",
                'type' => 'checkbox'
            ],
            [
                'name' => 'active',
                'label' => "Active",
                'type' => 'checkbox'
            ],
            [
                'name' => 'reviewed',
                'label' => "Reviewed",
                'type' => 'checkbox'
            ],
        ],
    );
    
    public function __construct()
    {
        $this->crud['update_fields'][1]['options'] = $this->adType();
        $this->crud['update_fields'][2]['options'] = $this->categories();
        
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
    
    public function adType()
    {
        $entries = AdType::where('translation_lang', config('app.locale'))->get();
        if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        foreach ($entries as $entry) {
            $tab[$entry->translation_of] = $entry->name;
        }
        
        return $tab;
    }
    
    public function categories()
    {
        $entries = Category::where('translation_lang', config('app.locale'))->orderBy('lft')->get();
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
