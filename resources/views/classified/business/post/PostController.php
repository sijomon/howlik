<?php

namespace App\Http\Controllers\Business;

use App\Larapen\Events\BusinessWasPosted;
use App\Larapen\Helpers\Ip;
use App\Larapen\Helpers\Rules;
use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessLocation;
use App\Larapen\Models\BusinessScam;
use App\Larapen\Models\Category;
use App\Larapen\Models\Pack;
use App\Larapen\Models\Payment;
use App\Larapen\Models\PaymentMethod;
use App\Larapen\Models\City;
use App\Larapen\Models\BusinessImage;
use App\Larapen\Models\BusinessOffer;
use App\Larapen\Models\BusinessInfo;
use App\Larapen\Models\User;
use App\Larapen\Models\OfferType;
use App\Http\Controllers\FrontController;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;
use App\Larapen\Helpers\Payment as PaymentHelper;
use Illuminate\Support\Facades\Mail;

class PostController extends FrontController
{
    public $data;
    public $msg = [];
    public $uri = [];
    public $packs;
    public $payment_methods;
    
    /**
     * PostController constructor.
     * @param HttpRequest $request
     */
    public function __construct(HttpRequest $request)
    {
        parent::__construct($request);
        
        /*
         * Check if guests can post Ads
         */
        if (config('settings.activation_guests_can_post') != '1') {
            $this->middleware('auth', ['only' => ['getForm', 'postForm']]);
        }
        
        /*
         * Messages
         */
        $this->msg['post']['success'] = t("Your Business Listing has been created.");
        $this->msg['checkout']['success'] = t("We have received your payment. Please check your inbox to activate your business listing.");
        $this->msg['checkout']['cancel'] = t("We have not received your payment. Payment cancelled.");
        $this->msg['checkout']['error'] = t("We have not received your payment. An error occurred.");
        $this->msg['activation']['success'] = "Congratulation ! Your business listing \":title\" has been activated.";
        $this->msg['activation']['multiple'] = "Your business listing is already activated.";
        $this->msg['activation']['error'] = "Your business listing's activation has failed.";
        
        /*
         * URL Paths
         */
        $this->uri['form'] = $this->lang->get('abbr') . '/' . trans('routes.add-business');
        $this->uri['success'] = $this->lang->get('abbr') . '/add-business/success';
        
        /*
         * Payment Helper vars
         */
        PaymentHelper::$lang = $this->lang;
        PaymentHelper::$msg = $this->msg;
        PaymentHelper::$uri = $this->uri;
        
        /*
         * References
         */
        $data = array();
        $data['countries'] = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
        $data['categories'] = Category::where('parent_id', 0)->where('translation_lang', $this->lang->get('abbr'))->with([
            'children' => function ($query) {
                $query->where('translation_lang', $this->lang->get('abbr'));
            }
        ])->orderBy('lft')->get();
		
		$data['bizMoreInfo'] = BusinessInfo::where('active', 1)->where('translation_lang', $this->lang->get('abbr'))->get();
		
		view()->share('bizMoreInfo', $data['bizMoreInfo']);
        view()->share('countries', $data['countries']);
        view()->share('categories', $data['categories']);
        
        // Meta Tags
        MetaTag::set('title', t('Post a Business Listing'));
        MetaTag::set('description', t('Post a Business Listing') . ' - ' . $this->country->get('name') . '.');
    }
    
    /**
     * Show the form the create a new business listing post.
     *
     * @return Response
     */
    public function getForm()
    {
		if(Auth::user()) {
			
			if($this->user->user_type_id != 2) {
				return view('classified.business.post.error');
			}
			else {
				return view('classified.business.post.index');
			}
		}
    }
    
