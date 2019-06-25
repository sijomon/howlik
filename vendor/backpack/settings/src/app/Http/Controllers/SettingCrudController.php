<?php namespace Backpack\Settings\app\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION
use Backpack\Settings\app\Http\Requests\SettingRequest as StoreRequest;
use Backpack\Settings\app\Http\Requests\SettingRequest as UpdateRequest;

class SettingCrudController extends CrudController {

	public $crud = array(
						"model" => "Backpack\Settings\app\Models\Setting",
						"entity_name" => "setting",
						"entity_name_plural" => "settings",
						"route" => "admin/setting",

						"view_table_permission" => true,
						"add_permission" => false,
						"edit_permission" => true,
						"delete_permission" => false,

						"reorder" => false,
						"reorder_label" => "name",

						// *****
						// COLUMNS
						// *****
						"columns" => [
											[
												'name' => 'name',
												'label' => "Name"
											],
											[
												'name' => 'value',
												'label' => "Value"
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
		$this->data['entries'] = $model::where('active', 1)->get(); // <---- this is where it's different

		$this->prepareColumns(); // checks that the columns are defined and makes sure the response is proper

		$this->data['crud'] = $this->crud;
		$this->data['title'] = ucfirst($this->crud['entity_name_plural']);

		// load the view from /resources/views/vendor/dick/crud/ if it exists, otherwise load the one in the package
		if (view()->exists('vendor.dick.crud.list'))
		{
			return view('vendor.dick.crud.list', $this->data);
		}
		else
		{
			return view('crud::list', $this->data);
		}
	}

	/**
	 * Show the form for editing the specified setting.
	 * This overwrites the default CrudController behaviour:
	 * - instead of showing the same field type for all settings, show the field type from the "field" db column
	 *
	 * @param  int  $id
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
		if (isset($this->data['crud']['update_fields']))
		{
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
		$this->prepareFields($this->data['entry']); // prepare the fields you need to show and prepopulate the values

		$this->data['crud'] = $this->crud;
		$this->data['title'] = trans('backpack::crud.edit').' '.$this->crud['entity_name'];

		// load the view from /resources/views/vendor/dick/crud/ if it exists, otherwise load the one in the package
		if (view()->exists('vendor.dick.crud.edit'))
		{
			return view('vendor.dick.crud.edit', $this->data);
		}
		else
		{
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
