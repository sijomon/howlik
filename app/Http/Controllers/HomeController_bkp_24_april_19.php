<?php
namespace App\Http\Controllers;
use DB;
//use Request;
use Illuminate\Support\Facades\Request as Request;
use App\Larapen\Events\EventWasVisited;
//use App\Larapen\Events\SendMessageToFriend;
use App\Larapen\Events\SendMessage;
use App\Larapen\Events\SendInvitaion;
//use App\Larapen\Helpers\Arr;
//use App\Larapen\Models\Ad;
use App\Larapen\Models\Eventnew;
use App\Larapen\Models\EventType;
//use App\Larapen\Models\EventTopic;
use App\Larapen\Models\EventTicket;
use App\Larapen\Helpers\Rules;
use App\Larapen\Models\Category;
//use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\City;
//use App\Larapen\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Torann\LaravelMetaTags\Facades\MetaTag;
//use App\Larapen\Helpers\Ip;

use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;

use MyFuncs;

//use App\oauth_helper.php;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Event as MainEvent;
use Input;
use Validator;
use File;
use Response;
use Carbon;
use fire;
use Auth;

class HomeController extends FrontController
{

    public function index(HttpRequest $request){
        $data = array();
        
		if($this->lang->get('abbr')=='ar'){
			$langName = 'name';
		}else{
			$langName = 'asciiname';
		}
        // Get Categories
        $cats = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->orderBy('lft')->get();
        $data['cats'] = collect($cats)->keyBy('id');
        
        // SEO
        if (config('settings.app_slogan')) {
            $title = config('settings.app_slogan');
        } else {
            $title = t('Free local classified ads in :location', ['location' => $this->country->get('name')]);
        }
        $description = str_limit(str_strip(t('Sell and Buy products and services on :app_name in Minutes',
                ['app_name' => mb_ucfirst(config('settings.app_name'))]) . ' ' . $this->country->get('name') . '. ' . t('Free ads in :location',
                ['location' => $this->country->get('name')]) . '. ' . t('Looking for a product or service') . ' - ' . $this->country->get('name')),
            200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        
        // Open Graph
        $this->og->title($title)->description($description);
        View::share('og', $this->og);
        
		$gotoweb = false;
		if($request->session()->has('set_goto_web') && $request->session()->get('set_goto_web')=='gotoweb') {
			//$request->session()->forget('set_goto_web');
			$gotoweb = true;
		}
		$data['gotoweb'] = $gotoweb;
		
		return view('classified.home.welcome', $data);
    }
	
	public function setGotoweb(HttpRequest $request){
		$request->session()->put('set_goto_web', 'gotoweb');
		//return Response::json(array('status'=>'success'));
		return json_encode(array('status'=>'success'));
	}
	
	public function maintenance()
    {
		return view('classified.home.maintenance');
	}
	
	public function events(HttpRequest $request)
	{
        $data = array();
        
        $timezone 	= Carbon\Carbon::now($this->country->get('timezone')->time_zone_id);
        
        $date 		= date('Y-m-d G:i:s',strtotime($timezone));
        
		//BOF All upcoming events
			
										
			$all_events		=	DB::table('events')
								->select('events.*', 'cities.name as cname', 'cities.asciiname')
								->leftjoin('cities', 'events.event_place', '=', 'cities.id')
								->where('events.country_code', $this->country->get('code'))
								->where(DB::raw("CONCAT(`event_date`, ' ', `event_starttime`)"), '>=', $date)
								->where('events.privacy', 0)
								->orderBy('event_date', 'ASC')
								->paginate(9);
								
			$data['all_events'] = $all_events;	
		//EOF All upcoming events
		
		//BOF popular events
			$pop_events		 = 	DB::table('events')
								->select('events.*', 'cities.name as cname', 'cities.asciiname')
								->leftjoin('cities', 'events.event_place', '=', 'cities.id')
								->where('events.country_code', '=', $this->country->get('code'))
								->where('events.privacy', 0)
								->orderBy('visits', 'DESC')
								->paginate(9);
								
			$data['pop_events'] = $pop_events;
		//EOF popular events
		
		$data['event_type']		= EventType::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->get();
		//$data['event_topic']	= EventTopic::where('active', 1)->get();
		
       // Meta Tags
        $title       = "Events";
		$description = "Events";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		
		$data['countriess'] 	= Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'))->lists('name', 'code');
		
		$data['hdr_ckeditor'] = 1;
		$data['hdr_dropzone'] = 1;
		$data['hdr_datetimepicker'] = 1;
		
		if ($request->ajax()) {
			if($request->has('up')) {
				return view('classified.home.inc.upcome_event', compact('all_events'));
			} else if($request->has('pop')) {
				return view('classified.home.inc.popular_event', compact('pop_events'));
			}
        }
		return view('classified.home.events', $data);
    }
    
	public function offers(){
		$data = array();
		$all_offers = DB::table('offer')
			->leftjoin('cities','offer.offer_location', '=', 'cities.id')
			->select('offer.*','cities.name as city_name')
			->where('offer.country_code', '=', $this->country->get('code'))
			->orderBy('created_at', 'desc')
			->get();
		
		$data['all_offers'] = $all_offers;	
		// Meta Tags
		$title       = "Offers";
		$description = "Offers";
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		$data['hdr_ckeditor'] = 1;
		$data['hdr_datepicker'] = 1;
		$data['hdr_dropzone'] = 1;
		return view('classified.home.offer', $data);
	}
	
	public function offerlist(){
		$offer_id = Request::segment(3);
		
		$data = array();
		$all_offers = DB::table('offer')->select('*')->where("id", $offer_id)->where('country_code', $this->country->get('code'))->where('active', '1')->first();
		
		if (!(is_numeric($offer_id) && isset($all_offers->id))) {
            abort(404);
        }
		
		$data['offers'] = $all_offers;	
		
		// Meta Tags
		$title       = "Offers";
		$description = "Offers";
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		return view('classified.home.offerlist', $data);
	}
	/*
	 * Event Listing
	 */
	 public function eventlist(){
		 
		$event_id = Request::segment(3);
		
        $data  = array();
		$event = DB::table('events')->select('events.*')->where("id", $event_id)->where('country_code', $this->country->get('code'))->first();
		if (!(is_numeric($event_id) && isset($event->id))) {
            abort(404);
        }
		
		$event_types = DB::table("event_type")->select('name')->where("id", $event->event_type_id)->first();
		$event->event_type_name = $event_types->name;
		$country_names = DB::table('countries')->select('name')->where('code', $event->country_code)->first();	
		$event->country_name = $country_names->name; 
			
		$all_events = DB::table('events')->select('events.*')->orderBy('event_date', 'asc')->where('event_date', '>=', date('Y-m-d'))->where('id', '!=', $event->id)->where('country_code', $this->country->get('code'))->get();
		
		$data['events'] = $event;
		$data['all_events'] = $all_events;
        $title       = "Events";
		$description = "Events";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        
		return view('classified.home.eventlist', $data);
    }
	
	public function event_picture(Request $request){
		
		$input = Input::all();
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
			return Response::make($validation->errors->first(), 400);
		}
		$file = Input::file('file');
				
		$destinationPath = public_path().'/uploads/pictures/events'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		
        if( $upload_success ) {
        	return Response::json( $fileName, 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	
	public function postevent(HttpRequest $request)
	{
		//echo '<pre>';print_r($_POST);die;
		$visible_co	=	'';
		$visible_to	=	'';
		/* Form validation */
		$validator = Validator::make($request->all(), Rules::Event($request), Rules::EventMsg($request));
		
		if ($validator->fails()) {

			return back()->withErrors($validator)->withInput();
		}
		
		$locations 		= City::select('subadmin1_code')->where('id', $request->input('event_location'))->first();

		$country_code	= $this->country->get('code');
		$event_name		= $request->input('event_title');
		$subadmin1		= $this->country->get('code').'.'.$locations->subadmin1_code;
		$location		= $request->input('event_location');
		$startDate		= date("Y-m-d", strtotime($request->input('startDate')));
		$startTime		= date('G:i:s', strtotime($request->input('startDate')));
		$endDate		= date("Y-m-d", strtotime($request->input('endDate')));
		$endTime		= date('G:i:s', strtotime($request->input('endDate')));
		$file			= $request->input('imge1');
		$about_event 	= $request->input('event_description');
		/* $org_name		= $request->input('organization_name'); */
		$about_org		= $request->input('messageArea1');
		$privacy		= $request->input('privacy');
		if($privacy > 0) {
			$visible_dt	= $request->input('visible_to');
			$visible_ar	= array_filter(explode(',',$visible_dt));
			
			if(count($visible_ar) > 0) {
				$visible_co	= getRandWord(8);
				$link		= url($this->lang->get('abbr')."/preview/private/".$visible_co);
				$count		= count($visible_ar);
				for($i=0;$i < $count;$i++) {
					Mail::send('emails.event.eventapproval', ['link' => $link,'title' => $event_name,'email' => $visible_ar[$i],'code' => $visible_co], function($message) use ($link,$visible_co,$visible_ar,$event_name,$i) {
				
						$message->to($visible_ar[$i]);
						$message->subject('Howlik Event Code is Here!');		
					});
				}
			}
			$visible_to	= serialize($visible_ar);
		}
		$event_type 	= $request->input('event_type_id');
		/* $topic			= $request->input('event_topic'); */
		$ticket_type	= $request->input('ticket_type');
		$social_share	= (int)$request->input('social_share');
		$social_link	= (int)$request->input('social_links');
		$latitude		= $request->input('lat1');
		$longitude		= $request->input('lon1');
		$ticket_details	= array();

		if($ticket_type == 1) {

			$ticket_details = array('tickets'=>$request->input('free_tickets'));
		}
		elseif($ticket_type == 2) {

			$ticket_details = array('tickets'=>$request->input('paid_tickets'), 'price'=>$request->input('ticket_price'), 'currency'=>$request->input('ticket_price'));
		}

		if(auth()->user()) {

			$usr_id = auth()->user()->id;
			$mytime = Carbon\Carbon::now();
		}
		else {
		
			$usr_id = 0;
			$mytime = Carbon\Carbon::now();
		}

		\DB::table('events')->insert (

			['user_id' => $usr_id,
			'country_code' =>$country_code,
			'event_type_id' => $event_type,
			'event_name' => $event_name,
			'event_date' => $startDate,
			'event_starttime' => $startTime,
			'eventEnd_date'=> $endDate,
			'event_endtime' => $endTime,
			'subadmin1_code' => $subadmin1,
			'event_place' => $location,
			'about_event' => $about_event,
			'event_image1'=> $file,
			'org_description' => $about_org,
			'privacy' => $privacy,
			'social_share' => $social_share,
			'link_to_social' => $social_link,
			'ticket_type' => $ticket_type,
			'ticket_details' => serialize($ticket_details),
			'visible_to' => $visible_to,
			'visible_code' => $visible_co,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'created_at' => $mytime,
			'updated_at' => $mytime]
		);

		//return redirect('/events');
		flash()->success(t('Your Event Created Successfully.'));
		return redirect('/events')->with(['success' => 1]);

	}
	
	/* events preview */
	public function event_preview(Request $request) {
		
		$event_id	=	Request::segment(4);
		$data		=	array();
		
		$event		=	DB::table('events')->where('id', $event_id)->where('country_code', $this->country->get('code'))->first();
			
		if(Auth::user() && !is_null($event) && $event->privacy == '1') {
			
			$user_id	=	$this->user->id;
			if(is_null($event) || $event->user_id != $user_id ) {
				
				abort(404);
			}	
			
		} elseif(is_null($event) || $event->privacy == '1') {
				
			abort(404);
		}	
		
		$tickets	=	DB::table('event_tickets')->select('event_tickets.ticket_quantity')->where('event_id', $event_id)->get();	
		//count the quantity from event_tickets table 
		$total	=	'';
		if(!empty($tickets)) {
			
			foreach($tickets as $value) { 
				
				foreach($value as $value1) {
					
					$total += $value1;
				}
			}
		}
		if($total != '') {
			
			$event->decrement	=	$total;
		}
		
		$countries	=	$this->country->get('currency');
		if($countries != '') {
			
			$event->currency = $countries->html_entity;
		}	
			
		$event_types 			=	DB::table('event_type')->select('name')->where('id', $event->event_type_id)->first();
		if($event_types != '') {
			
			$event->event_type_name =	$event_types->name;
		}
		
		$country_names 			=	DB::table('countries')->select('asciiname')->where('code', $event->country_code)->first();	
		if($country_names != '') {
			
			$event->country_name	=	$country_names->asciiname; 
		}
		
		$location_names 		=	DB::table('subadmin1')->select('asciiname')->where('code', $event->subadmin1_code)->first();	
		if($location_names != '') {
			
			$event->location_name	=	$location_names->asciiname; 
		}
		
		$city_names 			=	DB::table('cities')->select('asciiname')->where('id', $event->event_place)->first();	
		if($city_names != '') {
				
			$event->city_name		=	$city_names->asciiname; 
		}
		
		$timezone 	= Carbon\Carbon::now($this->country->get('timezone')->time_zone_id);
        $date 		= date('Y-m-d G:i:s',strtotime($timezone));
        
		$eventExipry	=	DB::table('events')->where('id', $event_id)->where(DB::raw("CONCAT(`event_date`, ' ', `event_starttime`)"), '>=', $date)->first();
		
		if(count($eventExipry) > 0) {
			
			View::share('expiry', $eventExipry);
		}	
				
		$events = 	Eventnew::where('id', $event_id)->first();
		// Increment Business visits counter
		if(!empty($events) ){
			MainEvent::fire(new EventWasVisited($events));
		}
		
		View::share('event', $event);
		$data['timezone'] = $timezone;
		
        $title       	= "Events Preview";
		$description 	= "Events Preview";
		
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        
        //echo '<pre>';print_r($event);die;
		View::share('hdr_socialsharejs', 1);
        
		return view('classified.home.event-preview', $data);
	}
	
	/* private events preview */
	public function private_preview(Request $request) {
		
		$event_code	 =	Request::segment(4);
													
		$data		=	array();
		$event		=	DB::table('events')->where('visible_code', $event_code)->where('country_code', $this->country->get('code'))->first();
		if(!isset($event)) {
            abort(404);
        }
		
		$tickets	=	DB::table('event_tickets')->select('event_tickets.ticket_quantity')->where('event_id', $event->id)->get();	
		//count the quantity from event_tickets table 
		$total	=	'';
		if(!empty($tickets)) {
			
			foreach($tickets as $value) { 
				
				foreach($value as $value1) {
					
					$total += $value1;
				}
			}
		}
		if($total != '') {
			
			$event->decrement	=	$total;
		}
		
		$countries	=	$this->country->get('currency');
		if($countries != '') {
			
			$event->currency = $countries->html_entity;
		}	
			
		$event_types 			=	DB::table('event_type')->select('name')->where('id', $event->event_type_id)->first();
		if($event_types != '') {
			
			$event->event_type_name =	$event_types->name;
		}
		
		$country_names 			=	DB::table('countries')->select('asciiname')->where('code', $event->country_code)->first();	
		if($country_names != '') {
			
			$event->country_name	=	$country_names->asciiname; 
		}
		
		$location_names 		=	DB::table('subadmin1')->select('asciiname')->where('code', $event->subadmin1_code)->first();	
		if($location_names != '') {
			
			$event->location_name	=	$location_names->asciiname; 
		}
		
		$city_names 			=	DB::table('cities')->select('asciiname')->where('id', $event->event_place)->first();	
		if($city_names != '') {
				
			$event->city_name		=	$city_names->asciiname; 
		}
		
		$timezone 	= Carbon\Carbon::now($this->country->get('timezone')->time_zone_id);
        $date 		= date('Y-m-d G:i:s',strtotime($timezone));
        
		$eventExipry	=	DB::table('events')->where('id', $event->id)->where(DB::raw("CONCAT(`event_date`, ' ', `event_starttime`)"), '>=', $date)->first();
		
		if(count($eventExipry) > 0) {
			
			View::share('expiry', $eventExipry);
		}	
		
		$events = 	Eventnew::where('id', $event->id)->first();
		
		// Increment Business visits counter
		if(!empty($events) ){
			MainEvent::fire(new EventWasVisited($events));
		}
		
		View::share('event', $event);
		$data['timezone'] = $timezone;
		
        $title       	= "Events Preview";
		$description 	= "Events Preview";
		
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        
        //echo '<pre>';print_r($event);die;
        
		return view('classified.home.event-preview', $data);
	}
	
	/* event ticket buy */ 
	public function buy_ticket(Request $request)
	{
		$event_id	 =	Request::segment(4);
		
		$data		 =	array();
		
		$event		 =	DB::table('events')->where('id', $event_id)->where('country_code', $this->country->get('code'))->first();
		if (!(is_numeric($event_id) && isset($event->id))) {
            abort(404);
        }
		
		$tickets		 =	DB::table('event_tickets')->select('event_tickets.ticket_quantity')->where('event_id', $event_id)->get();
		
		//count the quantity from event_tickets table 
		$total	=	'';
		if(!empty($tickets)) {
			
			foreach($tickets as $value) { 
				
				foreach($value as $value1) {
					
					$total += $value1;
				}
			}
		}
		if($total != '') {
			
			$event->decrement	=	$total;
		}
		
		$countries	=	$this->country->get('currency');
		if($countries != '') {
			
			$event->currency = $countries->html_entity;
		}
		View::share('event', $event);
		
        $title       	= "Events Purchase";
		$description 	= "Events Purchase";
		
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        
		return view('classified.home.event-buy', $data);
	}
	
	public function buy_ticket_post(HttpRequest $request)
	{
		
		$rules 	= [
		
			'ticket_quantity'	=>	'required',
		];
		
		$messages = [
		
			'ticket_quantity.required' => 'The Quantity is required.',
		];
		
		// Form validation
        $validator	=	Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {

			return back()->withErrors($validator)->withInput();
		}
		
		$eventTicket					=	new EventTicket();
		$eventTicket->user_id			=	$request->input('usr_id');
		$eventTicket->event_id			=	$request->input('eve_id');
		$eventTicket->ticket_quantity	=	$request->input('ticket_quantity');
		$eventTicket->ticket_amount		=	0;
		$eventTicket->total_amount		=	0;
		$eventTicket->active			=	1;
		$eventTicket->save();
		
		flash()->success(t('Tickets Purchased Successfully!'));
				
		return redirect($this->lang->get('abbr').'/buy/tickets/'.$eventTicket->event_id);
	}
	
	public function event_booking(HttpRequest $request) 
	{
		$event_id	 =	Request::segment(4);
		
		$data		 =	array();
		
		$event		 =	DB::table('events')->where('id', $event_id)->where('country_code', $this->country->get('code'))->first();
		if (!(is_numeric($event_id) && isset($event->id))) {
            abort(404);
        }
		
		$data['tickets']	=	DB::table('event_tickets')
								->select('event_tickets.*','users.name')
								->join('users','users.id','=','event_tickets.user_id')
								->where('event_id', $event_id)
								->orderBy('created_at','desc')
								->paginate(12);
		
		$countries	 =	$this->country->get('currency');
		if($countries != '') {
			
			$event->currency = $countries->html_entity;
		}
		View::share('event', $event);
		
        $title       	= "Events Booking";
		$description 	= "Events Booking";
		
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        
		if ($request->ajax()) {
			
           return view('classified.home.inc.event-booking-ajax', $data);
        }
		return view('classified.home.event-booking', $data);
	}
	
	public function getMyEventOrders(HttpRequest $request)
	{
		
		$data	=	[];
		
		$ticketArr		=	DB::table('event_tickets as et')
							->select('et.event_id','et.user_id','et.ticket_quantity','et.ticket_amount','et.total_amount', 'e.*')
							->join('events as e','e.id','=','et.event_id')
							->where('et.user_id', $this->user->id)
							->where('e.country_code', $this->country->get('code'))
							->orderBy('et.created_at', 'desc')
							->paginate(12);
							
		
		$countries	 =	$this->country->get('currency');
		if($countries != '') {
			
			$ticketArr->currency = $countries->html_entity;
		}
		echo "<pre>";print_r($ticketArr);die;
									
		if(count($ticketArr) > 0)
		{
			$data['tickets']	=	$ticketArr;
		}
		return view('classified.home.myeventsorders', $data);
	}
	
	/* offer page image upload*/ 
	public function offer_picture(Request $request)
	{

		$input = Input::all();
		$rules = array(
			'file' => 'image|max:3000',
		);
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
			return Response::make($validation->errors->first(), 400);
		}
		$file = Input::file('file');
		
        /*$extension = File::extension($file['name']);
        $directory = public_path().'/uploads/pictures/events';;
        $filename = sha1(time().time()).".{$extension}";
        $upload_success = Input::upload('file', $directory, $filename);*/
		
		$destinationPath = public_path().'/uploads/pictures/offers'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		
        if( $upload_success ) {
        	return Response::json( $fileName, 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	
	public function company_logo(Request $request)
	{
		
		$input = Input::all();
		$rules = array(
		    'file' => 'image|max:3000',
		);
		$validation = Validator::make($input, $rules);
		if ($validation->fails())
		{
			return Response::make($validation->errors->first(), 400);
		}
		$file = Input::file('file');
		
		$destinationPath = public_path().'/uploads/pictures/offers'; // upload path
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $fileName = rand(11111, 99999) . '.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $fileName); // uploading file to given path
		
        if( $upload_success ) {
        	return Response::json( $fileName, 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	
	public function postOffer(HttpRequest $request)
	{
		
		$validator = Validator::make($request->all(), Rules::Offer($request));
        if ($validator->fails()) {
			return back()->withErrors($validator)->withInput();
        }
		$country_code   = $request->input('country');
		$offer_title 	= $request->input('offer_title');
		$subadmin1_code	= $request->input('location');
		$location 		= $request->input('offer_location');
		$percentage		= $request->input('percentage');
		$giftcard 		= $request->input('gift');
		$coupen_code	= $request->input('gift_code');
		$offer_image	= $request->input('offer_image');
		$description 	= $request->input('messageArea');
		$company_name 	= $request->input('company_name');
		$company_url 	= $request->input('company_url');
		$company_logo	= $request->input('company_logo');
		
		$subadmin = explode('.',$subadmin1_code);
		//echo $percentage;die;
		$mytime = Carbon\Carbon::now();
		DB::table('offer')->insert(
			
			[
			'country_code'	 => $country_code,
			'offer'			 => $offer_title,
			'description'	 =>$description,
			'image'			 => $offer_image,
			'subadmin1_code' => $subadmin[1],
			'offer_location' => $location,
			'company_name'	 => $company_name,
			'company_logo'	 => $company_logo,
			'compony_url'	 => $company_url,
			'offer_percentage'=> $percentage,
			'giftCard'		 => $giftcard,
			'coupen_code'	 => $coupen_code,
			'active'		 => '1',
			'created_at'	 => $mytime,
			'updated_at'	 => $mytime
			]
		);
		 return redirect('/offers');
		
		
	}
	
	/*  Function to view Compose mail blade */
	public function Compose_messages()
	{
		$data = array();
				
       // Meta Tags
        $title       = "Compose Message";
		$description = "Compose Message";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		return view('classified.home.compose_message', $data);
	}
	
	/* Function to send message from compose message*/
	public function send_compose_message(HttpRequest $request)
	{
		$tomail 	=	$request->input('tomail');
		
		$mailArr	=	array_filter(explode(',', $tomail));
		for($i=0;$i < count($mailArr);$i++) {
			
			$to = $mailArr[$i];
			if(is_numeric($to) && !is_null($to)) {
			
				$sub 		=	$request->input('subject');
				$message 	= 	$request->input('message');
				$user_id 	= 	auth()->user()->id;
				
				$parent_id 	= 	\DB::table('friends_messages')
								->insertGetId(['from_id' => $user_id,'to_id' => $to,'subject' => $sub,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
						
				\DB::table('message_replay')->insert(['parent_id' => $parent_id,'from_id' => $user_id,'to_id' => $to,'reply' => $message,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
				
				MainEvent::fire(new SendMessage($to,$sub,$message,$user_id));     
			}
		}
		flash()->success(t("Your Message Send Successfully."));
		return redirect($this->lang->get('abbr') . '/messages');
	}
	
	public function messages1()
	{
		$data = array();
	
		$data['inbox']	= 	\DB::select(\DB::raw("SELECT r.parent_id as id, count(r.reply) as count, MAX(r.created_at) as cre_at, u.name, u.photo, 
							(SELECT m.subject FROM friends_messages m WHERE m.id=r.parent_id LIMIT 1) as subject, 
							(SELECT m.reply FROM friends_messages m WHERE m.id=r.parent_id LIMIT 1) as notify, 
							(SELECT reply FROM message_replay r1 WHERE r1.parent_id=r.parent_id AND r1.to_id='".Auth::user()->id."' ORDER BY r1.created_at DESC LIMIT 1) as message
							FROM message_replay r, users u WHERE r.from_id=u.id AND r.to_id='".Auth::user()->id."' GROUP BY r.parent_id ORDER BY cre_at DESC"));
						
		$data['sent']	= 	\DB::select(\DB::raw("SELECT r.parent_id as id, count(r.reply) as count, MAX(r.created_at) as cre_at, u.name, u.photo, 
							(SELECT m.subject FROM friends_messages m WHERE m.id=r.parent_id LIMIT 1) as subject, 
							(SELECT reply FROM message_replay r1 WHERE r1.parent_id=r.parent_id AND r1.from_id='".Auth::user()->id."' ORDER BY r1.created_at DESC LIMIT 1) as message
							FROM message_replay r, users u WHERE r.to_id=u.id AND r.from_id='".Auth::user()->id."' GROUP BY r.parent_id ORDER BY cre_at DESC"));
	
       // Meta Tags
        $title       = "Message";
		$description = "Message";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		return view('classified.home.messages', $data);
	}
	
	public function delete_messages() {
		
		if(Request::has('ids')) {
			
			$idsArr	=	Request::get('ids');
			for($i=0;$i < count($idsArr);$i++) {
				
				\DB::table('friends_messages')->where('id', $idsArr[$i])->delete();
				\DB::table('message_replay')->where('parent_id', $idsArr[$i])->delete();
			}
		}
		return Response::json( 'success', 200);
	}
	
	/* Function to view the messages by conversation. */
	public function reply()
	{
		$msg_id = Request::segment(3);
		$data = array();
						
		$mail_message	= 	\DB::table('message_replay')
							->select('message_replay.*','users.name as username','users.photo as userphoto','message_replay.created_at', 'friends_messages.subject as subject')
							->join('users','message_replay.from_id','=','users.id')
							->join('friends_messages','message_replay.parent_id','=','friends_messages.id')
							->where('message_replay.parent_id', $msg_id)
							->orderBy('message_replay.created_at', 'desc')
							->get();
							
		//echo "<pre>";print_r($mail_message);die;
		$data['mail_msge']	 = $mail_message;
		
		// Meta Tags
        $title       = "Reply mail";
		$description = "Reply mail";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		
		return view('classified.home.message_reply', $data);
	}
	
	/* Function to reply to the messages.*/
	public function message_reply(HttpRequest $request)
	{
		//echo "<pre>";print_r($_POST);die;
		$msg_id		=	$request->input('msg_id');
		$from 		= 	auth()->user()->id;
		$to			= 	$request->input('from');
		$mes		=	$request->input('mess');
		$sub		=	$request->input('subj');
		
		\DB::table('message_replay')->insert(['parent_id' => $msg_id,'from_id' => $from,'to_id' => $to,'reply' => $mes,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		\DB::table('friends_messages')->where('id',$msg_id)->update(['reply' => '1']);
		
		MainEvent::fire(new SendMessage($from,$sub,$mes));
		MainEvent::fire(new SendMessage($to,$sub,$mes));
		
		return redirect($this->lang->get('abbr') . '/messages');	
	}
	
	/*  Function to view the Find Friends blade */
	public function find_friendsBk(Request $request)
	{
		session_start();
		define('OAUTH_CONSUMER_KEY', 'dj0yJmk9Q1c2SDVhYWFPdEw5JmQ9WVdrOVNFWlpORlZOTkdFbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD0xNg--');
		define('OAUTH_CONSUMER_SECRET', '43a4f8aad6622c7a4e2d13cd5fdb6579079516ac');
		
		if(isset($_SESSION['yahoo_contacts'])){
			echo "<pre>";
			print_r($_SESSION['yahoo_contacts']);
			unset($_SESSION['yahoo_contacts']);
			exit;
		}
		//$progname = $argv[0];
		$debug = 0; // Set to 1 for verbose debugging output
		$callback    =  "http://www.howlik.com/yahoo_api/yahoo_api/yahoo_callback.php";  
		//$callback      =  lurl('yahoo-contact');  
		 // Get the request token using HTTP GET and HMAC-SHA1 signature 
		  $foo = new MyFuncs();
		 $retarr = $foo->get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $callback, false, true, true);

		if (! empty($retarr)){ 
		list($info, $headers, $body, $body_parsed) = $retarr; 
		
		
		if ($info['http_code'] == 200 && !empty($body)) { 
		// print "Have the user go to xoauth_request_auth_url to authorize your app\n" . 
		//  rfc3986_decode($body_parsed['xoauth_request_auth_url']) . "\n"; 
		//echo "<pre/>"; 
		//print_r($retarr); 
		/* $request->session()->put('request_token', $body_parsed['oauth_token']);
		$request->session()->put('request_token_secret', $body_parsed['oauth_token_secret']);
		$request->session()->put('oauth_verifier', $body_parsed['oauth_token']); */
		
		$_SESSION['request_token']  = $body_parsed['oauth_token'];
		$_SESSION['request_token_secret']  = $body_parsed['oauth_token_secret']; 
		$_SESSION['oauth_verifier'] = $body_parsed['oauth_token']; 
		$url1 = urldecode($body_parsed['xoauth_request_auth_url']);
		@mail("pooja.krishna@shrishtionline.com", "Test yahoo ".time(), serialize($_SESSION));
		//echo  '<a href="'.urldecode($body_parsed['xoauth_request_auth_url']).'" >Yahoo Contact list</a>';
		}}
		
		 $data = array();
		$data['url'] = $url1;
       // Meta Tags
        $title       = "Find Friends";
		$description = "find Friends";
	
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		return view('classified.home.find_friends', $data);
	}
	
	public function find_friends(Request $request)
	{
		session_start();
		$data = array();
		if(isset($_SESSION['yahoo_contacts'])){
			$data['yahoo_contact'] = $_SESSION['yahoo_contacts'];
			unset($_SESSION['yahoo_contacts']);
			//exit;
		}
		
		//$progname = $argv[0];
		$debug = 0; // Set to 1 for verbose debugging output
		
		$data['url'] = 'http://www.howlik.com/yahoo_api/yahoo_api/';
        // Meta Tags
        $title       = "Find Friends";
		$description = "find Friends";
	
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		return view('classified.home.find_friends', $data);
	}
	
	public function getYahooContacts(Request $request)
	{   
		session_start();
		$foo = new MyFuncs();
		define('OAUTH_CONSUMER_KEY', 'dj0yJmk9Q1c2SDVhYWFPdEw5JmQ9WVdrOVNFWlpORlZOTkdFbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD0xNg--');
		define('OAUTH_CONSUMER_SECRET', '43a4f8aad6622c7a4e2d13cd5fdb6579079516ac');
		
		
		$request_token           =   $_SESSION['request_token'];
		$request_token_secret   =   $_SESSION['request_token_secret'];
		$oauth_verifier        =   $_GET['oauth_verifier']; 
		  // Get the access token using HTTP GET and HMAC-SHA1 signature 
		  $retarr = $foo->get_access_token_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $request_token, $request_token_secret, $oauth_verifier, false, true, true); 
		  echo " <pre>"; print_r($retarr);
		  if (! empty($retarr)) { 
		  list($info, $headers, $body, $body_parsed) = $retarr;
		  if ($info['http_code'] == 200 && !empty($body)) { 
		  //   print "Use oauth_token as the token for all of your API calls:\n" . 
		  //      rfc3986_decode($body_parsed['oauth_token']) . "\n"; 
		  // Fill in the next 3 variables. 
		  $guid    =  $body_parsed['xoauth_yahoo_guid'];
		   $access_token  = rfc3986_decode($body_parsed['oauth_token']) ;
			$access_token_secret  = $body_parsed['oauth_token_secret']; 
			// Call Contact API 
			$retarrs = $foo->callcontact_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $guid, $access_token, $access_token_secret, false, true);
			 
		}}
		//echo "hello :<pre>"; print_r($retarrs);
	}
	/*  Function to search a Friend */
	
	public function Search_friend(Request $request)
	{	   
		$data = array();
		
		$user =  $this->user->id;
		$frnd =  Request::get('friend');
		
		$members = \DB::table('users')
					->select('users.*','countries.asciiname as member_country')
					->join('countries','countries.code','=','users.country_code')
					->where('users.email', $frnd)
					->orWhere('users.name', 'like', '%' . $frnd . '%')
					->where('users.user_type_id', '!=', 1)
					->where('users.id', '!=',$user)
					->get();
		
		$data['members'] = $members;
		
       // Meta Tags
        $title       = "Howlik Members";
		$description = "Howlik Members";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));		   
	
		return view('classified.home.member_search_page',$data);
		//echo "<pre>";print_r($frnds);die;			
	}
	
	/*  Function to send message of find Friends blade*/
	public function send_message(Request $request)
	{
		//echo '<pre>';print_r($_REQUEST);die;
	 	$sub 	 = Request::get('subject');
		$msg 	 = Request::get('message');
		$from_id = auth()->user()->id;
		$to_id 	 = Request::get('customer_id');
			
		$parent_id 	= 	\DB::table('friends_messages')
						->insertGetId(['from_id' => $from_id,'to_id' => $to_id,'subject' => $sub,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
						
		\DB::table('message_replay')
				->insert(['parent_id' => $parent_id,'from_id' => $from_id,'to_id' => $to_id,'reply' => $msg,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		
		MainEvent::fire(new SendMessage($to_id,$sub,$msg,$from_id));
		return redirect($this->lang->get('abbr') . '/messages');
	}
	
	/*  Function to add friend in friends list*/
	public function add_friend(Request $request)
	{
		//$sub 	 = "Friend Request From Howlik";
		$msg 	 = Request::get('message');
		$user_id = auth()->user()->id;
		$cust_id = Request::get('customer_id');
		
		$frnd_count = DB::table('add_friend')
						->where('user_id',$user_id)
						->where('friend_id',$cust_id)
						->where('status','Send')
						->count();
						
		$t 	= 	str_random(20);
		
		if($frnd_count == 0) {
			
			\DB::table('add_friend')
		 		->insert(['user_id' => $user_id, 'friend_id' =>$cust_id,'token' => $t,'message' => $msg,
						'created_at'=>date('Y-m-d H:i:s'),'updated_at' =>date('Y-m-d H:i:s'),'status'=>'Send']);
				
			flash()->success(t("Your Request Send Successfully."));
		}
		return redirect()->to('find_friends');
		exit;
	}
	 
	/* Function to pass an activation taoken to confirm the Friend Request */
	public function activation()
	{
		
		$token = Request::segment(4);
		if (trim($token) == '') {
            abort(404);
        }
         
		 $frndRequest = \DB::table('add_friend')->select('add_friend.token','users.*')
		 					->join('users','users.id','=','add_friend.friend_id')
							->where('token',$token)
							->first();
							
		if ($frndRequest) {
			if (Auth::loginUsingId($frndRequest->id)) {
                return redirect($this->lang->get('abbr') . '/friends-confirm');
            } else {
                return redirect($this->lang->get('abbr') . '/login');
            }
		}
		else {
            $data = ['error' => 1, 'message' => t($this->msg['activation']['error'])];
        }
	}
	
	/* Function to confirm the Friend Request. */
	public function friends_confirm()
	{					
		$data = array();
		
		$friend_request = 	\DB::table('add_friend')
							->select('add_friend.id','user_id','status','users.name','users.photo','countries.asciiname')
							->join('users','users.id','=','add_friend.user_id')
							->join('countries','countries.code','=','users.country_code')
							->where('status','=','Send')
							->where('friend_id','=',Auth::user()->id)
							->get();
		
		$data['friend_request'] = $friend_request;
		
       // Meta Tags
        $title       = "New Friend Requests";
		$description = "New Friend Requests";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));		   
	
		return view('classified.home.accept_friend',$data);
	}
	
	public function accept_friend(Request $request)
	{
		$id 	= Request::get('id');
		$status = Request::get('submit');
		
		if($status > 0) {
			
			$friend		= \DB::table('add_friend')->where('id', $id)->first();
			$confirm	= \DB::table('add_friend')->where('user_id', $friend->friend_id)->where('friend_id', $friend->user_id)->first();
					 
			\DB::table('add_friend')
					 ->where('id', $id)
					 ->update(['status' => "Accepted"]);
				
			if(is_null($confirm)) {
				
				\DB::table('add_friend')
					->insert(['user_id' => $friend->friend_id, 'friend_id' => $friend->user_id,'token' => $friend->token,'created_at'=>date('Y-m-d H:i:s'),
								'updated_at' =>date('Y-m-d H:i:s'),'status'=>'Accepted']);
								
			} elseif($confirm->status == 'Send') {
				
				\DB::table('add_friend')
					->where('id', $confirm->id)
					->update(['status' => "Accepted"]);
			}
			flash()->success(t('Friend Request Accepted Successfully!'));
			
		} else {
			
			\DB::table('add_friend')
					 ->where('id', $id)
					 ->update(['status' => "Declined"]);
			
			flash()->error(t('Friend Request Declined Successfully!'));
		}
		return redirect($this->lang->get('abbr') . '/friends-confirm'); 
	}
	
	public function friend_lists(Request $request) {
		
		
		$data = array();
		
		$user_id	=	Request::segment('3');
		
		$friendArr	=	\DB::table('add_friend')
						->select('add_friend.id','add_friend.friend_id','add_friend.status','users.name','users.photo','countries.asciiname')
						->join('users','users.id','=','add_friend.friend_id')
						->join('countries','countries.code','=','users.country_code')
						->where('add_friend.user_id','=',$user_id)
						->where('add_friend.status','=','Accepted')
						->get();
								
		$data['friends']	=	$friendArr;
		
		$title       = "Friends List";
		$description = "Friends List";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		
		return view('classified.home.friends_lists', $data);				
	}
	
	/* Function to invite friends directly by specifying their email id*/
	public function InviteFriends(Request $request)
	{ 
		$toaddress 		= array_filter(Request::get('invite1'));
		$invited_by 	= Request::get('invited_by');
		
		//echo $invited_by;
		foreach( $toaddress as $to)
		{
			$cnt = \DB::table('invited_friends')->where('invited_by',$invited_by)->where('email',$to)->count();
			if($cnt == 0 )
			{
				\DB::table('invited_friends')->insert(['email' => $to,'invited_by' => $invited_by,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
			
			}
		}
		
		if($cnt == 0)
		{
			MainEvent::fire(new SendInvitaion($toaddress));
		}
		
		flash()->success(t('Your Invitation Send Successfully'));
		return redirect()->to('find_friends');
		//return redirect($this->lang->get('abbr') . '/messages');	
	}
    
	public function profiles($id)
	{
		if(!is_numeric($id)) {
            abort(404);
        }
		
		$users	= 	\DB::table('users')
					->select('users.*','countries.name as cname','countries.asciiname')
					->join('countries','countries.code','=','users.country_code')
					->where('users.id',$id)
					->first();
				
		if(is_null($users)) {
            abort(404);
        }
		if(Auth::user()->id != $id && $users->profile_view == 2) {
				
			return view('classified.account.private');
		}
		
		$data	= array();
		$data['users'] 		=  	$users;
		$data['interests'] 	=  	\DB::table('user_interest')->where('active',1)->where('translation_lang', $this->lang->get('abbr'))->get();
		$data['reviewss']	= 	\DB::table('review')->where('review.user_id',$id)->orderBy('review.created_at','DESC')->get();
		$data['eventss']	=	\DB::table('events')->where('events.user_id',$id)->orderBy('events.created_at','DESC')->get();
		
		$title       = "Profile";
		$description = "Public Profile";
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		$data['hdr_profile'] = 1;
		$data['hdr_dropzone'] = 1;
		
		return view('classified.home.myprofile', $data);
	}
	
	public function uploadCover(Request $request) {
		
		$path 		= 'uploads/pictures/covers'; // upload path
        $extension 	= Input::file('file')->getClientOriginalExtension(); // getting file extension
        $filename  	= time() . '.' . $extension; // renameing image
        $success 	= Input::file('file')->move( public_path().'/'.$path, $filename); // uploading file to given path
		
        if($success) {
			\DB::table('users')->where('id', Auth::user()->id)->update(['cover' => $path.'/'.$filename]);
			return Response::json($filename, 200);
        } else {
        	return Response::json('error', 400);
        }
	}
	
	public function removeCover(Request $request) {
		
		$file 	= Input::file('file');
		$path 	= 'uploads/pictures/covers';
		
		if(is_file( public_path().'/'.$path.$file)){
			unlink($path.$file);
		}
		\DB::table('users')->where('id', Auth::user()->id)->update(['cover' => '']);
		return Response::json( 'success', 200);
	}
	
	public function messageReadAjax(Request $request) {
		
		if(Auth::user() && Request::has('id')) {
			
			$id		=	Request::get('id');
			$user	=	Auth::user()->id;
			\DB::table('message_replay')->where('to_id', $user)->where('parent_id', $id)->where('read', 0)->update(['read' => 1]);
		}
		return Response::json( 'success', 200);
	}
	
	public function getCityAjax(Request $request) {
		
		$city_drop = '';
		if(strtolower(Request::segment(1))=='ar') {
			$cname = 'name';
		}else {
			$cname = 'asciiname';
		}
		if(Request::has('code')) {
			
			$city =	DB::table('cities')->where('country_code', Request::get('code'))->where('active', 1)->orderBy($cname, 'asc')->lists($cname , 'id');
			
			if(!is_null($city))
			{
				$city_drop = '<option selected="selected" disabled="disabled"> Select a City </option>';
				if(count($city) > 0) 
				{			
					foreach($city as $key => $val)
					{
						if(Request::has('city') && Request::get('city') == $key) {
							$chkd = "selected";	
						} else {
							$chkd = "";		
						}
						$city_drop .= '<option value="'.$key.'" '.$chkd.'>'.$val.'</option>';
					}
				}
				else
				{
					$city_drop = '<option value=""> Empty Cities </option>';
				}
			}
			else
			{
				$city_drop = '<option value=""> Empty Cities </option>';
			}
			echo json_encode(array('city_drop' => $city_drop));
			exit;
		}
	}
	
	public function setIpAddress(HttpRequest $request)
	{ 
		$latitude	=	$request->input('latitude');
		$longitude	=	$request->input('longitude');
		$timeNow = time();
		$timeGeo = 0;
		if($request->session()->has('vin_geo_time')){
			$timeGeo = (int)$request->session()->get('vin_geo_time');
		}
		$reply['re_url'] = '';
		$reply['vin_geo_country_code'] = session('vin_geo_country_code');
		$timeDiff = (int)$timeNow-$timeGeo;
		$reply['timeDiff'] = $timeDiff;
		if($timeDiff>3600){ 
			$geo_country_code_old = '';
			if($request->session()->has('vin_geo_country_code')){
				$geo_country_code_old = $request->session()->get('vin_geo_country_code');
			}elseif(isset($this->country)){
				$geo_country_code_old = $this->country->get('code');
			}
			$request->session()->put('vin_geo_latitude', $latitude);
			$request->session()->put('vin_geo_longitude', $longitude);
			$tUrl = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&key=AIzaSyAPHJSZW2HT2YXPFpfEOfPOO3LV-4tpEf4';
			$data = json_decode(file_get_contents($tUrl));
			if(isset($data->results[0]->address_components)){
				$address 	= '';
				$region 	= '';
				$state 		= '';
				$country 	= '';
				$country_code 	= '';
				$postcode 	= '';
				foreach($data->results[0]->address_components as $key => $value){
					if(isset($value->types)){ 
						if(in_array('premise', $value->types)){
							$address 	= $value->long_name;
						}elseif(in_array('sublocality', $value->types)){
							$address 	.= ', '.$value->long_name;
						}elseif(in_array('locality', $value->types)){
							$region 	= $value->long_name;
						}elseif(in_array('administrative_area_level_1', $value->types)){
							$state 	= $value->long_name;
						}elseif(in_array('country', $value->types)){
							$country 	= $value->long_name;
							$country_code 	= $value->short_name;
						}elseif(in_array('postal_code', $value->types)){
							$postcode 	= $value->long_name;
						}
					}
				}
				$request->session()->put('vin_geo_address', $address);
				$request->session()->put('vin_geo_region', $region);
				$request->session()->put('vin_geo_state', $state);
				$request->session()->put('vin_geo_country', $country);
				$request->session()->put('vin_geo_country_code', $country_code);
				$request->session()->put('vin_geo_postcode', $postcode);
			}
			if(isset($data->results[0]->formatted_address)){
				$request->session()->put('formatted_address', $data->results[0]->formatted_address);
			}
			$request->session()->put('vin_geo_time', time());
			if($request->session()->has('vin_geo_country_code') && $geo_country_code_old != session('vin_geo_country_code')){
				$location = $request->input('location');
				if(strpos($location,'?')){
					$location .= '&p='.session('vin_geo_country_code');
				}else{
					$location .= '?p='.session('vin_geo_country_code');
				}
				$reply['re_url'] = url($location);
			}
		}
		return json_encode($reply);
	}
}
