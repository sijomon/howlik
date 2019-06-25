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

namespace App\Http\Requests\Admin;

use Backpack\CRUD\app\Http\Requests\CrudRequest as BackpackCrudRequest;

class EventRequest extends BackpackCrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		 return [
            'event_name' 		=> 'required|min:3|max:255',
			'event_topic' 		=> 'required|min:3|max:255',
			'event_type_id' 	=> 'required',
			'about_event' 		=> 'required',
			'event_place' 		=> 'required',
			'event_image1' 		=> 'required',
			'event_date' 		=> 'required|date',
			'event_starttime' 	=> 'required',
			'eventEnd_date' 	=> 'required|date',
			'event_endtime' 	=> 'required',
			'organization' 		=> 'required',
			'org_description' 	=> 'required'
			
        ];
		
		}
}
