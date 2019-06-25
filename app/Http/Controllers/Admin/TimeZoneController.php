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
use App\Http\Requests\Admin\TimeZoneRequest as StoreRequest;
use App\Http\Requests\Admin\TimeZoneRequest as UpdateRequest;

class TimeZoneController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\TimeZone",
        "entity_name" => "time-zone",
        "entity_name_plural" => "time-zones",
        "route" => "admin/time_zone",
        "reorder" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'country_code',
                'label' => "Country Code"
            ],
            [
                'name' => 'time_zone_id',
                'label' => "Time Zone"
            ],
            [
                'name' => 'gmt',
                'label' => "GMT"
            ],
            [
                'name' => 'dst',
                'label' => "DST"
            ],
            [
                'name' => 'raw',
                'label' => "RAW"
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
                'label' => "Country Code",
                'type' => 'select2',
                'name' => 'country_code',
                'attribute' => 'asciiname',
                'model' => "App\Larapen\Models\Country",
            ],
            [
                'name' => 'time_zone_id',
                'label' => 'Time Zone',
                'type' => 'text',
                'placeholder' => 'Enter the TimeZone (ISO)'
            ],
            [
                'name' => 'gmt',
                'label' => "GMT",
                'type' => 'text',
                'placeholder' => 'Enter the GMT value (ISO)'
            ],
            [
                'name' => 'dst',
                'label' => "DST",
                'type' => 'text',
                'placeholder' => 'Enter the DST value (ISO)'
            ],
            [
                'name' => 'raw',
                'label' => "GMT",
                'type' => 'text',
                'placeholder' => 'Enter the RAW value (ISO)'
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
