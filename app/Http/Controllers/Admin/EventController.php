<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use App\Larapen\Models\Event;
use App\Larapen\Models\EventType;
use Larapen\CRUD\app\Http\Controllers\CrudController;
use App\Http\Requests\Admin\EventRequest as StoreRequest;
//use App\Http\Requests\Admin\EventRequest as UpdateRequest;

class EventController extends CrudController
{
	
	
    public $crud;
    
    public function __construct()
    {
        $this->crud = array(
        
        "model" => "App\Larapen\Models\Event",
        "entity_name" => "event",
        "entity_name_plural" => "events",
        "route" => "admin/event",
		"reorder" => false,
        "reorder_label" => "name",
        "reorder_max_level" => 2,
        "details_row" => false,
        "add_permission" => false,
		
        // *****
        // COLUMNS
        // *****
        "columns" => [
            [
                'name' => "id",
                'label' => "ID"
            ],
            [
                'name' => "event_name",
                'label' => "Event name",
            ],  
            [
                'name' => "event_type_id",
                'label' => "Type",
                'model' => "App\Larapen\Models\EventType",
                'entity' => "eventType",
                'attribute' => "name",
                'type' => "select",
            ],
            [
                'label' => "Country",
                'name' => "country_code",
                'model' => "App\Larapen\Models\Country",
                'entity' => "country",
                'attribute' => "asciiname",
                'type' => "select",
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
            [   // Info
				'name' => 'ticket_details',
				'label' => 'Event Ticket',
				'type' => 'event_ticket_info',
				'id'=>'ticket_type'
			],
            [
                'name' => "event_name",
                'label' => "Event Name",
                'type' => "text",
                'placeholder' => "Event Name",
            ],
            /*[
                'name' => "event_type_id",
                'label' => "Type",
                'model' => "App\Larapen\Models\EventType",
                'entity' => "eventType",
                'attribute' => "name",
                'type' => "select",
            ],*/
            [
                'id' => "event_type_id",
                'name' => "event_type_id",
                'label' => "Event Type",
                'type' => 'select_from_array',
                'options' => $this->event_types(),
                'allows_null' => false,
            ],
			[
                'name' => "event_topic",
                'label' => "Event Topic",
                'type' => "text",
                'placeholder' => "Event Topic",
            ],
            [
                'name' => "about_event",
                'label' => "About Event",
                'type' => "ckeditor",
                'placeholder' => "About the Event",
            ],
			/*[
				'id'	=>"country_code",
				'name' => "country_code",
                'label' => "Country",
               	'type' => 'select_from_array',
				'options' => $this->countries(),
				'allows_null' => false,
               
            ],*/
			[
				'id'	=>'location',
				'name' => 'subadmin1_code',
				'label' => 'Location',
				'type' => 'select_from_array',
				'options' => ['Location'],
				'allows_null' => false,
			],
			[
				'id'	=>'city',
				'name' => 'event_place',
				'label' => 'City',
				'type' => 'select_from_array',
				'options' => ['City'],
				'allows_null' => false,
				'requied' => '',
			],
			[
                'name' => "sub_location",
                'type' => "hidden",
				'value'=> ""
            ],
			[
                'name' => "has_children",
                'type' => "hidden",
				'value'=> ""
            ],
            [
                'name' => "event_image1",
                'label' => "Event Image 1",
				'type' => 'browse',
            ],
			/*[
                'name' => "event_image2",
                'label' => "Event Image 2",
				'type' => 'browse',
            ],
			[
                'name' => "event_image3",
                'label' => "Event Image 3",
				'type' => 'browse',
            ],*/ 
			[
                'name' => "event_date",
                'label' => "Event Start Date",
                'type' => "date",
            ],
			[
                'name' => "event_starttime",
                'label' => "Event Start Time",
                'type' => "time",
            ],
			[
                'name' => "eventEnd_date",
                'label' => "Event End Date",
                'type' => "date",
            ],
			[
                'name' => "event_endtime",
                'label' => "Event End Time",
                'type' => "time",
            ],
             
			[
				'name' => "organization",
				'label' => "Organizer Name",
				'type' => "text",
				'placeholder' => "Organizer Name",
			],
			[
                'name' => "org_description",
                'label' => "About Organizer",
                'type' => "ckeditor",
                'placeholder' => "About the Organizer",
            ],
			[   // Checkbox
				'name' => 'social_share',
				'label' => 'Allow Social Media Sharing',
				'type' => 'checkbox',
				'id'=> 'social_share'
			],
			[   // Checkbox
				'name' => 'link_to_social',
				'label' => 'Links to facebook and twitter',
				'type' => 'checkbox',
				'id'=>'link_to_social'
			],
			[
				'name' => "fb_link",
				'label' => "Fb link",
				'type' => "text",
				'id'=>'text_1',
			],
			[
				'name' => "twitter",
				'label' => "Twitter Link",	
				'type' => "text",
				'id'=>'text_2'
			],
            [   // Radio
				'name' => 'privacy',
				'label' => 'Listing Privacy',
				'type' => 'radio',
				'id'=>'privacy_new',
				'group'=>array(0 => array('id'=>'privacy_1', 'value'=>'0', 'style'=>'margin-left:0;', 'label'=>'<b>Public page:</b> list this events on a Eventbrite and search engines.'),
						1 => array('id'=>'privacy_2', 'value'=>'1', 'style'=>'margin-left:0;', 'label'=>'<b>Private page:</b> do not list this event plublicly'))
			],
			[
                'name' => 'active',
                'label' => "Active",
                'type' => 'checkbox',
            ],
			[
                'name' => "user_id",
                'label' => "User",
                'type' => "hidden",
            ],
        ],
    );
        //parent::__construct();
        
    }
    
    /*public function __construct()
    {
        $this->crud['fields'][2]['options'] = $this->event_types();
        
        parent::__construct();
    }*/
    
    public function store(StoreRequest $request)
    {
        return parent::storeCrud();
    }
    
    public function update(Request $request)
    {
        return parent::updateCrud();
    }
	
	
    public function event_types()
    {
        $entries = EventType::where('active', 1)->where('translation_lang', config('app.locale'))->get();
       
        if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        foreach ($entries as $entry) {
            $tab[$entry->translation_of] = $entry->name;
        }
        //echo "<pre>";print_r($tab);die;
        return $tab;
    }
    
   /* public function countries()
	{
		$entries = \DB::table('countries')->select('code','asciiname')->where('active',1)->get();
		
      	if (is_null($entries)) {
            return [];
        }
        
        $tab = [];
        $tab[0] = 'Country';
        foreach ($entries as $entry) {
            //if ($entry->id != $currentId){
                $tab[$entry->code] = '- ' . $entry->asciiname;
			//}
        }
        //echo "<pre>";print_r($tab);die;
        return $tab;
	}*/
}
