<?php

namespace App\Http\Controllers;

use Mail;
use App\Larapen\Events\ContactFormWasSent;
use App\Larapen\Helpers\Arr;
use App\Larapen\Helpers\Rules;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Larapen\TextToImage\Facades\TextToImage;
use App\Larapen\Models\Cms;

class PageController extends FrontController
{
    public function about()
    {
		$cmsData = Cms::where('id', 1)->first();
		if($this->lang->get('abbr')=='ar'){
			$title = $cmsData->cms_name_ar;
			$description = $cmsData->cms_description_ar;
		}else{
			$title = $cmsData->cms_name;
			$description = $cmsData->cms_description;
		}
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);
        
        View::share('title', $title);
		View::share('description', $description);
        
        return view('classified.pages.cms');
    }
    
    public function faq()
    {
        $cmsData = Cms::where('id', 6)->first();
		if($this->lang->get('abbr')=='ar'){
			$title = $cmsData->cms_name_ar;
			$description = $cmsData->cms_description_ar;
		}else{
			$title = $cmsData->cms_name;
			$description = $cmsData->cms_description;
		}
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);
        
        View::share('title', $title);
		View::share('description', $description);
        
        return view('classified.pages.cms');
    }
    
    public function phishing()
    {
        // SEO
        $title = trans('page.Phishing');
        $description = str_limit(str_strip(trans('page.phishing_content', ['contactUrl' => '#'])), 200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        
        // Open Graph
        $this->og->title($title)->description($description);
        View::share('og', $this->og);
        
        return view('classified.pages.phishing');
    }
    
    public function antiScam()
    {
		$cmsData = Cms::where('id', 5)->first();
		if($this->lang->get('abbr')=='ar'){
			$title = $cmsData->cms_name_ar;
			$description = $cmsData->cms_description_ar;
		}else{
			$title = $cmsData->cms_name;
			$description = $cmsData->cms_description;
		}
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);
        
        View::share('title', $title);
		View::share('description', $description);
        
        return view('classified.pages.cms');
    }
    
    public function contact()
    {
        // SEO
        $title = trans('page.Contact Us');
        $description = str_limit(str_strip(trans('page.Contact Us')), 200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        
        // Open Graph
        $this->og->title($title)->description($description);
        View::share('og', $this->og);
        return view('classified.pages.contact');
    }
    
    public function contactPost(HttpRequest $request)
    {
        // Form validation
        $validator = Validator::make($request->all(), Rules::ContactUs($request, 'POST'));
        if ($validator->fails()) {
            // BugFix with : $request->except('pictures')
            return back()->withErrors($validator)->withInput();
        }
        
        // Store Contact Info
        $contact_form = array(
            'country_code' => $this->country->get('code'),
            'country' => $this->country->get('name'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'company_name' => $request->input('company_name'),
            'email' => $request->input('email'),
            'message' => $request->input('message'),
        );
       // echo "<pre>";print_r($contact_form); exit;
        // Send Welcome Email
		
		
      //  Event::fire(new ContactFormWasSent(Arr::toObject($contact_form)));
		Mail::send('emails.contact', ['msg' => $contact_form], function ($m) use ($contact_form) {
            $m->from('admin@howlik.com', 'Contact message');
			$toEmail = config('settings.app_email');
			if(trim($toEmail)=='')$toEmail = 'admin@howlik.com';
            $m->to($toEmail, "contact")->subject('Contact message');
        });
		
		
		
        
        if (!session('flash_notification')) {
            flash()->success(t("Your message has been sent to our moderators. Thank you"));
        }
        
        return redirect($this->lang->get('abbr') . '/' . trans('routes.contact'));
    }
    
    public function terms()
    {
		$cmsData = Cms::where('id', 4)->first();
		if($this->lang->get('abbr')=='ar'){
			$title = $cmsData->cms_name_ar;
			$description = $cmsData->cms_description_ar;
		}else{
			$title = $cmsData->cms_name;
			$description = $cmsData->cms_description;
		}
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);
        
        View::share('title', $title);
		View::share('description', $description);
        
        return view('classified.pages.cms');
    }
    
    public function privacy()
    {
        $cmsData = Cms::where('id', 3)->first();
		if($this->lang->get('abbr')=='ar'){
			$title = $cmsData->cms_name_ar;
			$description = $cmsData->cms_description_ar;
		}else{
			$title = $cmsData->cms_name;
			$description = $cmsData->cms_description;
		}
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);
        
        View::share('title', $title);
		View::share('description', $description);
        
        return view('classified.pages.cms');
    }
    
	public function advertise()
    {
        // SEO
        $title = trans('page.advertise');
        $description = str_limit(str_strip(trans('page.advertise_content',
            ['app_name' => mb_ucfirst(config('settings.app_name')), 'domain' => getDomain(), 'country' => $this->country->get('name')])), 200);
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $description);
        
        // Open Graph
        $this->og->title($title)->description($description);
        View::share('og', $this->og);
        
        return view('classified.pages.advertise');
    }
    
	public function press()
    {
        $cmsData = Cms::where('id', 8)->first();
		if($this->lang->get('abbr')=='ar'){
			$title = $cmsData->cms_name_ar;
			$description = $cmsData->cms_description_ar;
		}else{
			$title = $cmsData->cms_name;
			$description = $cmsData->cms_description;
		}
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);
        
        View::share('title', $title);
		View::share('description', $description);
        
        return view('classified.pages.cms');
    }
	
	public function guidelines()
    {
        $cmsData = Cms::where('id', 7)->first();
		if($this->lang->get('abbr')=='ar'){
			$title = $cmsData->cms_name_ar;
			$description = $cmsData->cms_description_ar;
		}else{
			$title = $cmsData->cms_name;
			$description = $cmsData->cms_description;
		}
        
        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', $title);
        
        View::share('title', $title);
		View::share('description', $description);
        
        return view('classified.pages.cms');
    }
    
	public function profile()
    {
		return view('classified.pages.profiles');
	}
	
	public function completed()
    {
		return view('classified.messages.completed');
	}
	
	public function canceled()
    {
		return view('classified.messages.canceled');
	}
	
}
