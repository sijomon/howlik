<?php
namespace App\Http\Controllers\Admin;

use Larapen\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\CountryRequest as StoreRequest;
use App\Http\Requests\Admin\CountryRequest as UpdateRequest;

class CountryController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Country",
        "entity_name" => "country",
        "entity_name_plural" => "countries",
        "route" => "admin/country",
        "reorder" => false,
        "sort" => [
                'col' => 5,
                'type' => "desc"
            ],
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
                'label' => "Name (Arabic)"
            ],
            [
                'name' => 'asciiname',
                'label' => "Name"
            ],
            [
                'name' => 'tld',
                'label' => "Tld"
            ],
            [
                'name' => 'languages',
                'label' => "Languages"
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
                'name' => 'code',
                'label' => 'Code',
                'type' => 'text',
                'placeholder' => 'Enter the country code (ISO Code)'
            ],
            [
                'name' => 'name',
                'label' => 'Name (Arabic)',
                'type' => 'text',
                'placeholder' => 'Enter the country name (In Arabic)'
            ],
            [
                'name' => 'asciiname',
                'label' => "Name",
                'type' => 'text',
                'placeholder' => 'Enter the country name (In English)'
            ],
            [
                'name' => 'capital',
                'label' => "Capital (Optional)",
                'type' => 'text',
                'placeholder' => 'Enter the country capital'
            ],
            [
                'name' => 'continent_code',
                'label' => "Continent (Optional)",
                'type' => 'text',
                'placeholder' => 'Enter the continent code (ISO: AF, AN, AS, EU, NA, OC, SA)'
            ],
            [
                'name' => 'tld',
                'label' => "TLD (Optional)",
                'type' => 'text',
                'placeholder' => 'Enter the country tld (E.g. .bj for Benin)'
            ],
            [
                'label' => "Currency Code",
                'type' => 'select2',
                'name' => 'currency_code',
                'attribute' => 'name',
                'model' => "App\Larapen\Models\Currency",
            ],
            [
                'name' => 'phone',
                'label' => "Phone Ind. (Optional)",
                'type' => 'text',
                'placeholder' => 'Enter the country phone ind. (E.g. +229 for Benin)'
            ],
            [
                'name' => 'languages',
                'label' => "Languages",
                'type' => 'text',
                'placeholder' => 'Enter the locale code (ISO) separate with comma'
            ],
			[
                'name' => 'c_latitude',
                'label' => "Latitude",
                'type' => 'text',
                'placeholder' => 'Enter the Latitude code'
            ],
			[
                'name' => 'c_longitude',
                'label' => "Longitude",
                'type' => 'text',
                'placeholder' => 'Enter the Longitude code'
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
