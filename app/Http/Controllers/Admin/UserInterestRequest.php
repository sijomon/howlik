<?php

	namespace App\Http\Requests\Admin;

	use Backpack\CRUD\app\Http\Requests\CrudRequest as BackpackCrudRequest;

	class UserInterestRequest extends BackpackCrudRequest
	{
		/**
		 * Get the validation rules that apply to the request.
		 *
		 * @return array
		 */
		public function rules()
		{
			return [
				'int_title' => 'required',
			];
		}
		
		public function messages()
		{
			return [];
		}
	}
