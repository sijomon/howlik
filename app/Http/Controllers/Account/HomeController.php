<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Creativeorange\Gravatar\Facades\Gravatar;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;

use App\Larapen\Models\Ad;
use App\Larapen\Models\Gender;
use App\Larapen\Models\Business;
use App\Larapen\Models\Event;
use App\Larapen\Models\EventType;
use App\Larapen\Models\EventTopic;
use App\Larapen\Models\Category;
use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\City;
use App\Larapen\Models\User;
use App\Larapen\Models\UserInterest;
use App\Larapen\Models\GiftCertificate;
use App\Larapen\Models\GiftRecipient;
use App\Larapen\Models\BusinessVisit;

use App\Larapen\Helpers\Rules;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

use Input;
use Validator;
use File;
use Response;
use Carbon;
use fire;
use URL;
use Auth;

class HomeController extends AccountBaseController
{
    public function index()
    {
        $data = [];
        
        $data['countries'] = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
        $data['genders'] = Gender::where('translation_lang', $this->lang->get('abbr'))->get();
        $data['gravatar'] = Gravatar::fallback(url('images/user.jpg'))->get($this->user->email);
        $data['ad_counter'] = DB::table('ads')->select('user_id', DB::raw('SUM(visits) as total_visits'))->where('user_id',
        $this->user->id)->groupBy('user_id')->first();
		
		// Meta Tags
        MetaTag::set('title', t('My account'));
        MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account/home', $data);
    }
	
	public function edit_account()
    {
        $data = [];
        
        //$countries 	= Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'))->lists('name', 'code');
		//echo "<pre>";
		//print_r($countries);
		//die;
		
        $data['countriess'] = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'))->lists('name', 'code');
        $data['genders'] 	= Gender::where('translation_lang', $this->lang->get('abbr'))->get();
		$data['interests'] 	= UserInterest::where('translation_lang', $this->lang->get('abbr'))->where('active',1)->get();
        $data['gravatar'] 	= Gravatar::fallback(url('images/user.jpg'))->get($this->user->email);
        $data['ad_counter'] = DB::table('ads')->select('user_id', DB::raw('SUM(visits) as total_visits'))->where('user_id',
								$this->user->id)->groupBy('user_id')->first();
		
        // Meta Tags
        MetaTag::set('title', t('My account'));
        MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app_name')]));
        
        return view('classified.account/edit_account', $data);
    }
    
    public function getMyEvents()
	{
		
		$data = [];
        
        $data['countries']		= Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
        $data['genders']		= Gender::where('translation_lang', $this->lang->get('abbr'))->get();
        $data['gravatar']		= Gravatar::fallback(url('images/user.jpg'))->get($this->user->email);
        $data['events_counter']	= DB::table('events')->select('user_id', DB::raw('SUM(visits) as total_visits'))->where('user_id',$this->user->id)->groupBy('user_id')->first();
        $events					= DB::table('events')->where('events.user_id',$this->user->id)->get();
        
        // Meta Tags
        MetaTag::set('title', t('My account'));
        MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app_name')]));
        
		return view('classified.home/myevents', compact('data','events'));
	}
    
    public function editMyEvents(HttpRequest $request,$id)
	{
		$data = [];
		
		$data['event_type']		= EventType::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->lists('name', 'translation_of');
		$data['event_topic']	= EventTopic::where('active', 1)->lists('name', 'id');
		
        $data['countries']	= Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
        
        $data['events']			= DB::table('events')->where('events.user_id',$this->user->id)->where('events.id',$id)->get();
        
        // Meta Tags
        MetaTag::set('title', t('My account'));
        MetaTag::set('description', t('My account on :app_name', ['app_name' => config('settings.app_name')]));
		$data['hdr_ckeditor'] = 1;
		//$data['hdr_datepicker'] = 1;
		$data['hdr_datetimepicker'] = 1;
		$data['hdr_dropzone'] = 1;
 
		return view('classified/home/edit_myevents', $data);
	}
	
