<?php
namespace App\Http\Controllers\Admin;

use Larapen\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\subadmin1Request as StoreRequest;
use App\Http\Requests\Admin\subadmin1Request as UpdateRequest;
use Request;
use Redirect;

class subadmin1Controller extends CrudController
{
    public $curd;
	
	 public function __construct()
    {
		$this->crud = array(
        "model" => "App\Larapen\Models\Subadmin1",
        "entity_name" => "location",	
        "entity_name_plural" => "location",
        "route" => "admin/Location1",
        "reorder" => false,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'code',
                'label' => "Code"
            ],
            [
                'name' => 'name',
                'label' => "Name (Arabic)"
            ],
            [
                'name' => 'asciiname',
                'label' => "Name"
            ],
            
            [
                'name' => 'active',
                'label' => "Active",
            ],
        ],
        
        
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
           [
				'id' =>'country_code',
				'name' => 'country_code',
				'label' => 'County',
				'type' => 'select_from_array',
				'options' => $this->countries(),
				'allows_null' => false,
            ],
						
            [
                'name' => 'name',
                'label' => 'Name (Arabic)',
                'type' => 'text',
                'placeholder' => 'Enter the region name (In Arabic)'
            ],
            [
                'name' => 'asciiname',
                'label' => "Name",
                'type' => 'text',
                'placeholder' => 'Enter the region name (In English)'
            ],
           
            [
                'name' => 'active',
                'label' => "Active",
                'type' => 'checkbox',
				'value' => '1'
            ],
        ],
    );
    }
	
	
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
	
	
	public function countries()
	{
		$entries = \DB::table('countries')->select('code','asciiname')->where('active',1)->get();
      	if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        $tab[0] = 'Country';
        foreach ($entries as $entry) {
            
                $tab[$entry->code] = '- ' . $entry->asciiname;
		
        }
       // echo "<pre>";print_r($tab);die;
        return $tab;
	}
	 public function viewlist()
	 {
		 $cat = \DB::table('subadmin1')->get();
		 return view('vendor.backpack.crud.subadmin1List',compact('cat'));
	 }
	 
	 public  function addview()
	 {
		 $cat = \DB::table('countries')->select('code','asciiname')->where('active',1)->get();
		 return view('vendor.backpack.crud.subadmin1Add',compact('cat'));
	 }
	 
	 public function subadmin1postaddajax(StoreRequest $request)
	 {
		$country  = Request::get('parent_id');
		
		$code =    \DB::table('subadmin1')->get();
		$cot = \DB::table('subadmin1')
						->select('code')
						->where('code','like', $country.'.%')
						->orderBy('code','DESC')
						->get();
		if(!empty($cot))
		{
			foreach($cot as $c)
			{			
					$code1 = explode('.', $c->code, 2);
					$code2[] = $code1[1];
			}
		}
		else
			
			$code2[] ='00';
		
		$subadmin_code = max($code2) + 01;
		if($subadmin_code < 10)
			$subadmin_code = str_pad($subadmin_code,  2, "0",STR_PAD_LEFT);
		
		$subadmin_code1 = $country.".".$subadmin_code;
		$name     	 	 = $request->input('localname');
		$asciiname	  	 = $request->input('asciiname');
		
		$active		 = $request->input('active');
		//echo $trans;die;
		\DB::table('subadmin1')->insert(
			['code'=>$subadmin_code1,'name'=>$name,'asciiname'=>$asciiname,'active'=>$active]
		);
		return Redirect::to('admin/subadmin1');
	 }
	 
	 
	 /* subcategories Edit */
	
	public function subadmin1Edit($id)
	{
		$cat = \DB::table('subadmin1')
						->select('*')
						->where('id',$id)
						->get();
		
		return view('vendor.backpack.crud.subadmin1Edit',compact('cat'));
	}
	
	
	public function subadmin1postaddajax1()
	{
		$id			 = Request::get('id');
		$name     	 = Request::get('localname');
		$asciiname 	 = Request::get('asciiname');
		$active		 = Request::get('active');
		
		if($active == "on")
			$active1 = '1';
		else
			$active1 = '0';
		//echo $active1;die;
		\DB::table('subadmin1')->where('id',$id)
							->update(
			['name'=>$name,'asciiname' =>$asciiname,'active'=>$active1]
		);
			
			return Redirect::to('admin/subadmin1');
	}
	
	 
	 /* Subcategories Delete */
	
	
	public function subadmin1delete($tid)
	{
		
		if( $tid > 0 )
		{
			//$model = AdReviews::find($tid);
			\DB::table('subadmin1')->where('id', '=', $tid)->delete();
			//Session::flash('success','Review deleted successfully');
			return redirect()->back();
		}
		//return view('vendor.backpack.crud.review');	
	}
}
