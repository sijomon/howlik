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

use App\Larapen\Models\Category;
use Illuminate\Support\Facades\Request;
use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\CategoryRequest as StoreRequest;
use App\Http\Requests\Admin\CategoryRequest as UpdateRequest;
use Illuminate\Support\Facades\Input;
use Redirect;
use Validator;
use Maatwebsite\Excel\Facades\Excel;

class SubCategoryController extends CrudController
{
	
    public $crud = array(
        "model" => "App\Larapen\Models\subCategory",
        "entity_name" => "Subcategory",
        "entity_name_plural" => "Subcategories",
        "route" => "admin/subcategory",
        "reorder" => true,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "details_row" => true,
        
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'id',
                'label' => "ID"
            ],
            [
                'name' => 'name',
                'label' => "SubCategory Name"
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
                'name' => 'name',
                'label' => 'Name',
                'type' => 'text',
                'placeholder' => 'Enter a name'
            ],
			 
            [
                'name' => 'slug',
                'label' => 'Slug (URL)',
                'type' => 'text',
                'placeholder' => 'Will be automatically generated from your name, if left empty.',
                'hint' => 'Will be automatically generated from your name, if left empty.',
            ],
            [
                'name' => 'description',
                'label' => 'Description',
                'type' => 'textarea',
                'placeholder' => 'Enter a description'
            ],
            [
                'name' => 'picture',
                'label' => 'Picture',
                'type' => 'browse'
            ],
            /*[
                'name' 			=> 'css_class',
                'label' 		=> 'CSS Class',
                'type' 			=> 'text',
                'placeholder' 	=> 'CSS Class'
            ],
           [
                'name' => 'type',
                'label' => 'Type',
                'type' => 'enum',
            ],*/
            [
                'name' => 'active',
                'label' => "Active",
                'type' => 'checkbox'
            ],
        ],
    );
    
    public function __construct()
    {
        if (Request::segment(3) == 'create') {
				//echo "hello";die;
		   $parentField = [
                'name' => 'subCat_id',
                'label' => 'SubCategory',
                'type' => 'select_from_array',
                //'options' => $this->categories(),
				'options' => $this->subcategories(),
                'allows_null' => false,
            ];
			
            array_unshift($this->crud['fields'], $parentField);
			
			
        }
        
       
        parent::__construct();
		
		//echo "hello";die;
    }
    
    public function store(StoreRequest $request)
    {
		
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    
	/* Index page listing the subcategories */
	
	public function viewlist()
	{
		$cat = \DB::table('subcategory2')
						->select('*')
						->where('translation_lang','=','en')
						->get();
		return view('vendor.backpack.crud.subcategoryList',compact('cat'));
	}
	
	/* Add the subcategory page */
	
	public function add1()
	{
		
		$cat = \DB::table('categories')
						->select('id','name')
						->where('parent_id',0)
						->get();
		$subcat = \DB::table('categories')
						->select('id','name')
						->where('parent_id','<>',0)
						->get();
		
		return view('vendor.backpack.crud.subcategory',compact('cat','subcat'));
	}
	
	/* Get the subcategories based on Categories */
	
	public function subcategorypost()
	{
		
		$id   = Request::get('id');//$In->input('id',0);
		
		//fetch subcategory 

	  $subcategory = \DB::table('categories')->where('parent_id',$id)->get();

	  $subcategory_drop = '<option value="">Select</option>';
	     if( count($subcategory) > 0 ){
		    foreach( $subcategory as $row )
		    {
			$subcategory_drop .= '<option value="'.$row->id.'">'.$row->name.'</option>';	
		    }
	    }
		
		echo json_encode(array( 'subcategory_drop' => $subcategory_drop ));
		exit;
	}
	
	public function subcategoryaddajax(Request $request)
	{
		$error     = '';
		$rules     = ['name' => 'required' ];
	    $file      = Request::all();
	    $validator = Validator::make($file,$rules);
	    if( $validator->fails())
	    {
			 return Redirect::to('admin/subcategoryadd')->withErrors($validator->errors());
		}
		else
		{
			$trans =    \DB::table('subcategory2')->max('id') + 1;
			//$tanslang = Request::get('lang');
			$category = Request::get('parent_id');
			$subcat   = Request::get('subcat');
			$name     = Request::get('name');
			$slug	  = Request::get('slug');
			$description = Request::get('description');
			$picture 	 = Request::get('picture');
			$active		 = Request::get('active');
			//echo $tanslang;die;
			\DB::table('subcategory2')->insert(
				['translation_lang'=>'en','translation_of'=>$trans,'cat_id' => $category, 'subCat_id' => $subcat,'name'=>$name,'slug' =>$name,'description'=>$description,'picture'=>$picture,'active'=>$active]
			);
			return Redirect::to('admin/subcategory');
		}
	}
	
	/* subcategories Edit */
	
	public function subcategoryEdit($id)
	{
		$cat = \DB::table('subcategory2')
						->select('*')
						->where('id',$id)
						->get();
		
		return view('vendor.backpack.crud.subcategoryEdit',compact('cat'));
	}
	
	public function subcategoryaddajax1()
	{
		$id			 = Request::get('id');
		$name     	 = Request::get('name');
		$slug	 	 = Request::get('slug');
		$description = Request::get('description');
		$picture 	 = Request::get('picture');
		$active		 = Request::get('active');
		//echo $id;die;
		\DB::table('subcategory2')->where('id',$id)
							->update(
			['name'=>$name,'slug' =>$name,'description'=>$description,'picture'=>$picture,'active'=>$active]
		);
		return Redirect::to('admin/subcategory');
	}
	
	/* Subcategories Detail view page */
	
	public function subcategorydetails($id)
	{
		
		/*$lang  = \DB::table('languages')->select('abbr','languages.name as langname')
						->join('subcategory2','subcategory2.translation_lang','<>','languages.abbr')
						->where('subcategory2.id',$id)
						
						->where('languages.active','=',1)
						->get();*/
		$lang 	= \DB::table('languages')->select('abbr','languages.name as langname')
							->where('languages.active','=',1)
							->get();
		$a = '';
		foreach($lang as &$lng){
			
			$a[] = $lng->abbr;
		}
		unset($lng);
		
		$subcat	= \DB::table('subcategory2')
							->select('subcategory2.id as subcat_id','subcategory2.name as subcat','subcategory2.active','languages.name','languages.abbr')
							->join('languages','subcategory2.translation_lang','=','languages.abbr')
							->where('subcategory2.id',$id)
							->orWhere('translation_of',$id)
							
							->get();
		$slang = 	\DB::table('subcategory2')->where('translation_of',$id)->pluck('translation_lang');				
		
		return view('vendor.backpack.crud.subcategoryDetails',compact('lang','subcat','slang','a'));
	}
	
	/* Subcategories  translattion Edit */
	
	public function subcategoryEditlang($lang,$id)
	{
		$cat = \DB::table('subcategory2')
						->select('subcategory2.cat_id','subcategory2.subCat_id')
						->where('id',$id)
						->get();
						//echo "<pre>";print_r($cat);die;
		return view('vendor.backpack.crud.subcatTranslate',compact('cat','lang','id'));
	}
	
	public function subcategoryaddajax1lang()
	{
		$id 		 = Request::get('id1');
		$tanslang	 = Request::get('lang');
		$category    = Request::get('category');
		$subcat		 = Request::get('subcategory');
		$name     	 = Request::get('name');
		$slug	 	 = Request::get('slug');
		$description = Request::get('description');
		$picture 	 = Request::get('picture');
		$active		 = Request::get('active');
		//echo $id;die;
		\DB::table('subcategory2')->insert(
			['translation_lang'=>$tanslang,'translation_of'=>$id,'cat_id' => $category, 'subCat_id' => $subcat,'name'=>$name,'slug' =>$name,'description'=>$description,'picture'=>$picture,'active'=>$active]
		);
		return Redirect::to('admin/subcategory');
	}
	
	public function upload_csv1(Request $request)
	{
		
		$error     = '';
		$rules     = ['Upload_file' => 'required|mimes:csv,xls,xlsx,xl,xla,txt' ];
	    $file      = Request::all();
	    $validator = Validator::make(Request::all() ,$rules);
	    if( $validator->fails() )
	    {
			//echo "<pre>";print_r($file);die;
			//echo "inside validator";die;
			return redirect()->route('subcategory')->withErrors($validator->errors());
		}
		else{
			if( $error =="")
			{
		if(Input::hasFile('Upload_file')){
			$file = Input::file('Upload_file');
			$name = date("Y-m-d") . '-' . $file->getClientOriginalName();
			
			// Moves file to folder on server
			$path = $file->move(public_path() . '/uploads/CSV', $name);
			$data = Excel::load($path, function($reader) {
			})->get();
			//$trans =    \DB::table('subcategory2')->max('id') + 1;
			if(!empty($data) && $data->count()){
				foreach ($data as $key => $value) {
					
					$ids = Category::select('id')->where('name',$value['category'])
											->where('parent_id',0)
											->where('translation_lang','en')
											->get();
					$a = '';
					foreach($ids as &$lng){
						
						$a[] = $lng->id;
					}
					unset($lng);
					if(empty($a))
					{
						$a[] = 0;
					}
					$subCat_id 	= Category::select('id')->where('name',$value['subcategory'])
										->where('translation_lang','en')
										->get();	
					$b = [];
					if($subCat_id):
					
						foreach($subCat_id as &$subcat){
							
								$b[] = $subcat->id;
												
						}
					endif;
					unset($subcat);
					if(empty($b))
					{
						$b[] = 0;
					}
				//	echo "<pre>";print_r($b);
					
					$pic = 'uploads/app/categories/default/'.$value['picture'];	
					$insert = ['translation_lang'=>'en','cat_id' =>$a[0], 'subCat_id' => $b[0],'name' => $value->name,'slug' =>$value->name,'description' => $value->description,'picture'=>$pic,'active'=>1];
					
					$id = \DB::table('subcategory2')->insertGetId($insert);
					\DB::table('subcategory2')->where('id',$id)->update(['translation_of' => $id]);
								//echo $last_id;die;
				}
				
					return Redirect::to('admin/subcategory');
				
			}
		}
		}
		}
	}
	
	/* Subcategories Delete */
	
	public function subcategorydelete($tid)
	{
		
		if( $tid > 0 )
		{
			//$model = AdReviews::find($tid);
			\DB::table('subcategory2')->where('id', '=', $tid)->delete();
			//Session::flash('success','Review deleted successfully');
			return redirect()->back();
		}
		//return view('vendor.backpack.crud.review');	
	}
	
    public function categories()
    {
		
        $currentId = 0;
		//echo "<pre>";print_r(Request::segment(1));die;
        if (Request::segment(4) == 'edit' and is_numeric(Request::segment(3))) {
            $currentId = Request::segment(3);
        }
        
       
	   $entries = Category::where('translation_lang', config('app.locale'))->where('parent_id',0)->orderBy('lft')->get();
      	if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        $tab[0] = 'Root';
        foreach ($entries as $entry) {
            if ($entry->id != $currentId) {
                $tab[$entry->translation_of] = '- ' . $entry->name;
			 }
        }
       // echo "<pre>";print_r($tab);die;
        return $tab;
    }
	
	/* -------------- */
    public function subcategories()
    {
        $currentId = 0;
		//echo "<pre>";print_r(Request::segment(1));die;
        if (Request::segment(4) == 'edit' and is_numeric(Request::segment(3))) {
            $currentId = Request::segment(3);
        }
        
        $entries = Category::where('translation_lang', config('app.locale'))->where('parent_id','!=' ,0)->orderBy('lft')->get();
       //echo "<pre>";print_r($entries);die;
		if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        $tab[0] = 'Root';
        foreach ($entries as $entry) {
            if ($entry->id != $currentId) {
                $tab[$entry->translation_of] = '- ' . $entry->name;
            }
        }
       // echo "<pre>";print_r($tab);die;
        return $tab;
    }
}
