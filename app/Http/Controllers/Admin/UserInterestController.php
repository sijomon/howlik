<?php

	namespace App\Http\Controllers\Admin;

	use Larapen\CRUD\app\Http\Controllers\CrudController;
	// VALIDATION: change the requests to match your own file names if you need form validation
	use App\Http\Requests\Admin\UserInterestRequest as StoreRequest;
	use App\Http\Requests\Admin\UserInterestRequest as UpdateRequest;


	class UserInterestController extends CrudController
	{
		
		public $crud = array(
		
			"model" => "App\Larapen\Models\UserInterest",
			"entity_name" => "Interest",
			"entity_name_plural" => "Interests",
			"route" => "admin/user-interest",
			"reorder" => false,
			"details_row" => true,
			
			// *******
			// COLUMNS
			// *******
			
			"columns" => [
				[
					'name' => 'id',
					'label' => "ID"
				],
				[
					'name' => 'int_title',
					'label' => "Title",
				],
				[
					'name' => 'active',
					'label' => "Active",
					'type' => "model_function",
					'function_name' => 'getActiveHtml',
				],
			],
			
			
			// ******
			// FIELDS
			// ******
			"fields" => [
				[
					'name' => 'int_title',
					'label' => 'Title',
					'type' => 'text',
					'placeholder' => 'Title',
				],
				[
					'name' => 'int_img',
					'label' => 'Icon',
					'type' => 'browse'
				],
				[
					'name' => 'active',
					'label' => "Active",
					'type' => 'checkbox'
				],
			],
		);
		
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
			
			return parent::updateCrud($request);
		}
	}