	 public function myevent_picture(Request $request){
		
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
    
    public function postMyEvents(HttpRequest $request)
	{
		
		$visible_co	= '';
		$visible_to	= '';
		$id			= $request->input('event_id');
		
		$messages	= [
		
			'event_type_id.required' => 'The event type field is required.'
		];
		
		$rules		= [
		
			'event_title'		=>	'required|max:30',
			'startDate'			=>	'required',
			'endDate'			=>	'required',
			'event_description'	=>	'required',
			'event_type_id'		=>	'required'
		];
		
		if ($request->has('ticket_type')) {
			
			if ($request->input('ticket_type')==1) {
				
				$rules['free_tickets'] = 'required|numeric|min:1|max:9999999999';
			}elseif ($request->input('ticket_type')==2) {
				
				$rules['paid_tickets'] = 'required|numeric|min:1|max:9999999999';
				$rules['ticket_price'] = 'required|numeric|min:1|max:9999999999';
			}
		}
		
		$validator = Validator::make($request->all(), $rules, $messages);
		
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
		$fileExist		= $request->input('imge2');
		$about_event 	= $request->input('event_description');
		/* $org_name		= $request->input('organization_name'); */
		$about_org		= $request->input('messageArea1');
		$privacy		= $request->input('privacy');
		$latitude		= $request->input('lat1');
		$longitude		= $request->input('lon1');
		
		if($privacy > 0) {
			
			$visible	= DB::table('events')->select('visible_to','visible_code')->where('events.id',$id)->first();
			
			if($visible->visible_to != '' && $visible->visible_code != '') {
				
				$visitbl_ar	= unserialize($visible->visible_to);
				$visible_co	= $visible->visible_code;
				$visible_dt	= $request->input('visible_to');
				$visible_ar	= array_filter(explode(',',$visible_dt));
				$link		= "http://www.howlik.com/".$this->lang->get('abbr')."/preview/private/".$visible_co;
				
				if(count($visible_ar) > 0) {
					
					$count	= count($visible_ar);
					for($i=0;$i < $count;$i++) {
						
						if (in_array($visible_ar[$i], $visitbl_ar)) {
							
							
							Mail::send('emails.event.eventapproval', ['link' => $link,'title' => $event_name,'email' => $visible_ar[$i],'code' => $visible_co], function($message) use ($link,$visible_co,$visible_ar,$event_name,$i) {
						
								$message->to($visible_ar[$i]);
								$message->subject('Howlik Event Invitation!');		
							});
							
						} else {
							
							array_push($visitbl_ar, $visible_ar[$i]);
							
							Mail::send('emails.event.eventapproval', ['link' => $link,'title' => $event_name,'email' => $visible_ar[$i],'code' => $visible_co], function($message) use ($link,$visible_co,$visible_ar,$event_name,$i) {
						
								$message->to($visible_ar[$i]);
								$message->subject('Howlik Event Invitation!');		
							});
						}
					}
				}
				$visible_to	= serialize($visitbl_ar);
				
			} else {
				
				$visible_dt	= $request->input('visible_to');
				$visible_ar	= array_filter(explode(',',$visible_dt));
				if(count($visible_ar) > 0) {
					$visible_co	=	getRandWord(8);
					$count		=	count($visible_ar);
					$link		= "http://www.howlik.com/".$this->lang->get('abbr')."/preview/private/".$visible_co;
					for($i=0;$i < $count;$i++) {
						Mail::send('emails.event.eventapproval', ['link' => $link,'title' => $event_name,'email' => $visible_ar[$i],'code' => $visible_co], function($message) use ($link,$visible_co,$visible_ar,$event_name,$i) {
					
							$message->to($visible_ar[$i]);
							$message->subject('Howlik Event Invitation!');		
						});
					}
				}
				$visible_to	= serialize($visible_ar);
			}
			
		}
		
		$event_type 	= $request->input('event_type_id');
		$ticket_type	= $request->input('ticket_type');
		$social_share	= (int)$request->input('social_share');
		$ticket_details	= array();
		/* $topic		= $request->input('event_topic');
		$fb 			= '';
		$twitter		= '';
		$insta			= '';
		$social_link	= (int)$request->input('social_links'); */

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
		if($file == '')
		{
			if($request->input('privacy') == 1 && $request->input('visible_to') != '') {
				
				\DB::table('events')->where('events.id', $id)->update(

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
					'event_image1'=> $fileExist,
					'org_description' => $about_org,
					'privacy' => $privacy,
					'social_share' => $social_share,
					'ticket_type' => $ticket_type,
					'ticket_details' => serialize($ticket_details),
					'visible_to' => $visible_to,
					'visible_code' => $visible_co,
					'latitude' => $latitude,
					'longitude' => $longitude,
					'created_at' => $mytime,
					'updated_at' => $mytime]
				);
			}
			else {
				
				\DB::table('events')->where('events.id', $id)->update(

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
					'event_image1'=> $fileExist,
					'org_description' => $about_org,
					'privacy' => $privacy,
					'social_share' => $social_share,
					'ticket_type' => $ticket_type,
					'ticket_details' => serialize($ticket_details),
					'latitude' => $latitude,
					'longitude' => $longitude,
					'created_at' => $mytime,
					'updated_at' => $mytime]
				);
			}
		}
		else
		{
			if($request->input('privacy') == 1 && $request->input('visible_to') != '') {
				
				\DB::table('events')->where('events.id', $id)->update(

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
					'social_share' => $social_share,
					'ticket_type' => $ticket_type,
					'ticket_details' => serialize($ticket_details),
					'visible_to' => $visible_to,
					'visible_code' => $visible_co,
					'latitude' => $latitude,
					'longitude' => $longitude,
					'created_at' => $mytime,
					'updated_at' => $mytime]
				);
			}
			else {
				
				\DB::table('events')->where('events.id', $id)->update(

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
					'ticket_type' => $ticket_type,
					'ticket_details' => serialize($ticket_details),
					'latitude' => $latitude,
					'longitude' => $longitude,
					'created_at' => $mytime,
					'updated_at' => $mytime]
				);
			}
		}
		
		flash()->success(t('Your Event Updated Successfully.'));
		return redirect('account/myevents')->with(['success' => 1]);
	}
	
	public function deleteMyEvents(HttpRequest $request,$id)
	{
		
		$deleteEvents	= DB::table('events')->where('events.id',$id)->delete();
		
		flash()->success(t('Your Event Deleted Successfully.'));
		return redirect('account/myevents')->with(['success' => 1]);
		
	}
	
	/**
     * Display already uploaded images in Dropzone
     */

    public function getServerImagesPage()
    {
        return view('pages.upload-2');
    }

    public function getServerImages()
    {
        $images = Image::get(['original_name', 'filename']);

        $imageAnswer = [];

        foreach ($images as $image) {
            $imageAnswer[] = [
                'original' => $image->original_name,
                'server' => $image->filename,
                'size' => File::size(public_path('images/full_size/' . $image->filename))
            ];
        }

        return response()->json([
            'images' => $imageAnswer
        ]);
    }
    
	public function getMyCertificateOrders(HttpRequest $request)
	{
		$data	=	[];
		
		if($this->user->user_type_id > 2) {
			
			$receiptArr	=	DB::table('gift_recipients as gr')
							->select('gr.*', 'b.title', 'b.country_code', 'gc.each_price')
							->join('gift_certificates as gc','gc.id','=','gr.gift_id')
							->join('business as b','b.id','=','gr.biz_id')
							->where('gr.recipient_email', $this->user->email)
							->where('b.country_code', $this->country->get('code'))
							->orderBy('gr.created_at', 'desc')
							->paginate(12);
		}
		else {
			
			$receiptArr	=	DB::table('gift_certificates as gc')
							->select('gc.*','b.title')
							->join('business as b','b.id','=','gc.biz_id')
							->where('b.country_code', $this->country->get('code'))
							->where('b.gifting', 1)
							->where('gc.user_id', $this->user->id)
							->orderBy('gc.created_at', 'desc')
							->groupBy('b.title')
							->paginate(12);
		}
		
		$countries	 =	$this->country->get('currency');
		if($countries != '') {
			
			$receiptArr->currency = $countries->html_entity;
		}
									
		if(count($receiptArr) > 0) {
			
			$data['certificates']	=	$receiptArr;
		}
		if ($request->ajax()) {
			
           return view('classified.account.inc.mycertficatesordersajax', $data);
        }
		return view('classified.account.mycertificatesorders', $data);
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
									
		if(count($ticketArr) > 0)
		{
			$data['tickets']	=	$ticketArr;
		}
		if ($request->ajax()) {
			
           return view('classified.home.inc.myeventsordersajax', $data);
        }
		return view('classified.home.myeventsorders', $data);
	}
	
	public function getBusinessGraph(HttpRequest $request) 
	{
		$data	=	array();
		$usrid	=	$this->user->id;
		
		$userArr	=	User::where('id', $usrid)->where('user_type_id', 2)->first();
		if(empty($userArr)) { abort(404); }
		
		$business	=	Business::where('user_id', $usrid)->lists('title','id');
		
		$data['business'] = $business;
		$data['hdr_amchart'] = 1;
		return view('classified.graph.businessgraph', $data);
	}
	
	public function getBusinessGraphDay(HttpRequest $request, $biz_id) 
	{
		
		$today		= 	Carbon\Carbon::today()->toDateString();
		$day31		= 	date("Y-m-d", strtotime("-30 day", strtotime($today)));
		
		$viewArr	=	DB::table('business_visits')
						->select(DB::raw("count(ip_address) as views, DATE_FORMAT(created_at, '%e') as day"))
						->where('biz_id', $biz_id)
						->whereDate('created_at', '>=', $day31)
						->groupBy('day')
						->get();
			
		$giftArr	=	DB::table('gift_certificates')
						->select(DB::raw("sum(total_quantity) as gifts, DATE_FORMAT(created_at, '%e') as day"))
						->where('biz_id', $biz_id)
						->where('active', 1)
						->whereDate('created_at', '>=', $day31)
						->groupBy('day')
						->get();	
					
		$rateArr	=	DB::table('review')
						->select(DB::raw("avg(rating) as rates, DATE_FORMAT(created_at, '%e') as day"))
						->where('biz_id', $biz_id)
						->whereDate('created_at', '>=', $day31)
						->groupBy('day')
						->get();
		
		$j = $day31;
		for($i=1;$i<=31;$i++) {
			
			$k	= date("j", strtotime($j));
			$views[$k] = 0;
			$gifts[$k] = 0;
			$rates[$k] = 0;
			$j	= date("Y-m-d", strtotime("+1 day", strtotime($j)));
		}	
		
		foreach($viewArr as $val) {
			
			if(isset($val->day) && $val->day>0){
				$views[$val->day] = $val->views;
			}
		}
		
		foreach($giftArr as $val) {
			
			if(isset($val->day) && $val->day>0) {
				$gifts[$val->day] = $val->gifts;
			}
		}
		
		foreach($rateArr as $val) {
			
			if(isset($val->day) && $val->day>0){
				$rates[$val->day] = $val->rates;
			}
		}
		
		$i = 0;
		$reply = array();
		foreach($views as $key => $val) {
			
			$reply[$i]["category"] = $key;
			$reply[$i]["column-1"] = $val;
			$reply[$i]["column-2"] = $gifts[$key];
			$reply[$i]["column-3"] = $rates[$key];
			$i++;
		}
		
		return response()->json($reply);
	}
	
	public function getBusinessGraphMonth(HttpRequest $request, $biz_id) 
	{
		
		$today		= 	Carbon\Carbon::today()->toDateString();
		$year1		= 	date("Y-m-d", strtotime("-11 month", strtotime($today)));
	
		$viewArr	=	DB::table('business_visits')
						->select(DB::raw("count(ip_address) as views, DATE_FORMAT(created_at, '%c') as month"))
						->where('biz_id', $biz_id)
						->whereDate('created_at', '>=', $year1)
						->groupBy('month')
						->get();
			
		$giftArr	=	DB::table('gift_certificates')
						->select(DB::raw("sum(total_quantity) as gifts, DATE_FORMAT(created_at, '%c') as month"))
						->where('biz_id', $biz_id)
						->where('active', 1)
						->whereDate('created_at', '>=', $year1)
						->groupBy('month')
						->get();	
					
		$rateArr	=	DB::table('review')
						->select(DB::raw("avg(rating) as rates, DATE_FORMAT(created_at, '%c') as month"))
						->where('biz_id', $biz_id)
						->whereDate('created_at', '>=', $year1)
						->groupBy('month')
						->get();
		
		$j = $year1;
		for($i=1;$i<=12;$i++) {
			
			$k	= date("n", strtotime($j));
			$views[$k] = 0;
			$gifts[$k] = 0;
			$rates[$k] = 0;
			$j	= date("Y-m-d", strtotime("+1 month", strtotime($j)));
		}		
		
		foreach($viewArr as $val) {
			
			if(isset($val->month) && $val->month>0){
				$views[$val->month] = $val->views;
			}
		}
		
		foreach($giftArr as $val) {
			
			if(isset($val->month) && $val->month>0){
				$gifts[$val->month] = $val->gifts;
			}
		}
		
		foreach($rateArr as $val) {
			
			if(isset($val->month) && $val->month>0){
				$rates[$val->month] = $val->rates;
			}
		}
		
		$months =	array(
		
			'1' => 'Jan',
			'2' => 'Feb',
			'3' => 'Mar',
			'4' => 'Apr',
			'5' => 'May',
			'6' => 'Jun',
			'7' => 'Jul',
			'8' => 'Aug',
			'9' => 'Sep',
			'10' => 'Oct',
			'11' => 'Nov',
			'12' => 'Dec'
		);
		
		$i 		= 0;
		$reply 	= array();
		foreach($views as $key => $val) {
			
			$reply[$i]["category"] = $months[$key];
			$reply[$i]["column-1"] = $val;
			$reply[$i]["column-2"] = $gifts[$key];
			$reply[$i]["column-3"] = $rates[$key];
			$i++;
		}
		
		return response()->json($reply);
	}
	
	public function getEventGraph(HttpRequest $request) 
	{
		$data	=	array();
		
		$usrid		=	$this->user->id;
		$event		=	DB::table('events')->where('user_id', $usrid)->lists('event_name','id');
		
		$data['event'] = $event;
		$data['hdr_amchart'] = 1;
		return view('classified.graph.eventgraph', $data);
	}
	
	public function getEventGraphDay(HttpRequest $request, $event_id) 
	{
		
		$today		= 	Carbon\Carbon::today()->toDateString();
		$day31		= 	date("Y-m-d", strtotime("-30 day", strtotime($today)));
		
		$viewArr	=	DB::table('event_visits')
						->select(DB::raw("count(ip_address) as views, DATE_FORMAT(created_at, '%e') as day"))
						->where('event_id', $event_id)
						->whereDate('created_at', '>=', $day31)
						->groupBy('day')
						->get();
			
		$tcktArr	=	DB::table('event_tickets')
						->select(DB::raw("sum(ticket_quantity) as tckts, DATE_FORMAT(created_at, '%e') as day"))
						->where('event_id', $event_id)
						->where('active', 1)
						->whereDate('created_at', '>=', $day31)
						->groupBy('day')
						->get();
		
		$j = $day31;
		for($i=1;$i<=31;$i++) {
			
			$k	= date("j", strtotime($j));
			$views[$k] = 0;
			$tckts[$k] = 0;
			$j	= date("Y-m-d", strtotime("+1 day", strtotime($j)));
		}	
		
		foreach($viewArr as $val) {
			
			if(isset($val->day) && $val->day>0){
				$views[$val->day] = $val->views;
			}
		}
		
		foreach($tcktArr as $val) {
			
			if(isset($val->day) && $val->day>0){
				$tckts[$val->day] = $val->tckts;
			}
		}
		
		$i = 0;
		$reply = array();
		foreach($views as $key => $val) {
			
			$reply[$i]["category"] = $key;
			$reply[$i]["column-1"] = $val;
			$reply[$i]["column-2"] = $tckts[$key];
			$i++;
		}
		
		return response()->json($reply);
	}
	
	public function getEventGraphMonth(HttpRequest $request, $event_id) 
	{
		
		$today		= 	Carbon\Carbon::today()->toDateString();
		$year1		= 	date("Y-m-d", strtotime("-11 month", strtotime($today)));
		
		$viewArr	=	DB::table('event_visits')
						->select(DB::raw("count(ip_address) as views, DATE_FORMAT(created_at, '%c') as month"))
						->where('event_id', $event_id)
						->whereDate('created_at', '>=', $year1)
						->groupBy('month')
						->get();
			
		$tcktArr	=	DB::table('event_tickets')
						->select(DB::raw("sum(ticket_quantity) as tckts, DATE_FORMAT(created_at, '%c') as month"))
						->where('event_id', $event_id)
						->where('active', 1)
						->whereDate('created_at', '>=', $year1)
						->groupBy('month')
						->get();
		
		$j = $year1;
		for($i=1;$i<=12;$i++) {
			
			$k	= date("n", strtotime($j));
			$views[$k] = 0;
			$tckts[$k] = 0;
			$j	= date("Y-m-d", strtotime("+1 month", strtotime($j)));
		}	
		
		foreach($viewArr as $val) {
			
			if(isset($val->month) && $val->month>0){
				$views[$val->month] = $val->views;
			}
		}
		
		foreach($tcktArr as $val) {
			
			if(isset($val->month) && $val->month>0){
				$tckts[$val->month] = $val->tckts;
			}
		}
		
		$months =	array(
		
			'1' => 'Jan',
			'2' => 'Feb',
			'3' => 'Mar',
			'4' => 'Apr',
			'5' => 'May',
			'6' => 'Jun',
			'7' => 'Jul',
			'8' => 'Aug',
			'9' => 'Sep',
			'10' => 'Oct',
			'11' => 'Nov',
			'12' => 'Dec'
		);
		
		$i = 0;
		$reply = array();
		foreach($views as $key => $val) {
			
			$reply[$i]["category"] = $months[$key];
			$reply[$i]["column-1"] = $val;
			$reply[$i]["column-2"] = $tckts[$key];
			$i++;
		}
		
		return response()->json($reply);
	}
}
