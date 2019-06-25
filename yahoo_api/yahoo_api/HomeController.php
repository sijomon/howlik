<?php
namespace App\Http\Controllers;
use DB;
use Request;
use App\Larapen\Events\EventWasVisited;
use App\Larapen\Events\SendMessageToFriend;
use App\Larapen\Events\SendMessage;
use App\Larapen\Helpers\Arr;
use App\Larapen\Models\Ad;
use App\Larapen\Models\Event;
use App\Larapen\Models\EventType;
use App\Larapen\Models\EventTopic;
use App\Larapen\Helpers\Rules;
use App\Larapen\Models\Category;
use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\City;
use App\Larapen\Models\User;
use Illuminate\Support\Facades\View;
use Torann\LaravelMetaTags\Facades\MetaTag;
use MyFuncs;
//use App\oauth_helper.php;

use Illuminate\Http\Request as HttpRequest;
use Input;
use Validator;
use File;
use Response;
use Carbon;
use fire;
use Auth;


use Illuminate\Support\Facades\Event as MainEvent;

class HomeController extends FrontController
{
	

    public function index()
    {
		
        $data = array();
        
		if($this->lang->get('abbr')=='ar'){
			$langName = 'name';
		}else{
			$langName = 'asciiname';
		}
        // Get Categories
        $cats = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->orderBy('lft')->get();
        $data['cats'] = collect($cats)->keyBy('id');
        $all_ads = DB::table('ads')
            ->join('cities', 'ads.city_id', '=', 'cities.id')
			->join('categories', 'ads.category_id', '=', 'categories.id')
            ->select('ads.*', 'cities.id as city_id','cities.'.$langName.' as city_name','categories.name as category_name','categories.picture as category_image')
			->where('ads.country_code', '=', $this->country->get('code'))
			->where('ads.active', '=', 1)
            ->get();
			
		$data['all_ads'] = $all_ads;	
		
		
		$all_events = DB::table('events')
			->join('cities', 'events.event_place', '=', 'cities.id')
            ->select('events.*', 'cities.id as city_id','cities.'.$langName.' as city_name')
            ->orderBy('event_date', 'asc')
            ->where('event_date', '>=', date('Y-m-d'))
			->where('events.country_code', '=', $this->country->get('code'))
            ->get();
			
		$data['all_events'] = $all_events;	
		
		
		$data['all_ads_count'] = count($all_ads);
        
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
        
		
		return view('classified.home.welcome', $data);
    }
	