    /**
     * Store a new business listing post.
     *
     * @param  Request $request
     * @return Response
     */
    public function postForm(HttpRequest $request)
    {
        // Form validation
        $validator = Validator::make($request->all(), Rules::Business($request, 'POST'));
        if ($validator->fails()) {
            // BugFix with : $request->except('pictures')
            return back()->withErrors($validator)->withInput($request->except('pictures'));
        }
        
        
        // Get User if exists
        if (Auth::check()) {
            $user = $this->user;
        } else {
            if ($request->has('seller_email')) {
                $user = User::where('email', $request->input('seller_email'))->first();
            }
        }
        
        // Get city infos
        if ($request->has('city')) {
            $city = City::find($request->input('city'));
            if (is_null($city)) {
                flash()->error(t("Post Business listings has currently deactivate. Please try later. Thank you."));
                
                return back();
            }
        }
		
		$subadmin1_code = '';
		if ($request->has('location')) {
            //$tmp = explode('.', $request->input('location'));
			//$subadmin1_code = end($tmp);
			$subadmin1_code = $request->input('location');
        }
        
		$keywords = '';
		if ($request->has('keywords')) {
			$keywords = implode(',',$request->input('keywords'));
        }
		
		$biz_hours = '';
		if ($request->has('biz_hours')) {
			$biz_hours = serialize($request->input('biz_hours'));
        }
		
        // Business listing data
        $business_info = array(
		
            'country_code' => $this->country->get('code'),
            'user_id' => (isset($user) and !is_null($user)) ? $user->id : 0,
            'category_id' => $request->input('category_id'),
            'keywords' => $keywords,
            'title' => $request->input('title'),
            'description' => $request->input('description'),
			'title_ar' => $request->input('title'),
            'description_ar' => $request->input('description'),
            'biz_hours' => $biz_hours,
            'phone' => $request->input('phone'),
            'web' => $request->input('web'),
            'address1' => $request->input('address1'),
            'address2' => $request->input('address2'),
            'zip' => $request->input('zip'),
            'city_id' => $request->input('city'),
			'subadmin1_code' => $subadmin1_code,
            'lat' => $request->input('lat1'),
            'lon' => $request->input('lon1'),
			'more_info' => serialize($request->input('biz_info')),
            'ip_addr' => Ip::get(),
            'activation_token' => md5(uniqid()),
            'active' => (config('settings.require_business_activation') == 1) ? 0 : 1,
        );
        
        
        // Save Business to database
        $business = new Business($business_info);
        $business->save();
		
		// Save a reference of this Business to database table businessLocations
		$business_location = array(
		
            'biz_id' => $business->id,
            'address_1' => $request->input('address1'),
            'address_2' => $request->input('address2'),
            'phone' => $request->input('phone'),
			'country_id' => $this->country->get('code'),
			'location_id' => $subadmin1_code,
            'city_id' => $request->input('city'),
            'zip_code' => $request->input('zip'),
            'lat' => $request->input('lat1'),
            'lon' => $request->input('lon1'),
            'active' => 1,
        );
        $locationTbl = new BusinessLocation($business_location);
        $locationTbl->save();
        
        // User country unknown (Update It!)
        if (isset($user) and isset($user->country_code) and $user->country_code == '') {
            if (is_numeric($user->id)) {
                $user = User::find($user->id);
                if (!is_null($user)) {
                    $user->country_code = $this->country->get('code');
                    $user->save();
                }
            }
        }
        
        // Uploads
        $country_code = strtolower($this->country->get('code'));
        // UPLOAD FILES : PICTURES
        if ($request->file('pictures')) {
            $destination_path = 'uploads/pictures/';
            $prefix_filename = $country_code . '/' . $business->id . '/';
            $full_destination_path = public_path() . '/' . $destination_path . $prefix_filename;
            
            // Proccess file request
            $files = $request->file('pictures');
            $count_files = count($files);
            if ($count_files > 0) {
                // Generate filename
                $filename_gen = uniqid('img_');
                foreach ($files as $key => $file) {
                    // Check empty fields
                    if (is_null($file) or count($file) <= 0) {
                        continue;
                    }

                    try {
                        // Create destination path if not exists
                        if (!File::exists($full_destination_path)) {
                            File::makeDirectory($full_destination_path, 0755, true);
                        }

                        // Get file extention
                        $extension = $file->getClientOriginalExtension();

                        // Build the new filename
                        $file_number = ($count_files > 1) ? '_' . $key : '';
                        $new_filename = strtolower($prefix_filename . $filename_gen . $file_number . '.' . $extension);

                        // Save Picture on the server (with resizing)
                        Image::make($file)->resize(1000, 1000, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destination_path . $new_filename);

                        // Business listing Picture in database
                        $picture = new BusinessImage(array(
                            'biz_id'    => $business->id,
                            'filename' => $new_filename,
                        ));
                        $picture->save();
                    } catch (\Exception $e) {
                        flash()->error($e->getMessage());
                    }
                }
            }
        }
        
        // Init. result
        $result = true;
        if ($result) {
            // Send Confirmation Email
            if (config('settings.require_business_activation') == 1) {
                Event::fire(new BusinessWasPosted($business));
            }
            
            return redirect($this->uri['success'])->with(['success' => 1, 'message' => $this->msg['post']['success']]);
        } else {
            return redirect($this->uri['form'] . '?error=payment')->withInput();
        }
    }
    
