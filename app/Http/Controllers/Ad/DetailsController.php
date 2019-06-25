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

namespace App\Http\Controllers\Ad;

use App\Larapen\Events\AdWasVisited;
use App\Larapen\Events\MessageWasSent;
use App\Larapen\Events\ReportAbuseWasSent;
use App\Larapen\Helpers\Rules;
use App\Larapen\Models\Ad;
use App\Larapen\Models\Category;
use App\Larapen\Models\City;
use App\Larapen\Models\Message;
use App\Larapen\Models\Picture;
use App\Larapen\Models\ReportType;
use App\Http\Controllers\FrontController;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Larapen\TextToImage\Facades\TextToImage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Auth;

class DetailsController extends FrontController
{
    public $msg = [];
    
    /**
     * Ad expire time (in months)
     * @var int
     */
    public $expire_time = 3;
    
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        
        /*
         * Messages
         */
        $this->msg['message']['success'] = "Your message has send successfully to :seller_name.";
        $this->msg['report']['success'] = "Your report has send successfully to us. Thank you!";
        $this->msg['mail']['error'] = "The sending messages is not enabled. Please check the SMTP settings in the admin.";
    }
    
    /**
     * Show ad's details.
     *
     * @return Response
     */
    public function index()
    {
        $data = array();
        
        $ad_id = getAdId(Request::segment(3));
		
		$ad = Ad::where('id', $ad_id)->where('country_code', $this->country->get('code'))->with(['user', 'adType', 'city', 'pictures'])->where('active', '1')->first();
        
		if (!(is_numeric($ad_id) && isset($ad->id))) {
            abort(404);
        }
        
        // GET ADS INFO
        if (Auth::check()) {
            $ad = Ad::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->where('id', $ad_id)->with(['user', 'adType', 'city', 'pictures'])->first();
            // Unselect non-self ads
            if (Auth::user()->id != $ad->user_id) {
                $ad = Ad::where('id', $ad_id)->with(['user', 'adType', 'city', 'pictures'])->first();
            }
        }/* else {
            $ad = Ad::where('id', $ad_id)->with(['user', 'adType', 'city', 'pictures'])->first();
        }*/
        // Preview Ad after activation
        if (Input::has('preview') and Input::get('preview')==1) {
            $ad = Ad::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->where('id', $ad_id)->with(['user', 'adType', 'city', 'pictures'])->first();
        }

        View::share('ad', $ad);
        
        // Ad not found
        if (is_null($ad)) {
            abort(404);
        }
        
        // GET AD'S CATEGORY
        $cat = Category::transById($ad->category_id, $this->lang->get('abbr'));
        View::share('cat', $cat);
        
        // Ad's Category not found
        if (is_null($cat)) {
            abort(404);
        }
        
        // GET PARENT CATEGORY
        if ($cat->parent_id == 0) {
            $parent_cat = $cat;
        } else {
            $parent_cat = Category::transById($cat->parent_id, $this->lang->get('abbr'));
        }
        View::share('parent_cat', $parent_cat);
        
        
        // REPORT ABUSE TYPE COLLECTION
        $report_types = ReportType::where('translation_lang', $this->lang->get('abbr'))->get();
        View::share('report_types', $report_types);
        
        // Increment Ad visits counter
        Event::fire(new AdWasVisited($ad));
        
        
        // SEO
        $title = $ad->title . ', ' . $ad->city->name;
        $description = str_limit(str_strip($ad->description), 200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        
        // Open Graph
        $this->og->title($title)->description($description)->type('article')->article(['author' => config('settings.facebook_page_url')])->article(['publisher' => config('settings.facebook_page_url')]);
        if (!$ad->pictures->isEmpty()) {
            if ($this->og->has('image')) {
                $this->og->forget('image')->forget('image:width')->forget('image:height');
            }
            foreach ($ad->pictures as $picture) {
                $this->og->image(url('pic/x/cache/large/' . $picture->filename), [
                    'width' => 600,
                    'height' => 600
                ]);
            }
        }
        View::share('og', $this->og);
        
        
        // Expiration Info
        $today_dt = Carbon::now($this->country->get('timezone')->time_zone_id);
        if ($today_dt->gt($ad->created_at->addMonths($this->expire_time))) {
            flash()->error(t($this->msg['mail']['error']));
        }
        
        
        // Maintenance - Clean the Ad's storage folders (pictures & resumes) /=======================================
        if (is_numeric($ad->id)) {
            $picture_path = public_path() . '/uploads/';
            // for Pictures
            if ($ad->pictures->isEmpty()) {
                if (File::exists($picture_path . 'pictures/' . strtolower($ad->country_code) . '/' . $ad->id)) {
                    File::deleteDirectory($picture_path . 'pictures/' . strtolower($ad->country_code) . '/' . $ad->id);
                }
            }
            // for Resumes
            if (is_null($ad->resume) or empty($ad->resume)) {
                if (File::exists($picture_path . 'resumes/' . strtolower($ad->country_code) . '/' . $ad->id)) {
                    File::deleteDirectory($picture_path . 'resumes/' . strtolower($ad->country_code) . '/' . $ad->id);
                }
            }
        }
        //===========================================================================================================
        
        
        // View
        return view('classified.ad.details.index');
    }
    
    public function sendMessage(HttpRequest $request)
    {
        // Form validation
        $validator = Validator::make($request->all(), Rules::Message($request));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Get Ad ID (input hidden from modal form)
        $ad_id = $request->input('ad');
        if (!is_numeric($ad_id)) {
            abort(404);
        }
        
        // Get Ad
        $ad = Ad::find($ad_id);
        if (is_null($ad)) {
            abort(404);
        }
        
        // Store Message
        $message = new Message(array(
            'ad_id' => $ad_id,
            'name' => $request->input('sender_name'),
            'email' => $request->input('sender_email'),
            'phone' => $request->input('sender_phone'),
            'message' => $request->input('message'),
            'filename' => $request->input('filename'),
        ));
        $message->save();
        
        // Send a message to publisher
        Event::fire(new MessageWasSent($ad, $message));
        
        // Success message
        if (!session('flash_notification')) {
            flash()->success(t($this->msg['message']['success'], ['seller_name' => $ad->seller_name]));
        }
        
        return redirect($this->lang->get('abbr') . '/' . slugify($ad->title) . '/' . $ad->id . '.html');
    }
    
    public function sendReport(HttpRequest $request)
    {
        // Form validation
        $validator = Validator::make($request->all(), Rules::Report($request));
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Get Ad ID (input hidden from modal form)
        $ad_id = $request->input('ad');
        if (!is_numeric($ad_id)) {
            abort(404);
        }
        
        // Get Ad
        $ad = Ad::find($ad_id);
        if (is_null($ad)) {
            abort(404);
        }
        
        // Store Report
        $report = [
            'ad_id' => $ad_id,
            'report_type_id' => $request->input('report_type'),
            'email' => $request->input('report_sender_email'),
            'message' => $request->input('report_message'),
        ];
        
        // Send Abus Report to admin
        Event::fire(new ReportAbuseWasSent($ad, $report));
        
        // Success message
        if (!session('flash_notification')) {
            flash()->success(t($this->msg['report']['success']));
        }
        
        return redirect($this->lang->get('abbr') . '/' . slugify($ad->title) . '/' . $ad->id . '.html');
    }
}
