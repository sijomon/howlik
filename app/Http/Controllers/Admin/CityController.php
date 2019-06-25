<?php
namespace App\Http\Controllers\Admin;

use App\Larapen\Models\City;
use Larapen\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\CityRequest as StoreRequest;
use App\Http\Requests\Admin\CityRequest as UpdateRequest;
use Request;

class CityController extends CrudController
{
    public $curd;
	
	 public function __construct()
    {
		$this->crud = array(
        "model" => "App\Larapen\Models\City",
        "entity_name" => "city",	
        "entity_name_plural" => "cities",
        "route" => "admin/city",
        "reorder" => false,
		"limit" =>10,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'country_code',
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
				'type' => "model_function",
                'function_name' => 'getActiveHtml',
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
				'id'	=>'subadmin1',
				'name' => 'subadmin1_code',
				'label' => 'Location',
				'type' => 'select_from_array',
				'options' => ['Location'],
				'allows_null' => false,
			],
			/*[	'id'	=>'subadmin2',
				'name' => 'subadmin2',
				'label' => 'Sub Location',
				'type' => 'select_from_array',
				'options' => ['Sub Location'],
				'allows_null' => false,
			],*/
            [
                'name' => 'name',
                'label' => 'Name (Arabic)',
                'type' => 'text',
                'placeholder' => 'Enter the City name (In Arabic)'
            ],
            [
                'name' => 'asciiname',
                'label' => "Name",
                'type' => 'text',
                'placeholder' => 'Enter the City name (In English)'
            ],
            /*[
				'name' => 'time_zone',
				'label' => 'Time_zone',
				'type' => 'select_from_array',
				'options' => $this->time_zone(),
				//'oncahange' =>'select_bl(this->value)',
				'allows_null' => false,
			],*/
			[
                'name' => 'latitude',
                'label' => "Latitude",
                'type' => 'text',
                'placeholder' => 'Enter the Latitude code'
            ],
			[
                'name' => 'longitude',
                'label' => "Longitude",
                'type' => 'text',
                'placeholder' => 'Enter the Longitude code'
            ],
            [
                'name' => 'active',
                'label' => "Active",
                'type' => 'checkbox',
				'value' => '1',
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
	
	public function time_zone()
	{
		$entries 	= \DB::table('time_zones')->select('time_zone_id')->get();
		if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        $tab[0] = 'Time Zone';
        foreach ($entries as $entry) {
          
                $tab[$entry->time_zone_id] = '- ' . $entry->time_zone_id;
			
        }
      
        return $tab;
	}
	
	public function country_code()
	{
		$code   = Request::get('code');
		
		 $subadmin = \DB::table('subadmin1')->where('code','like', $code.'.%')->get();
		 
	  $subadmin_drop = '<option value="">Location</option>';
	  
	     if( count($subadmin) > 0 ){
		    foreach( $subadmin as $row )
		    {
				$loc = explode('.', $row->code);
				$subadmin_drop .= '<option value="'.$loc[1].'">'.$row->asciiname.'</option>';	
		    }
	    }
		
		echo json_encode (array( 'subadmin_drop' => $subadmin_drop ));
	}
	
	public function locationpost()
	{
		$subadmin1_code   = Request::get('subadmin1_code');//$In->input('id',0);
		
		//fetch subcategory 
	
	   $subadmin2 = \DB::table('subadmin2')->where('code','like', $subadmin1_code.'.%')->get();
		 
	  $subadmin2_drop = '<option value="">Sub location</option>';
	  
	     if( count($subadmin2) > 0 ){
		    foreach( $subadmin2 as $row )
		    {
				$subloc = 	explode('.',$row->code);
				$subadmin2_drop .= '<option value="'.$subloc[2].'">'.$row->asciiname.'</option>';	
		    }
	    }
		echo json_encode(array( 'subadmin2_drop' => $subadmin2_drop ));
		exit;
	}
	
	public function get_city_ajax(){ 
		$srch	=	'';
		if(Request::has('srch')){
			$srch = trim(Request::get('srch'));
		}
		if($srch != ''){
			$city	=	City::where('name','LIKE',$srch.'%')->orWhere('name','LIKE','%'.$srch)->orWhere('name','LIKE','%'.$srch.'%')
									  ->orwhere('asciiname','LIKE',$srch.'%')->orWhere('asciiname','LIKE','%'.$srch)->orWhere('asciiname','LIKE','%'.$srch.'%')->paginate($this->crud['limit']);
		}else{
			$city	=	City::paginate($this->crud['limit']);
		}
		$tableRow = ''.$srch;
		foreach ($city as $k => $entry){
			$tableRow .= '<tr data-entry-id="'.$entry->id.'">';
			$tableRow .= '<td>'.$entry->country_code.'</td>';
			$tableRow .= '<td>'.$entry->name.'</td>';
			$tableRow .= '<td>'.$entry->asciiname.'</td>';
			$tableRow .= '<td>'.$entry->getActiveHtml().'</td>';
			$tableRow .= '<td>';
			$tableRow .= '<a href="'.url('admin/city/'.$entry->id.'/edit').'" class="btn btn-xs btn-default"><i class="fa fa-edit"></i> Edit</a>';
			$tableRow .= '<a href="'.url('admin/city/'.$entry->id).'" class="btn btn-xs btn-default" data-button-type="delete"><i class="fa fa-trash"></i> Delete</a>';
			$tableRow .= '</td>';
			$tableRow .= '</tr>';
		}
		$pageLinks = (string)$city->links();
		$pageLinks = str_replace('_ajax?page', '?page', $pageLinks);
		$replyA['data'] = $tableRow;
		$replyA['paging'] = $pageLinks;
		return json_encode($replyA);
	}
}
