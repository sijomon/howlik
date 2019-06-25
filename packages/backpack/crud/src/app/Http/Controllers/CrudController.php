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

namespace Larapen\CRUD\app\Http\Controllers;

use Backpack\CRUD\app\Http\Controllers\CrudController as BackpackCrudController;
use Crypt;
use Illuminate\Support\Facades\Form as Form;
use Alert;
use Illuminate\Support\Facades\Input;

class CrudController extends BackpackCrudController
{
    public function __construct()
    {
        // Fix add enum fields
        $enumFields = ['active', 'reviewed', 'archived', 'default', 'blocked', 'closed'];
        foreach ($enumFields as $field) {
            if (Input::has($field)) {
                if (Input::get($field) == 'on') {
                    Input::merge([$field => 1]);
                }
            }
        }

        parent::__construct();
    }
    
    /**
     * Prepare the fields to be shown, stored, updated or created.
     *
     * Makes sure $this->crud['fields'] is in the proper format (array of arrays);
     * Makes sure $this->crud['fields'] also contains the id of the current item;
     * Makes sure $this->crud['fields'] also contains the values for each field;
     *
     */
    protected function prepareFields($entry = false)
    {
        // if the fields have been defined separately for create and update, use that
        if (!isset($this->crud['fields'])) {
            if (isset($this->crud['create_fields'])) {
                $this->crud['fields'] = $this->crud['create_fields'];
            } elseif (isset($this->crud['update_fields'])) {
                $this->crud['fields'] = $this->crud['update_fields'];
            }
        }
        
        // PREREQUISITES CHECK:
        // if the fields aren't set, trigger error
        if (!isset($this->crud['fields'])) {
            abort(500, "The CRUD fields are not defined.");
        }
        
        // if the fields are defined as a string, transform it to a proper array
        if (!is_array($this->crud['fields'])) {
            $current_fields_array = explode(",", $this->crud['fields']);
            $proper_fields_array = array();
            
            foreach ($current_fields_array as $key => $field) {
                $proper_fields_array[] = [
                    'name' => $field,
                    'label' => ucfirst($field), // TODO: also replace _ with space
                    'type' => 'text' // TODO: choose different types of fields depending on the MySQL column type
                ];
            }
            
            $this->crud['fields'] = $proper_fields_array;
        }
        
        // if no field type is defined, assume the "text" field type
        foreach ($this->crud['fields'] as $k => $field) {
            if (!isset($this->crud['fields'][$k]['type'])) {
                $this->crud['fields'][$k]['type'] = 'text';
            }
        }
        
        // if an entry was passed, we're preparing for the update form, not create
        if ($entry) {
            // put the values in the same 'fields' variable
            $fields = $this->crud['fields'];
            
            foreach ($fields as $k => $field) {
                // set the value
                if (!isset($this->crud['fields'][$k]['value'])) {
                    $this->crud['fields'][$k]['value'] = $entry->{$field['name']};
                }
            }
            
            // always have a hidden input for the entry id
            $this->crud['fields'][] = array(
                'name' => 'id',
                'value' => $entry->id,
                'type' => 'hidden'
            );
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        // SECURITY:
        // if delete_permission is false, abort
        if (isset($this->crud['delete_permission']) && !$this->crud['delete_permission']) {
            abort(403, trans('backpack::crud.unauthorized_access'));
        }
        
        $model = $this->crud['model'];
        $item = $model::find($id);
        if (!is_null($item)) {
            $item->delete();
        }
        
        return 'true';
    }
}
