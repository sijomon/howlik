<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use App\Larapen\Models\Cms;
use Larapen\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\CmsRequest as StoreRequest;
use App\Http\Requests\Admin\CmsRequest as UpdateRequest;

class CmsController extends CrudController
{
	
	
    public $crud = array(
        "model" => "App\Larapen\Models\Cms",
        "entity_name" => "cms",
        "entity_name_plural" => "cms",
        "route" => "admin/cms",
		"reorder" => true,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "details_row" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => "id",
                'label' => "ID"
            ],
            [
                'name' => "cms_name",
                'label' => "Title",
            ],
			
            [
                'name' => "cms_description",
                'label' => "Discription",
                'type' => "textarea",
                'placeholder' => "Cms Discription",
            ],
          
        ],
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
           
            [
                'name' => "cms_name",
                'label' => "Title",
                'type' => "text",
                'placeholder' => "Title",
            ],
			[
                'name' => "cms_name_ar",
                'label' => "Title [AR]",
                'type' => "text",
                'placeholder' => "Title [AR]",
            ],
			
			 [
                'name' => "cms_description",
                'label' => "Cms Discription",
                'type' => "ckeditor",
                'placeholder' => "Cms Discription",
            ],
			[
                'name' => "cms_description_ar",
                'label' => "Discription [AR]",
                'type' => "ckeditor",
                'placeholder' => "Discription [AR]",
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
    

    
   
}
