<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use App\Larapen\Models\EventTopic;
use Larapen\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\EventtopicRequest as StoreRequest;
use App\Http\Requests\Admin\EventtopicRequest as UpdateRequest;

class EventTopicController extends CrudController
{
	
	
    public $crud;
    
    public function __construct()
    {
        $this->crud = array(
        "model" => "App\Larapen\Models\EventTopic",
        "entity_name" => "Event Topic",
        "entity_name_plural" => "Event Topics",
        "route" => "admin/event_topic",
		"reorder" => false,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "details_row" => false,
        "add_permission" => true,
		
        // *****
        // COLUMNS
        // *****
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
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
           [   // Info
				'name' => 'name',
				'label' => 'Event Topic',
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
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
	
}
