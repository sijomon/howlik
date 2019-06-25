<?php
namespace App\Http\Controllers\Admin;

use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\BusinessInfoRequest as StoreRequest;
use App\Http\Requests\Admin\BusinessInfoRequest as UpdateRequest;


class BusinessInfoController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\BusinessInfo",
        "entity_name" => "business info",
        "entity_name_plural" => "business info",
        "route" => "admin/business-info",
        "reorder" => false,
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
                'name' => 'info_title',
                'label' => "Title",
            ],
			[
                'name' => 'info_type',
                'label' => "Info Type",
                'type' => "model_function",
                'function_name' => 'getInfoType',
            ],
            [
                'name' => 'info_vals',
                'label' => "Values",
                'type' => "model_function",
                'function_name' => 'getInfoVals',
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
                'name' => 'info_title',
                'label' => 'Title',
                'type' => 'text',
                'placeholder' => 'Title',
            ],
            [
                'label' => "Info Type",
                'name' => 'info_type',
				'id' => 'info_type',
                'type' => 'select_from_array',
                'options' => array(1 => 'Text box', 2 => 'Select box', 3 => 'Radio button'),
                'allows_null' => false,
            ],
			[
                'label' => "Info Values",
                'name' => 'info_vals',
                'type' => 'business_info_vals',
            ],
            [
                'name' => 'info_img',
                'label' => 'Icon',
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
		foreach ($this->crud['fields'] as $k => $field) {
			if($request->has($field['name']) && $field['name']=='info_vals'){
				$request->merge(array($field['name'] => serialize($request->get($field['name']))));
			}
		}
        
        $response = parent::storeCrud($request);
		//BOF code to insert value in translation_of for default language [Vin]
		if(isset($this->crud['item'])){
			$item = $this->crud['item'];
			if(isset($item->translation_lang) && $item->translation_lang=='en'){
				$item->translation_of = $item->id;
				$item->save();
			}
		}
		//EOF code to insert value in translation_of for default language [Vin]
		return $response;
    }
    
    public function update(UpdateRequest $request)
    {
		foreach ($this->crud['fields'] as $k => $field) {
			if($request->has($field['name']) && $field['name']=='info_vals'){
				$request->merge(array($field['name'] => serialize($request->get($field['name']))));
			}
		}
        return parent::updateCrud($request);
    }
}
