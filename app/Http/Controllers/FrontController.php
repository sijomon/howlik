<?php
namespace App\Http\Controllers;

use App\Larapen\Models\Business;
use App\Larapen\Models\Friend;
use App\Larapen\Scopes\ActiveScope;
use App\Larapen\Scopes\ReviewedScope;
use Illuminate\Support\Facades\Input;
use ChrisKonnertz\OpenGraph\OpenGraph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Larapen\CountryLocalization\Facades\CountryLocalization;
use Larapen\CountryLocalization\Helpers\Country;
use Crypt;

class FrontController extends Controller
{
    public $data = array();
    
    protected $cache_expire = 3600; // 1h
    public $ads_pictures_number = 1;
    
    protected $country;
    protected $cookie_expire;
	
	public $countries;
    public $my_business;
    public $pending_business;
    
    public function __construct(Request $request)
    {
		
        // Cache duration setting
        $this->cache_expire = (int)config('settings.app_cache_expire');
        
        // Ads photos number
        $ads_pictures_number = (int)config('settings.ads_pictures_number');
        if ($ads_pictures_number >= 1 and $ads_pictures_number <= 20) {
            $this->ads_pictures_number = $ads_pictures_number;
        }
        if ($ads_pictures_number > 20) {
            $this->ads_pictures_number = 20;
        }
        View::share('ads_pictures_number', $this->ads_pictures_number);
        
        
        // Get User, Country, Domain, lang, ... infos from GeoLocalization middleware /========
        $this->user = $request->get('mw_user');
        $this->country = $request->get('mw_country');
        $this->lang = $request->get('mw_lang');
		
		$email_notificationsA = array();
		if(isset($this->user->email_notifications))$email_notificationsA = unserialize($this->user->email_notifications);
		View::share('user_email_notifications', $email_notificationsA);
        
        // Default language for Bots
        /*$crawler = new CrawlerDetect();
        if ($crawler->isCrawler()) {
            $this->lang = $this->country->get('lang');
            View::share('lang', $this->lang);
            App::setLocale($this->lang->get('abbr'));
        }*/
        
        // Set Local
        if (!$this->lang->isEmpty()) {
            setlocale(LC_ALL, $this->lang->get('locale'));
        }
        
        // Set Language for Countries /========================================================
        $this->country = Country::trans($this->country, $this->lang->get('abbr'));
        View::share('country', $this->country);
		//echo "<pre>";print_r($this->country);die;
		
		$this->countries = Country::transAll(CountryLocalization::getCountries(), $this->lang->get('abbr'));
        View::share('countries', $this->countries);
		
		if(\Auth::check()){
		
			// My Business
			$this->my_business = Business::where('user_id', $this->user->id)->active()->with('city')->take(50)->orderBy('created_at', 'DESC');
			View::share('count_my_business', $this->my_business->count());
			
			// Pending Approval Business
			$this->pending_business = Business::withoutGlobalScopes([ActiveScope::class])->where('user_id',
				$this->user->id)->pending()->with('city')->take(50)->orderBy('created_at', 'DESC');
			View::share('count_pending_business', $this->pending_business->count());
       
			$this->msgcount = \DB::table('message_replay')->where('message_replay.to_id', $this->user->id)->where('read', 0)->count();
			$this->rqtcount = \DB::table('add_friend')->where('add_friend.friend_id', $this->user->id)->where('status', 'Send')->count();
			
			View::share('msgcount', $this->msgcount);
			View::share('rqtcount', $this->rqtcount);
			
			$this->friend_count = Friend::withoutGlobalScopes([ActiveScope::class])->where('add_friend.user_id', $this->user->id)->where('status', 'Accepted')->count();
			View::share('friend_count', $this->friend_count);
			
			$this->event_count = \DB::table('events')->where('events.user_id',$this->user->id)->count();
			View::share('event_count', $this->event_count);
		}
		
        // DNS Prefetch meta tags
        $dns_prefetch = [
            '//fonts.googleapis.com',
            '//graph.facebook.com',
            '//google.com',
            '//apis.google.com',
            '//ajax.googleapis.com',
            '//www.google-analytics.com',
            '//pagead2.googlesyndication.com',
            '//gstatic.com',
            '//cdn.api.twitter.com',
            '//oss.maxcdn.com',
        ];
        View::share('dns_prefetch', $dns_prefetch);
        
        
        // Set Config /==========================================================================
        // reCAPTCHA
        config(['recaptcha.public_key' => env('RECAPTCHA_PUBLIC_KEY', config('settings.recaptcha_public_key'))]);
        config(['recaptcha.private_key' => env('RECAPTCHA_PRIVATE_KEY', config('settings.recaptcha_private_key'))]);
        // Mail
        config(['mail.driver' => env('MAIL_DRIVER', config('settings.mail_driver'))]);
        config(['mail.host' => env('MAIL_HOST', config('settings.mail_host'))]);
        config(['mail.port' => env('MAIL_PORT', config('settings.mail_port'))]);
        config(['mail.encryption' => env('MAIL_ENCRYPTION', config('settings.mail_encryption'))]);
        config(['mail.username' => env('MAIL_USERNAME', config('settings.mail_username'))]);
        config(['mail.password' => env('MAIL_PASSWORD', config('settings.mail_password'))]);
        config(['mail.from.address' => config('settings.app_email')]);
        config(['mail.from.name' => config('settings.app_name')]);
        // Mailgun
        config(['services.mailgun.domain' => env('MAILGUN_DOMAIN', config('settings.mailgun_domain'))]);
        config(['services.mailgun.secret' => env('MAILGUN_SECRET', config('settings.mailgun_secret'))]);
        // Mandrill
        config(['services.mandrill.secret' => env('MANDRILL_SECRET', config('settings.mandrill_secret'))]);
        // Amazon SES
        config(['services.ses.key' => env('SES_KEY', config('settings.ses_key'))]);
        config(['services.ses.secret' => env('SES_SECRET', config('settings.ses_secret'))]);
        config(['services.ses.region' => env('SES_REGION', config('settings.ses_region'))]);
        // Stripe
        config(['services.stripe.key' => env('STRIPE_KEY', config('settings.stripe_key'))]);
        config(['services.stripe.secret' => env('STRIPE_SECRET', config('settings.stripe_secret'))]);
        // PayPal
        config(['services.paypal.mode' => env('PAYPAL_MODE', config('settings.paypal_mode'))]);
        config(['services.paypal.username' => env('PAYPAL_USERNAME', config('settings.paypal_username'))]);
        config(['services.paypal.password' => env('PAYPAL_PASSWORD', config('settings.paypal_password'))]);
        config(['services.paypal.signature' => env('PAYPAL_SIGNATURE', config('settings.paypal_signature'))]);
        // Facebook
        config(['services.facebook.client_id' => env('FACEBOOK_CLIENT_ID', config('settings.facebook_client_id'))]);
        config(['services.facebook.client_secret' => env('FACEBOOK_CLIENT_SECRET', config('settings.facebook_client_secret'))]);
        // Google
        config(['services.google.client_id' => env('GOOGLE_CLIENT_ID', config('settings.google_client_id'))]);
        config(['services.google.client_secret' => env('GOOGLE_CLIENT_SECRET', config('settings.google_client_secret'))]);
        config(['services.googlemaps.key' => env('GOOGLE_MAPS_API_KEY', config('settings.googlemaps_key'))]);
        // Meta-tags
        config(['meta-tags.title' => config('settings.app_slogan')]);
        config(['meta-tags.open_graph.site_name' => config('settings.app_name')]);
        config(['meta-tags.twitter.creator' => config('settings.twitter_username')]);
        config(['meta-tags.twitter.site' => config('settings.twitter_username')]);
        
        // Fix unknown public folder (for elFinder)
        config(['filesystems.disks.uploads-disk.root' => public_path('uploads')]); // Only in version 1.0
        config(['elfinder.roots.0.path' => public_path('uploads')]);


        // SEO /===============================================================================
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
        MetaTag::set('description', $description);


        // Open Graph /=========================================================================
        //->localeAlternate(['en_US']) // @todo: Get all Language locale
        $this->og = new OpenGraph();
        $this->og->siteName(config('settings.app_name'))->locale($this->lang->has('locale') ? $this->lang->get('locale') : 'en_US')->type('website')->url(url()->current());
        View::share('og', $this->og);

        // CSRF Control /========================================================================
        // CSRF - Some JavaScript frameworks, like Angular, do this automatically for you.
        // It is unlikely that you will need to use this value manually.
        setcookie('X-XSRF-TOKEN', csrf_token(), $this->cookie_expire, '/', getDomain());


        // Theme selection /=====================================================================
        if (Input::has('theme')) {
            if (file_exists(public_path() . '/assets/css/style/' . Input::get('theme') . '.css')) {
                config(['app.theme' => Input::get('theme')]);
            } else {
                config(['app.theme' => config('settings.app_theme')]);
            }
        } else {
            config(['app.theme' => config('settings.app_theme')]);
        }
    }
}
