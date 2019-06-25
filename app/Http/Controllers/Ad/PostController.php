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

use App\Larapen\Events\AdWasPosted;
use App\Larapen\Helpers\Ip;
use App\Larapen\Helpers\Rules;
use App\Larapen\Models\Ad;
use App\Larapen\Models\AdType;
use App\Larapen\Models\Category;
use App\Larapen\Models\Pack;
use App\Larapen\Models\Payment;
use App\Larapen\Models\PaymentMethod;
use App\Larapen\Models\City;
use App\Larapen\Models\Picture;
use App\Larapen\Models\User;
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
        $this->msg['post']['success'] = t("Your Ad has been created.");
        $this->msg['checkout']['success'] = t("We have received your payment. Please check your inbox to activate your ad.");
        $this->msg['checkout']['cancel'] = t("We have not received your payment. Payment cancelled.");
        $this->msg['checkout']['error'] = t("We have not received your payment. An error occurred.");
        $this->msg['activation']['success'] = "Congratulation ! Your ad \":title\" has been activated.";
        $this->msg['activation']['multiple'] = "Your ad is already activated.";
        $this->msg['activation']['error'] = "Your ad's activation has failed.";
        
        /*
         * URL Paths
         */
        $this->uri['form'] = $this->lang->get('abbr') . '/' . trans('routes.create-ad');
        $this->uri['success'] = $this->lang->get('abbr') . '/create-ad/success';
        
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
        $data['ad_types'] = AdType::where('translation_lang', $this->lang->get('abbr'))->get();
        $data['packs'] = Pack::where('translation_lang', $this->lang->get('abbr'))->with('currency')->get();
        $data['payment_methods'] = PaymentMethod::orderBy('lft')->get();

        $this->packs = $data['packs'];
        $this->payment_methods = $data['payment_methods'];
        Rules::$packs = $this->packs;
        Rules::$payment_methods = $this->payment_methods;
        
        view()->share('countries', $data['countries']);
        view()->share('categories', $data['categories']);
        view()->share('ad_types', $data['ad_types']);
        view()->share('packs', $data['packs']);
        view()->share('payment_methods', $data['payment_methods']);
        
        // Meta Tags
        MetaTag::set('title', t('Post a Free Classified Ad'));
        MetaTag::set('description', t('Post a Free Classified Ad') . ' - ' . $this->country->get('name') . '.');
    }
    
    /**
     * Show the form the create a new ad post.
     *
     * @return Response
     */
    public function getForm()
    {
        return view('classified.ad.post.index');
    }
    
    /**
     * Store a new ad post.
     *
     * @param  Request $request
     * @return Response
     */
    public function postForm(HttpRequest $request)
    {
        // Form validation
        $validator = Validator::make($request->all(), Rules::Ad($request, 'POST'));
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
                flash()->error(t("Post Ads has currently desactivate. Please try later. Thank you."));
                
                return back();
            }
        }
		
		$subadmin1_code = '';
		if ($request->has('location')) {
            $tmp = explode('.', $request->input('location'));
			$subadmin1_code = end($tmp);
        }
        
        // Ad data
        $ad_info = array(
            'country_code' => $this->country->get('code'),
            'user_id' => (isset($user) and !is_null($user)) ? $user->id : 0,
            'category_id' => $request->input('category'),
            'ad_type_id' => $request->input('ad_type'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'negotiable' => $request->input('negotiable'),
            'seller_name' => $request->input('seller_name'),
            'seller_email' => $request->input('seller_email'),
            'seller_phone' => $request->input('seller_phone'),
            'seller_phone_hidden' => $request->input('seller_phone_hidden'),
            'city_id' => $request->input('city'),
			'subadmin1_code' => $subadmin1_code,
            'lat' => $city->latitude,
            'lon' => $city->longitude,
            'pack_id' => $request->input('pack'),
            'ip_addr' => Ip::get(),
            'activation_token' => md5(uniqid()),
            'active' => (config('settings.require_ads_activation') == 1) ? 0 : 1,
        );
        
        // Added in release 1.1
        if (Schema::hasColumn('ads', 'address')) {
            $ad_info['address'] = $request->input('address');
        }
        
        // Save Ad to database
        $ad = new Ad($ad_info);
        $ad->save();
        
        
        // Get Pack infos
        $pack = Pack::find($request->input('pack'));
        $need_payment = false;
        if (!is_null($pack) and $pack->price > 0 and $request->has('payment_method')) {
            $need_payment = true;
        }
        
        // Add the Payment Method
        if ($need_payment) {
            $payment_info = array(
                'ad_id' => $ad->id,
                'pack_id' => $pack->id,
                'payment_method_id' => $request->input('payment_method'),
            );
            $payment = new Payment($payment_info);
            $payment->save();
        }
        
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
            $prefix_filename = $country_code . '/' . $ad->id . '/';
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

                        // Ad Picture in database
                        $picture = new Picture(array(
                            'ad_id'    => $ad->id,
                            'filename' => $new_filename,
                        ));
                        $picture->save();
                    } catch (\Exception $e) {
                        flash()->error($e->getMessage());
                    }
                }
            }
        }
        // UPLOAD FILE : RESUME
        if ($request->hasFile('resume')) {
            $destination_path = 'uploads/resumes/';
            $prefix_filename = $country_code . '/' . $ad->id . '/';
            $full_destination_path = public_path() . '/' . $destination_path . $prefix_filename;
            
            // Proccess file request
            $file = $request->file('resume');
            if ($file->isValid()) {
                // Create destination path if not exists
                if (!File::exists($full_destination_path)) {
                    File::makeDirectory($full_destination_path, 0755, true);
                }
                
                // Get file extention
                $extension = $file->getClientOriginalExtension();
                
                // Build the new filename
                $filename_gen = uniqid('resume_');
                $new_filename = strtolower($prefix_filename . $filename_gen . '.' . $extension);
                
                // Save Resume on the server
                $file->move($full_destination_path, $new_filename);
                
                // Ad Resume in database
                $ad->resume = $new_filename;
                $ad->save();
            }
        }
        
        // Init. result
        $result = true;
        
        // CheckOut
        if ($need_payment) {
            $result = $this->postPayment($request, $ad);
        }
        
        if ($result) {
            // Send Confirmation Email
            if (config('settings.require_ads_activation') == 1) {
                Event::fire(new AdWasPosted($ad));
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
        
        return view('classified.ad.post.success');
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
        
        $ad = Ad::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->where('activation_token', $token)->first();
        
        if ($ad) {
            if ($ad->active != 1) {
                // Activate
                $ad->active = 1;
                $ad->save();
                flash()->success(t($this->msg['activation']['success'], ['title' => $ad->title]));
            } else {
                flash()->error(t($this->msg['activation']['multiple']));
            }
            
            return redirect($this->lang->get('abbr') . '/' . slugify($ad->title) . '/' . $ad->id . '.html?preview=1');
        } else {
            $data = ['error' => 1, 'message' => t($this->msg['activation']['error'])];
        }
        
        // Meta Tags
        MetaTag::set('title', $data['message']);
        MetaTag::set('description', $data['message']);
        
        return view('classified.ad.post.activation', $data);
    }
    
    /**
     * Send Payment
     *
     * @param HttpRequest $request
     * @param Ad $ad
     * @return bool
     */
    public function postPayment(HttpRequest $request, Ad $ad)
    {
        // Payment by Paypal (1 in 'payment_methods' table)
        if ($request->input('payment_method') == 1) {
            return PaymentHelper\Paypal::postPayment($request, $ad);
        }
        
        // No Payment
        return true;
    }
    
    /**
     * Success Payment
     *
     * @return mixed
     */
    public function getSuccessPayment()
    {
        // Get session parameters
        $params = Session::get('params');
        
        if ($params) {
            // Get Ad
            $ad = Ad::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->find($params['ad_id']);
            
            // Payment by Paypal
            if (isset($params['payment_method']) and $params['payment_method'] == 1) {
                return PaymentHelper\Paypal::getSuccessPayment($params, $ad);
            }
        }
        
        // Problem with session
        flash()->error($this->msg['checkout']['error']);
        
        // Go to Post form
        return redirect($this->uri['form'] . '?error=paymentSessionNotFound');
    }
    
    /**
     * Cancel Payment
     *
     * @return mixed
     */
    public function cancelPayment()
    {
        // Get session parameters
        $params = Session::get('params');
        
        if ($params) {
            // Get Ad
            $ad = Ad::withoutGlobalScopes([ActiveScope::class, ReviewedScope::class])->find($params['ad_id']);
            $ad->delete();
        }
        
        flash()->error($this->msg['checkout']['cancel']);
        
        // Redirect to Ad form
        return redirect($this->uri['form'] . '?error=paymentCancelled')->withInput();
    }
}
