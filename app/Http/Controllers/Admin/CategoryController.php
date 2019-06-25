<?php
namespace App\Http\Controllers\Admin;

use App\Larapen\Models\Category;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\CategoryRequest as StoreRequest;
use App\Http\Requests\Admin\CategoryRequest as UpdateRequest;
use Redirect;
use Validator;

class CategoryController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\Category",
        "entity_name" => "category & keyword",
        "entity_name_plural" => "categories & keywords",
        "route" => "admin/category",
        "reorder" => false,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "details_row" => true,
		"csv"     =>true, 
        
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
                'label' => "Category/Keyword Name"
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
                'placeholder' => 'Will be automatically generated from your name, if left empty.(Enter in English)',
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
            ],*/
            /*[
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
            $parentField = [
                'name' => 'parent_id',
                'label' => 'Parent',
                'type' => 'select_from_array',
                'options' => $this->categories(),
                'allows_null' => false,
            ];
            array_unshift($this->crud['fields'], $parentField);
        }
        
        
        parent::__construct();
    }
    
    public function store(StoreRequest $request)
    {
        $response = parent::storeCrud($request);
		//BOF code to insert value in translation_of for default language [Vin]
		if(isset($this->crud['item'])){
			$item = $this->crud['item'];
			if(isset($item->translation_lang) && $item->translation_lang=='en'){
				$item->translation_of = $item->id;
				$item->save();
			}
		}
		//EOF code to insert value in translation_of for default language [Vin]
		return $response;
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
    
    public function categories()
    {
        $currentId = 0;
        if (Request::segment(4) == 'edit' and is_numeric(Request::segment(3))) {
            $currentId = Request::segment(3);
        }
        
        $entries = Category::where('translation_lang', config('app.locale'))->where('parent_id', 0)->orderBy('lft')->get();
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
        
        return $tab;
    }
	
	public function upload_category_csv()
	{
		
		$error     = '';
		$rules     = ['Upload_file' => 'required|mimes:csv,xls,xlsx,xl,txt' ];
	    $file      = Request::all();
	    $validator = Validator::make($file,$rules);
	    if( $validator->fails())
	    {
			 return Redirect::to('admin/category')->withErrors($validator->errors());
		}
		else
		{
			if( $error =="")
			{
				if(Input::hasFile('Upload_file')){
					
					$file = Input::file('Upload_file');
					$name = date("Y-m-d") . '-' . $file->getClientOriginalName();
					// Moves file to folder on server
										
					$path = $file->move(public_path() . '/uploads/CSV', $name);
					$data = Excel::load($path, function($reader) {
					})->get();
					
					if(!empty($data) && $data->count()){
						foreach ($data as $key => $value) {
							$parentId = 0;
							$parent	=	trim($value['parent']);
							if($parent!=''){
								$p = Category::select('id')->where('name',$parent)->where('translation_lang', 'en')->first();
								//print_r($p);
								if(isset($p->id)){
									$parentId = $p->id;
								}else{
									$parentId = -1; //The parent doesn't exists in database, we can't insert an entry into database in this case.
								}
							}
							
							$type = '';
							$depth = 2;
							if($parentId>=0){
								$name			=	trim($value['name']);
								$name_ar		=	trim($value['name_ar']);
								$slug			=	strtolower(str_replace(' ', '-',$name));
								$description	=	trim($value['description']);
								$description_ar	=	trim($value['description_ar']);
								$picture		=	'uploads/app/categories/default/'.trim($value['image']);
								$active			=	trim($value['active']);
								if($parentId==0){
									$type 		= 'classified';
									$depth 		= 1;
								}

								$cat = Category::firstOrCreate(array('translation_lang' => 'en', 'parent_id' => $parentId, 'name' => $name));
								
								$catId = $cat->id;
								$cat->translation_of = $catId;
								$cat->slug = $slug;
								$cat->description = $description;
								$cat->picture = $picture;
								$cat->type = $type;
								$cat->depth = $depth;
								$cat->active = $active;
								$cat->save();
								
								$cat_ar = Category::firstOrCreate(array('translation_lang' => 'ar', 'translation_of' => $catId));
								
								$cat_ar->parent_id = $parentId;
								$cat_ar->name = $name_ar;
								$cat_ar->slug = $slug;
								$cat_ar->description = $description_ar;
								$cat_ar->picture = $picture;
								$cat_ar->type = $type;
								$cat_ar->depth = $depth;
								$cat_ar->active = $active;
								$cat_ar->save();
							}
						}
						return Redirect::to('admin/category');
					}
				}
			}
		}
	}
}
