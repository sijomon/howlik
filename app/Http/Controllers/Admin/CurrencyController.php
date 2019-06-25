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
use App\Http\Requests\Admin\CurrencyRequest as StoreRequest;
use App\Http\Requests\Admin\CurrencyRequest as UpdateRequest;

class CurrencyController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Currency",
        "entity_name" => "currency",
        "entity_name_plural" => "currencies",
        "route" => "admin/currency",
        "reorder" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'code',
                'label' => "Code"
            ],
            [
                'name' => 'name',
                'label' => "Name"
            ],
            [
                'name' => 'html_entity',
                'label' => "Html Entity"
            ],
            [
                'name' => 'in_left',
                'label' => "Symbol in left"
            ],
        ],
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
            [
                'name' => 'code',
                'label' => 'Code',
                'type' => 'text',
                'placeholder' => 'Enter the currency code (ISO Code)'
            ],
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
                'placeholder' => 'Enter the currency name'
            ],
            [
                'name' => 'html_entity',
                'label' => 'Html Entity',
                'type' => 'text',
                'placeholder' => 'Enter the html entity code'
            ],
            [
                'name' => 'font_arial',
                'label' => 'Font Arial',
                'type' => 'text',
                'placeholder' => 'Enter the font arial code'
            ],
            [
                'name' => 'font_code2000',
                'label' => 'Font Code2000',
                'type' => 'text',
                'placeholder' => 'Enter the font code2000 code'
            ],
            [
                'name' => 'unicode_decimal',
                'label' => 'Unicode Decimal',
                'type' => 'text',
                'placeholder' => 'Enter the unicode decimal code'
            ],
            [
                'name' => 'unicode_hex',
                'label' => 'Unicode Hex',
                'type' => 'text',
                'placeholder' => 'Enter the unicode hex code'
            ],
            [
                'name' => 'in_left',
                'label' => "Symbol in left",
                'type' => 'checkbox'
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
