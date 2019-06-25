<?php
namespace App\Http\Controllers\Admin;

use App\Larapen\Models\BusinessImage;
use App\Larapen\Models\BusinessImageRequest;

use Larapen\CRUD\app\Http\Controllers\CrudController;
// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\Admin\BusinessImageRequest as StoreRequest;
use App\Http\Requests\Admin\BusinessImageRequest as UpdateRequest;
use Request;
use Illuminate\Support\Facades\File;

class BusinessImageRequestController extends CrudController
{
    public $crud = array(
        "model" => "App\Larapen\Models\BusinessImageRequest",
        "entity_name" => "business image request",
        "entity_name_plural" => "business image requests",
        "route" => "admin/business-image-request",
        "reorder" => false,
        "edit_permission" => false,
		"delete_permission" => false,
		"add_permission" => false,
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => 'biz_images',
                'label' => "Business Images",
                'type' => 'image_approval',
            ],
        ],
        
        // ***** 
        // SPECIALS
        // *****
        "special" => ['type' => 'image_approval'],
		
        // *****
        // FIELDS ALTERNATIVE
        // *****
        "fields" => [
            [
                'name' => 'biz_hours',
                'label' => "Biz Hours",
                'type' => 'image_approval',
            ],
        ],
    );
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(UpdateRequest $request)
    {
        return parent::updateCrud();
    }
	
	public function imgaction()
	{
		$id   	= Request::get('id');
		$status = Request::get('status');
		
        $entries = BusinessImageRequest::where('id', $id)->first();
		if(!empty($entries)){
			if($status==1){
				$filename = '';
				$dest_path = public_path() . '/uploads/pictures/';
				$picture_path = public_path() . '/uploads/pictures/';
                if (File::exists($picture_path . $entries->filename)) {
					$ext = pathinfo($picture_path . $entries->filename, PATHINFO_EXTENSION);
					$filename = rand(10,99).time().'.'.$ext;
                    File::copy($picture_path . $entries->filename, $dest_path . $filename);
                } else {
                    $picture_path = public_path() . '/';
                    if (File::exists($picture_path . $entries->filename)) {
						$ext = pathinfo($picture_path . $entries->filename, PATHINFO_EXTENSION);
						$filename = rand(10,99).time().'.'.$ext;
                        File::copy($picture_path . $entries->filename, $dest_path . $filename);
                    }
                }
				if($filename!=''){
					$businessImage = new BusinessImage();
					$businessImage->biz_id 	  	= $entries->biz_id;
					$businessImage->filename  	= 'uploads/pictures/'.$filename;
					$businessImage->posted_by 	= $entries->posted_by;
					$businessImage->active 	  	= $entries->active;
					$businessImage->created_at 	= $entries->created_at;
					$businessImage->save();
				}
			}
			$entries->delete();
		}
		echo json_encode (array( 'res' => $entries ));
	}
}