    /**
     * Success post
     *
     * @return mixed
     */
    public function success()
    {
        if (!session('success')) {
            return redirect('/');
        }
        
        // Meta Tags
        MetaTag::set('title', session('message'));
        MetaTag::set('description', session('message'));
        
        return view('classified.business.post.success');
    }
    
    /**
     * Activation
     *
     * @return mixed
     */
    public function activation()
    {
        $token = Request::segment(4);
        if (trim($token) == '') {
            abort(404);
        }
        
        $business = Business::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->where('activation_token', $token)->first();
        
        if ($business) {
            if ($business->active != 1) {
                // Activate
                $business->active = 1;
                $business->save();
                flash()->success(t($this->msg['activation']['success'], ['title' => $business->title]));
            } else {
                flash()->error(t($this->msg['activation']['multiple']));
            }
            
            return redirect($this->lang->get('abbr') . '/' . slugify($business->title) . '/' . $business->id . '.html?preview=1');
        } else {
            $data = ['error' => 1, 'message' => t($this->msg['activation']['error'])];
        }
        
        // Meta Tags
        MetaTag::set('title', $data['message']);
        MetaTag::set('description', $data['message']);
        
        return view('classified.business.post.activation', $data);
    }
    
	public function keywords()
	{
		$cat   = Request::get('cat');
		$vals  = Request::get('vals');
		$valsA = explode(',', $vals);
		
		$res = '';
		if($cat>0){
			$entries = Category::where('translation_lang', config('app.locale'))->where('parent_id', $cat)->orderBy('lft')->get();
			foreach ($entries as $key => $entry) {
				$sel = ''; if(in_array($entry->id, $valsA))$sel = ' checked="checked"';
				$res .= '<div style="float:left;"><input name="keywords[]" value="'.$entry->id.'" '.$sel.' label="'.$entry->name.'" type="checkbox">&nbsp;'.$entry->name.'&nbsp;</div>&nbsp; ';
				//if(($key+1)%3==0)$res .= '<br />';
			}
		}
		echo json_encode (array( 'res' => $res ));
	}
	
	public function report_business()
	{
		$reason   = Request::get('rep_msg');
		$biz_id   = Request::get('biz_id');
		$ip_addr  = Ip::get();
		$user_id  = 0;
		$user_name  = 'Guest';
		if(Auth::user()) {
			$user_id = Auth::user()->id;
			$user_name  = Auth::user()->name;
			$bScam = BusinessScam::where('biz_id', $biz_id)->where('user_id', $user_id)->first();
		}else{
			$bScam = BusinessScam::where('biz_id', $biz_id)->where('ip_addr', $ip_addr)->whereDate('created_at', '=', date('Y-m-d'))->first();
		}
		
		if(!isset($bScam->id)){
			$bScam = new BusinessScam();
			$bScam->user_id = $user_id;
			$bScam->biz_id 	= $biz_id;
			$bScam->reason 	= $reason;
			$bScam->ip_addr = $ip_addr;
			$bScam->save();
			
			$business = Business::where('id', $biz_id)->first();
			$msDet['subject'] = "New business scam has been reported!";
			$bizscam['biz_id'] = $biz_id;
			$bizscam['title'] = $business->title;
			$bizscam['username'] = $user_name;
			$bizscam['reason'] = $reason;//config('settings.app_email')
			Mail::send('emails.business.report', ['bizscam' => $bizscam], function ($m) use ($msDet) {
				$m->to('vineethclm@gmail.com', mb_ucfirst(config('settings.app_name')))->subject($msDet['subject']);
			});
		}
		$res = '<p style="color:#fc0000; text-align:center;"><i class="fa fa-warning"></i>&nbsp'.t('Reported!').'</p>';
		echo json_encode (array( 'res' => $res ));
	}
}
