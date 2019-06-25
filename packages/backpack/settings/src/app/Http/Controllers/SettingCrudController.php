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

namespace Larapen\Settings\app\Http\Controllers;

use App\Http\Requests;
use Larapen\CRUD\app\Http\Controllers\CrudController;
use Backpack\Settings\app\Http\Requests\SettingRequest as StoreRequest;
use Backpack\Settings\app\Http\Requests\SettingRequest as UpdateRequest;

class SettingCrudController extends CrudController
{
    public $crud = array(
        "model" => "Larapen\Settings\app\Models\Setting",
        "entity_name" => "setting",
        "entity_name_plural" => "settings",
        "route" => "admin/setting",
        "reorder" => true,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "view_table_permission" => true,
        "add_permission" => false,
        "edit_permission" => true,
        "delete_permission" => false,
        
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'lft',
                'label' => "#"
            ],
            [
                'name' => 'name',
                'label' => "Name"
            ],
            [
                'name' => 'value',
                'label' => "Value",
                'type' => "model_function",
                'function_name' => 'getLogoHtml',
            ],
            [
                'name' => 'description',
                'label' => "Description"
            ],
        ],
        
        
        // *****
        // FIELDS
        // *****
        "fields" => [
            [
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
                'disabled' => 'disabled'
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'disabled' => 'disabled'
            ],
            [
                'name' => 'value',
                'label' => 'Value',
                'type' => 'text'
            ],
        ],
    );
    
    /**
     * Display all rows in the database for this entity.
     * This overwrites the default CrudController behaviour:
     * - instead of showing all entries, only show the "active" ones
     *
     * @return Response
     */
    public function index()
    {
        // if view_table_permission is false, abort
        if (isset($this->crud['view_table_permission']) && !$this->crud['view_table_permission']) {
            abort(403, 'Not allowed.');
        }
        
        // get all results for that entity
        $model = $this->crud['model'];
        // this is where it's different
        $this->data['entries'] = $model::where('active', 1)->OrderBy('lft')->get();
        
        // checks that the columns are defined and makes sure the response is proper
        $this->prepareColumns();
        
        $this->data['crud'] = $this->crud;
        $this->data['title'] = ucfirst($this->crud['entity_name_plural']);
        
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        if (view()->exists('vendor.backpack.crud.list')) {
            return view('vendor.backpack.crud.list', $this->data);
        } else {
            return view('crud::list', $this->data);
        }
    }
    
    /**
     * Show the form for editing the specified setting.
     * This overwrites the default CrudController behaviour:
     * - instead of showing the same field type for all settings, show the field type from the "field" db column
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        // if edit_permission is false, abort
        if (isset($this->crud['edit_permission']) && !$this->crud['edit_permission']) {
            abort(403, 'Not allowed.');
        }
        
        // get the info for that entry
        $model = $this->crud['model'];
        $this->data['entry'] = $model::find($id);
        // set the default field type (defined in SettingCrudController)
        if (isset($this->data['crud']['update_fields'])) {
            $this->crud['fields'] = $this->data['crud']['update_fields'];
        }
        // replace the VALUE field with the one defined as JSON in the database
        if ($this->data['entry']->field) {
            $value_field = (array)json_decode($this->data['entry']->field);
            foreach ($this->crud['fields'] as $key => $field) {
                if ($field['name'] == 'value') {
                    $this->crud['fields'][$key] = $value_field;
                }
            }
        }
        // prepare the fields you need to show and prepopulate the values
        $this->prepareFields($this->data['entry']);
        
        $this->data['crud'] = $this->crud;
        $this->data['title'] = trans('backpack::crud.edit') . ' ' . $this->crud['entity_name'];
        
        // load the view from /resources/views/vendor/backpack/crud/ if it exists, otherwise load the one in the package
        if (view()->exists('vendor.backpack.crud.edit')) {
            return view('vendor.backpack.crud.edit', $this->data);
        } else {
            return view('crud::edit', $this->data);
        }
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
