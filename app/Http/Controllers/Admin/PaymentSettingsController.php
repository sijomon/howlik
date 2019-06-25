<?php
namespace App\Http\Controllers\Admin;

use App\Larapen\Models\PaymentSettings;
use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\PaymentSettingsRequest as StoreRequest;
use App\Http\Requests\Admin\PaymentSettingsRequest as UpdateRequest;
use Request;
use Carbon\Carbon;

class PaymentSettingsController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\PaymentSettings",
        "entity_name" => "payment setting",
        "entity_name_plural" => "payment settings",
        "route" => "admin/payment-settings",
        "reorder" => false,
		"edit_permission" => true,
		"delete_permission" => false,
		"add_permission" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'title',
                'label' => "Title",
            ],
			[
                'name' => 'mode',
                'label' => "Mode",
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
                'name' => 'title',
                'label' => 'Title',
                'type' => 'text',
            ],
			[
                'label' => "Mode",
                'name' => 'mode',
                'type' => 'select_from_array',
                'options' => [],
                'allows_null' => false,
            ],
			[
                'name' => 'details',
                'label' => "Payment Details",
                'type' => 'pay_details',
            ],
			[
                'name' => 'active',
                'label' => "Active",
                'type' => 'checkbox'
            ],
        ],
    );
    
	public function __construct()
    {
        $this->crud['fields'][1]['options'] = array('live'=>'Live', 'test'=>'Test');
        
        parent::__construct();
    }
	
    public function store(StoreRequest $request)
    {
		foreach ($this->crud['fields'] as $k => $field) {
			if($request->has($field['name']) && $field['name']=='details'){
				$request->merge(array($field['name'] => serialize($request->get($field['name']))));
			}
		}
        return parent::storeCrud($request);
    }
    
    public function update(UpdateRequest $request)
    {
		foreach ($this->crud['fields'] as $k => $field) {
			if($request->has($field['name']) && $field['name']=='details'){
				$request->merge(array($field['name'] => serialize($request->get($field['name']))));
			}
		}
        return parent::updateCrud($request);
    }
	
	
}