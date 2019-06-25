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

use App\Larapen\Models\Pack;
use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use Backpack\CRUD\app\Http\Requests\CrudRequest as StoreRequest;
use Backpack\CRUD\app\Http\Requests\CrudRequest as UpdateRequest;

class PaymentController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Payment",
        "entity_name" => "payment",
        "entity_name_plural" => "payments",
        "route" => "admin/payment",
        "reorder" => false,
        "add_permission" => false,
        "edit_permission" => false,
        //"delete_permission" 	=> false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'id',
                'label' => "ID"
            ],
            [
                'name' => 'created_at',
                'label' => "Date",
            ],
            [
                'name' => 'ad_id',
                'label' => "Ad",
                'type' => "model_function",
                'function_name' => 'getAdTitleHtml',
            ],
            [
                'name' => 'pack_id',
                'label' => "Pack",
                'type' => "model_function",
                'function_name' => 'getPackNameHtml',
            ],
            [
                'name' => 'payment_method_id',
                'label' => "Payment Method",
                'model' => "App\Larapen\Models\PaymentMethod",
                'entity' => 'paymentMethod',
                'attribute' => 'name',
                'type' => 'select',
            ],
        ],
        
        // *****
        // FIELDS
        // *****
        "fields" => [],
    
    );
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    
    // unused for this moment
    public function packs()
    {
        $entries = Pack::where('translation_lang', config('app.locale'))->orderBy('lft')->get();
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
