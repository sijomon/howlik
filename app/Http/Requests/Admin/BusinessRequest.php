<?php
namespace App\Http\Requests\Admin;

use Backpack\CRUD\app\Http\Requests\CrudRequest as BackpackCrudRequest;

class BusinessRequest extends BackpackCrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => 'required|not_in:0',
            'title' => 'required|between:5,200',
            'description' => 'required|between:5,3000',
            'phone' => 'required|between:3,200',
            'address1' => 'required',
			'country_code' => 'required|not_in:0',
			'subadmin1_code' => 'required|not_in:0',
			'city_id' => 'required',
        ];
    }
	
	public function messages()
    {
        return [
			/* 'address1.required' => 'The address is required.',
			 'subadmin1_code.required' => 'The location is required.',
			 'city_id.required' => 'The city is required.',*/
		];
    }
}
