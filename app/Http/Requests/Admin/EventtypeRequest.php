<?php

	namespace App\Http\Requests\Admin;

	use Backpack\CRUD\app\Http\Requests\CrudRequest as BackpackCrudRequest;

	class EventtypeRequest extends BackpackCrudRequest
	{
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules()
		{
			return [
			
				'name'	=>	'required|min:1|max:255'
			];
			
		}
	}
