<?php
namespace App\Http\Controllers\Admin;

use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\BusinessImageRequest as StoreRequest;
use App\Http\Requests\Admin\BusinessImageRequest as UpdateRequest;


class BusinessImageController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\BusinessImage",
        "entity_name" => "business image",
        "entity_name_plural" => "business images",
        "route" => "admin/business-image",
        "reorder" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'id',
                'label' => "ID"
            ],
            [
                'name' => 'filename',
                'label' => "Filename",
                'type' => "model_function",
                'function_name' => 'getFilenameHtml',
            ],
            [
                'name' => 'biz_id',
                'label' => "Business",
                'type' => "model_function",
                'function_name' => 'getAdTitleHtml',
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
                'name' => 'biz_id',
                'label' => 'Business',
                'model' => "App\Larapen\Models\Business",
                'entity' => 'business',
                'attribute' => 'title',
                'type' => 'select2',
            ],
            [
                'name' => 'filename',
                'label' => 'Picture',
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
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
}