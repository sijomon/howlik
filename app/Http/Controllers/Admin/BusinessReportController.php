<?php

namespace App\Http\Controllers\Admin;

use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessScam;

use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\BusinessScamRequest as StoreRequest;
use App\Http\Requests\Admin\BusinessScamRequest as UpdateRequest;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Request;
use DB;
use Redirect;
use Validator;

class BusinessReportController extends CrudController
{
    public $crud = array(
    
        "model" => "App\Larapen\Models\BusinessScam",
        "entity_name" => "Business Scam Report",
        "entity_name_plural" => "Business Scam Reports",
        "route" => "admin/business-scam",
        "reorder" => false,
        "add_permission" => false,
		"edit_permission" => false,
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'biz_id',
                'label' => "Business",
                'type' => "model_function",
                'function_name' => 'getBizTitleHtml',
            ],
            [
                'name' => 'user_id',
                'label' => "User",
                'type' => "model_function",
                'function_name' => 'getUser',
            ],
            [
                'name' => 'reason',
                'label' => "Reason",
            ],
            [
                'name' => 'ip_addr',
                'label' => "Ip",
            ],
            [
                'name' => 'created_at',
                'label' => "Created at",
                
            ],
			
            
        ],
        
		'fields' => [
			[   
				// Hidden
				'name' => 'id',
				'label' => "id",
				'type' => 'hidden'
			],
		
		],
        
        // *****
        // FIELDS ALTERNATIVE
        // *****]
		// "update_fields" => [
		
		"fields" => [
			[
				'label' => "Reason",
				'name' => 'reason',
				'id' => 'reason',
				'type' => 'text',
			],
		],
    );
	
    public function __construct()
    {
		
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
	
	public function location()
	{
		/*$code   = Request::get('code');
		$curLoc = Request::get('curLoc');
		
		$entries = SubAdmin1::where('code', 'LIKE', $code . '.%')->orderBy('name')->get(['code', 'asciiname']);
		$res = '<option value="">Location</option>';
		foreach ($entries as $key => $entry) {
			$sel = ''; if($entry->code==$curLoc)$sel = '  selected="selected""';
			$res .= '<option value="'.$entry->code.'" '.$sel.'>'.$entry->asciiname.'</option>';
        }
		echo json_encode (array( 'res' => $res ));*/
	}
	
}
