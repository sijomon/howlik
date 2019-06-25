<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use App\Larapen\Models\EventType;
use Larapen\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\EventtypeRequest as StoreRequest;
use App\Http\Requests\Admin\EventtypeRequest as UpdateRequest;

class EventTypeController extends CrudController
{
	
	
    public $crud;
    
    public function __construct()
    {
        $this->crud = array(
        
			"model" => "App\Larapen\Models\EventType",
			"entity_name" => "Event Type",
			"entity_name_plural" => "Event Types",
			"route" => "admin/event_type",
			"reorder" => false,
			"details_row" => true,
			
			// *******
			// COLUMNS
			// *******
			"columns" => [
				[
					'name' => "id",
					'label' => "ID"
				],
				[
					'name' => "name",
					'label' => "Event Type",
				],
				[
					'name' => 'active',
					'label' => "Active",
					'type' => "model_function",
					'function_name' => 'getActiveHtml',
				],
			  
			],
			
			
			// ****** ***********
			// FIELDS ALTERNATIVE
			// ****** ***********
			"fields" => [
			   [   // Info
					'name' => 'name',
					'label' => 'Event Type',
					'type' => 'text',
					'id'=>'name'
				],
				[
					'name' => 'active',
					'label' => "Active",
					'type' => 'checkbox',
				],
				
			],
        
		);
        //parent::__construct();
        
    }
    
    public function store(StoreRequest $request)
    {
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
        return parent::updateCrud();
    }
	
}
