<?php
namespace App\Http\Requests\Admin;

use Backpack\CRUD\app\Http\Requests\CrudRequest as BackpackCrudRequest;

class BusinessInfoRequest extends BackpackCrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'info_type' => 'required',
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