	public function events()
	{
        $data = array();
		
		//BOF All events
		$all_events = DB::table('events')
			->leftjoin('cities','events.event_place', '=', 'cities.id')
            ->select('events.*','cities.name as city_name')
			->orderBy('event_date', 'asc')
            ->where('event_date', '>=', date('Y-m-d'))
			->where('events.country_code', '=', $this->country->get('code'))
            ->get();
			//echo "<pre>";print_r($all_events);die;
		$data['all_events'] = $all_events;	
		//EOF All events
		
		//BOF popular events {only show 50 popular events}
		$pop_events = DB::table('events')
			->leftjoin('cities','events.event_place', '=', 'cities.id')
            ->select('events.*','cities.name as city_name')
            ->orderBy('visits', 'desc')
            ->where('event_date', '>=', date('Y-m-d'))
			->where('events.country_code', '=', $this->country->get('code'))
			->offset(0)
            ->limit(50)
            ->get();
		$data['pop_events'] = $pop_events;
		//EOF popular events
		
		$data['event_type'] = EventType::where('active', 1)->get();
		$data['event_topic'] = EventTopic::where('active', 1)->get();
		
       // Meta Tags
        $title       = "Events";
		$description = "Events";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		$data['hdr_ckeditor'] = 1;
		$data['hdr_datepicker'] = 1;
		$data['hdr_dropzone'] = 1;
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
	
	 public function eventlist(){
		$event_id = Request::segment(3);
		
        $data = array();
		$event = DB::table('events')->select('events.*')->where("id", $event_id)->where('country_code', $this->country->get('code'))->first();
		if (!(is_numeric($event_id) && isset($event->id))) {
            abort(404);
        }
		
		$event_types = DB::table("event_type")->select('name')->where("id", $event->event_type_id)->first();
		$event->event_type_name = $event_types->name;
		$country_names = DB::table('countries')->select('name')->where('code', $event->country_code)->first();	
		$event->country_name = $country_names->name; 
			
		$all_events = DB::table('events')->select('events.*')->orderBy('event_date', 'asc')->where('event_date', '>=', date('Y-m-d'))->where('id', '!=', $event->id)->where('country_code', $this->country->get('code'))->get();
				
		// Increment Event visits counter
		$events = Event::where('id', $event_id)->first();
        MainEvent::fire(new EventWasVisited($events));
		
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
		
		// Form validation
        $validator = Validator::make($request->all(), Rules::Event($request), Rules::EventMsg($request));
        if ($validator->fails()) {
			//echo "hello";die;
            return back()->withErrors($validator)->withInput();
        }
		
		$country_code = $this->country->get('code');
		$event_name = $request->input('event_title');
		$subadmin1_code = $request->input('location');
		$subadmin = explode('.',$subadmin1_code);
		$location = $request->input('event_location');
		$startDate = date('Y-m-d', strtotime($request->input('startDate')));
		$startTime = $request->input('startTime');
		$endDate = date('Y-m-d', strtotime($request->input('endDate')));
		$endTime = $request->input('endTime');
		$file = $request->input('imge1');
		$about_event = $request->input('event_description');
		$org_name = $request->input('organization_name');
		$about_org = $request->input('messageArea1');
		$privacy = $request->input('privacy');
		$event_type = $request->input('type');
		$topic = $request->input('event_topic');
		$fb = $request->input('fb');
		$twitter = $request->input('twitter');
		$ticket_type = $request->input('ticket_type');
		$social_share = (int)$request->input('social_share');
		$ticket_details = array();
		if($ticket_type==1){
			$ticket_details = array('tickets'=>$request->input('free_tickets'));
		}elseif($ticket_type==2){
			$ticket_details = array('tickets'=>$request->input('paid_tickets'), 'price'=>$request->input('ticket_price'), 'currency'=>$request->input('ticket_price'));
		}
		
		if(auth()->user())
		{
			$usr_id = auth()->user()->id;
		}
		else
			$usr_id = 0;
		$mytime = Carbon\Carbon::now();
	
		\DB::table('events')->insert(
			
			['user_id' => $usr_id,
			'country_code' =>$country_code,
			'event_type_id' => $event_type,
			'event_name' => $event_name,
			'event_topic' => $topic,
			'event_date' => $startDate,
			'event_starttime' => $startTime,
			'eventEnd_date'=> $endDate,
			'event_endtime' => $endTime,
			'subadmin1_code' => $subadmin[1],
			'event_place' => $location,
			'about_event' => $about_event,
			'event_image1'=> $file,
			'organization' => $org_name,
			'org_description' => $about_org,
			'privacy' => $privacy,
			'fb_link' => $fb,
			'twitter' => $twitter,
			'social_share' => $social_share,
			'ticket_type' => $ticket_type,
			'ticket_details' => serialize($ticket_details),
			'created_at' => $mytime,
			'updated_at' => $mytime]
		);
		//return redirect('/events');
		return redirect('/events')->with(['success' => 1, 'message' => 'Successfully Event Added.']);
		//echo $user_id;die;
		
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
	public function messages1()
	{
	
		$data = array();
				
       // Meta Tags
        $title       = "Message";
		$description = "Message";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		return view('classified.home.messages', $data);
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
	
	public function send_compose_message()
	{
		$tomail 	=	$_POST['tomail'];
		//echo $to;die;
		$to = \DB::table('users')->select('id')->where('email',$tomail)->first();
		//echo "<pre>";print_r($to);die;
		$sub 	=	$_POST['subject'];
		$message =	$_POST['message'];
		$user_id = auth()->user()->id;
		
		
		$parent_id = \DB::table('conversation')
				->insertGetId(['started_by' => $user_id,'to_id' => $to->id,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		
			
		\DB::table('friends_messages')
				->insert(['parent_id' => $parent_id,'from_id' => $user_id,'to_id' => $to->id,'subject' => $sub,'message' => $message,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		
		MainEvent::fire(new SendMessage($to->id,$sub,$message));
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
			/*echo "<pre>";
			print_r($_SESSION['yahoo_contacts']);
			unset($_SESSION['yahoo_contacts']);
			//exit;*/
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
		
		
		
		//echo "<pre>";print_r($_SESSION);
		//return redirect($this->lang->get('abbr') . '/find_friends'); 
		//exit;
		//echo "<pre>";print_r($request->session()->all());die;
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
	
	public function Search_friend()
	{
		$frnd =  $_POST['friend'];
		$members = \DB::table('users')
					->select('users.*','countries.asciiname as member_country')
					->join('countries','countries.code','=','users.country_code')
					->where('users.email', $frnd)
					->orWhere('users.name', 'like', '%' . $frnd . '%')
					->get();
			   
		$data = array();
		//echo "<pre>";print_r($members);die;
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
	
	public function send_message()
	{
	 	$sub = $_POST['subject'];
		$msg = $_POST['message'];
		$user_id = auth()->user()->id;
		$cust_id = $_POST['customer_id'];
		
		
		$parent_id = \DB::table('conversation')
				->insertGetId(['started_by' => $user_id,'to_id' => $cust_id,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		
			
		\DB::table('friends_messages')
				->insert(['parent_id' => $parent_id,'from_id' => $user_id,'to_id' => $cust_id,'subject' => $sub,'message' => $msg,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
		
		MainEvent::fire(new SendMessage($cust_id,$sub,$msg));
		return redirect($this->lang->get('abbr') . '/messages');
	}
	
	/*  Function to add friend in friends list*/
	
	public function add_friend()
	{
		$sub = $_POST['subject'];
		$msg = $_POST['message'];
		$user_id = auth()->user()->id;
		$cust_id = $_POST['customer_id'];
		//echo $cust_id;die;
		$frnd_count = DB::table('add_friend')
						->where('user_id',$user_id)
						->where('friend_id',$cust_id)
						->where('status','Send')
						->count();
		//echo $frnd_count;die;
		$t = str_random(20);
		//echo "random number : ".$t;die;
		if($frnd_count == 0){
		 \DB::table('add_friend')
		 		->insert(['user_id' => $user_id, 'friend_id' =>$cust_id,'token' => $t,'created_at'=>date('Y-m-d H:i:s'),
										'updated_at' =>date('Y-m-d H:i:s'),'status'=>'Send']);
										
		$parent_id = \DB::table('conversation')
				->insertGetId(['started_by' => $user_id,'to_id' => $cust_id,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
				
		\DB::table('friends_messages')
				->insert(['parent_id' => $parent_id,'from_id' => $user_id,'to_id' => $cust_id,'subject' => $sub,'message' => $msg,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s')]);
			 
			 MainEvent::fire(new SendMessageToFriend($cust_id));
			 session()->flash('message','Successfully Friend Request Sent');
		}
		return redirect()->to('find_friends');
		//echo "success";
		exit;
        
 		//echo $user_id;die;
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
		//echo "<pre>";print_r($frndRequest);die;
		 if ($frndRequest) {
		 
		 
		 if (Auth::loginUsingId($frndRequest->id)) {
                //$this->user = Auth::user();
                //View::share('user', $this->user);
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
	
		$friend_request = \DB::table('add_friend')
									->select('add_friend.id','user_id','status','users.name','countries.asciiname')
									->join('users','users.id','=','add_friend.user_id')
									->join('countries','countries.code','=','users.country_code')
									->where('status','=','Send')
									->where('friend_id','=',Auth::user()->id)
									->get();
		//echo "<pre>";print_r($friend_request);die;
		$data = array();
		
		$data['friend_request'] = $friend_request;
		
       // Meta Tags
        $title       = "New Friend Requests";
		$description = "New Friend Requests";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));		   
	
		return view('classified.home.accept_friend',$data);
		
	}
	
	public function accept_friend()
	{
		$id = $_POST['id'];
		
		\DB::table('add_friend')
           		 ->where('id', $id)
           		 ->update(['status' => "Accepted"]);
		
		\Session::flash('message', 'Friend Request Accepted Successfully!'); 
		\Session::flash('alert-class', 'alert-danger'); 
		return redirect($this->lang->get('abbr') . '/friends-confirm'); 
	}
	
	
	/* Function to view the messages by conversation. */
	
	public function reply()
	{
		
		$msg_id = Request::segment(3);
		$p = \DB::table('friends_messages')->select('parent_id')->where('id',$msg_id)->first();
		//echo "<pre>";print_r($p);die;
		$mail_message = \DB::table('friends_messages')
								->select('friends_messages.*','users.name as username',
												'friends_messages.created_at as message_created')
								->join('users','friends_messages.from_id','=','users.id')
								->where('friends_messages.parent_id', $p->parent_id)
								->orderBy('message_created','desc')
								->get();
	
		$data = array();
		$data['mail_msge']	 = $mail_message;	
       // Meta Tags
        $title       = "Reply mail";
		$description = "Reply mail";
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
		
		return view('classified.home.message_reply', $data);
	}
	
	/* Function to reply to the messages.*/
	
	public function message_reply()
	{
	
		$msg_id		=	$_POST['msg_id'];
		$from 		= 	auth()->user()->id;
		$to			= 	$_POST['from'];
		$mes		=	$_POST['mess'];
		//echo $msg_id;die;
		$prnt_id = \DB::table('friends_messages')->select('parent_id','subject')->where('id',$msg_id)->first();
		
		//echo "<pre>";print_r($prnt_id->parent_id);die;
		
		/*\DB::table('friends_messages')
				->insert(['parent_id' => $prnt_id->parent_id,'from_id' => $from,'to_id' => $to,'message' => $mes,'created_at' =>date('Y-m-d H:i:s'),'updated_at' => date('Y-m-d H:i:s'),'reply'=>'1']);
			*/
		MainEvent::fire(new SendMessage($to,$prnt_id->subject,$mes));
		return redirect($this->lang->get('abbr') . '/messages');	
		
	}
	
	
}
