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

namespace App\Http\Controllers\Admin;

use App\Larapen\Models\User;
use App\Larapen\Models\AdReviews;
use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\ReviewRequest as StoreRequest;
use App\Http\Requests\Admin\ReviewRequest as UpdateRequest;
use Session;

class AdReviewController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\AdReviews",
        "entity_name" => "Reviews",
        "entity_name_plural" => "Reviews",
        "route" => "admin/reviews",
        "reorder" => false,
        "add_permission" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'created_at',
                'label' => "Date",
            ],
            [
                'name' => 'user',
                'label' => "User",
				'type' => "model_function",
                'function_name' => 'getuser',
            ],
            [
                'name' => 'review',
                'label' => "Review",
            ],
			          
        ],
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
           
             [
                'name' => 'review',
                'label' => "Review",
            ],
            
            
        ],
    );
    
    public function __construct()
    {
        //$this->crud['update_fields'][1]['options'] = $this->adType();
       // $this->crud['update_fields'][2]['options'] = $this->categories();
     
        parent::__construct();
    }
	
	/* Display review list*/
	
    public function detail($tid)
	{
		$query = \DB::table('review')
						->select('*','review.id as rid')
						->join('users','users.id','=','review.user_id')
						->where('ads_id',$tid)
						->get();
		//echo "<pre>";print_r($query);die;
		return view('vendor.backpack.crud.review',compact('query'));
	}
	
	/* Review delete */
	public function reviewdelete($tid)
	{
		
		if( $tid > 0 )
		{
			//$model = AdReviews::find($tid);
			\DB::table('review')->where('id', '=', $tid)->delete();
			Session::flash('success','Review deleted successfully');
			return redirect()->back();
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
