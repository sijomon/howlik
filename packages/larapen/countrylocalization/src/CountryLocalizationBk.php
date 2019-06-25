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

namespace Larapen\CountryLocalization;

use App\Larapen\Models\Ad;
use Illuminate\Support\Facades\Request;
use Larapen\CountryLocalization\Models\Country;
use Larapen\CountryLocalization\Models\Currency;
use Larapen\CountryLocalization\Models\Language;
use Larapen\CountryLocalization\Models\TimeZone;
use Larapen\CountryLocalization\Models\Location;
use Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Larapen\Settings\app\Models\Setting;
use PulkitJalan\GeoIP\Facades\GeoIP;
use Jaybizzle\CrawlerDetect\CrawlerDetect;

class CountryLocalization
{
    public $default_country = '';
    public $default_uri = '/';
    public $countries_list_uri = '/countries';
    
    public $user;
    public $countries;
    public $country;
    public $ip_country;
    public $site_country_info = '';
	public $vlocations = array();
    
    public static $cache_expire = 60;
    public static $cookie_expire = 60;
    
    // Maxmind Support URL
    private static $maxmind_support_url = 'http://larapen.com/guide/laraclassified/';
    
    
    public function __construct()
    {
        $this->app = app();
        
        $this->configRepository = $this->app['config'];
        $this->view = $this->app['view'];
        $this->translator = $this->app['translator'];
        $this->router = $this->app['router'];
        $this->request = $this->app['request'];
        $this->language = new LanguageLocalization();
        
        
        // Default values
        $this->default_country_code = config('settings.app_default_country');
        $this->default_url = url(config('larapen.countrylocalization.default_uri'));
        $this->default_page = url(config('app.locale') . '/' . trans('routes.' . config('larapen.countrylocalization.countries_list_uri')));
        
        // Cache and Cookies Expires
        self::$cache_expire = config('settings.app_cache_expire');
        self::$cookie_expire = config('settings.app_cookie_expire');
        
        // Check if User is logged
        $this->user = $this->checkUser();
        
        // Init. Country Infos
        $this->country = collect([]);
        $this->ip_country = collect([]);
    }
    
    /**
     * @return bool|mixed|\stdClass
     */
    public function findCountry()
    {
        // Get user IP country
        $this->ip_country = $this->getCountryFromIP();
       
        // Get current country
        $this->country = $this->getCountryFromQueryString();
        if ($this->country->isEmpty()) {
            //$this->country = $this->getCountryFromAd();
            if ($this->country->isEmpty()) {
                //$this->country = $this->getCountryFromURIPath();
                if ($this->country->isEmpty()) {
                    //$this->country = $this->getCountryForBots();
                }
            }
        }
        
        if ($this->request->session()->has('country_code') and $this->country->isEmpty()) {
            $this->country = self::getCountryInfo(session('country_code'));
        } else {
            if ($this->country->isEmpty()) {
                $this->country = $this->getDefaultCountry($this->default_country_code);
            }
            if ($this->country->isEmpty()) {
                if (!$this->ip_country->isEmpty() and $this->ip_country->has('code')) {
                    $this->country = $this->ip_country;
                }
            }
        }
		
		//BOF code for IP country/default country added by vineeth 
		if (!$this->request->session()->has('vin_country_code')) {
			$vConA = json_decode($this->ip_country);
			$defConJson = '';
			if(isset($this->default_country_code) && trim($this->default_country_code)!=''){
				$defConJson = $this->getDefaultCountry($this->default_country_code);
				$defConA = json_decode($defConJson);
			}
			if(isset($vConA->code) && trim($vConA->code)!=''){
				$this->country = $this->ip_country;
			}else if(isset($defConA->code) && trim($defConA->code)!=''){
				$this->country = $defConJson;
			}
		}
		
			
		if($this->country->has('code')){
			
			/*view()->composer('classified.layouts.layout', function($view)
			{
				$lang = Request::segment(1);
				$fildNm = 'name';if($lang!='ar') $fildNm = 'asciiname';
				$vlocations = Location::where('code', 'LIKE', $this->country->get('code').'.%')->orderBy($fildNm, 'ASC')->get()->keyBy('id');
				$tvar = GeoIP::get();
			
				$defRegion='';
				if(isset($tvar['region']) && trim($tvar['region'])!=''){
					foreach($vlocations as $v_loc){
						if($lang!='ar') $v_loc->name =  $v_loc->asciiname;
						if($defRegion=='')$defRegion = $v_loc->name;
						if(strtolower(trim($v_loc->name))==strtolower(trim($tvar['region']))){
							$defRegion = $v_loc->name;
						}
					}
				}
				
				$view->with('vregion', $defRegion);
				$view->with('vlocations', $vlocations);
			});*/
			
			view()->composer('*', function($view)
			{
				$lang = Request::segment(1);
				$fildNm = 'name';if($lang!='ar') $fildNm = 'asciiname';
				$vlocations = Location::where('code', 'LIKE', $this->country->get('code').'.%')->orderBy($fildNm, 'ASC')->get()->keyBy('id');
				$tvar = GeoIP::get();
			
				$defRegion='';
				if(isset($tvar['region']) && trim($tvar['region'])!=''){
					foreach($vlocations as $v_loc){
						if($lang!='ar') $v_loc->name =  $v_loc->asciiname;
						if($defRegion=='')$defRegion = $v_loc->name;
						if(strtolower(trim($v_loc->name))==strtolower(trim($tvar['region']))){
							$defRegion = $v_loc->name;
						}
					}
				}
				
				$view->with('vregion', $defRegion);
				$view->with('vlocations', $vlocations);
			});
			
			$tvar = GeoIP::get();
			$defLat='';
			if(isset($tvar['latitude']) && trim($tvar['latitude'])!=''){
				$defLat = trim($tvar['latitude']);
			}
			$defLon='';
			if(isset($tvar['longitude']) && trim($tvar['longitude'])!=''){
				$defLon = trim($tvar['longitude']);
			}
			
			view()->share('vlat', $defLat);
			view()->share('vlon', $defLon);
			
			
		}
		//EOF code for GEO country/default country added by vineeth 
		
        return $this->country;
    }
    
    /**
     * @return bool
     */
    public function setCountryParameters()
    {
        // SKIP Countries selection page
        if ($this->request->segment(2) == trans('routes.' . config('larapen.countrylocalization.countries_list_uri'))) {
            return false;
        }
        // SKIP All xml page (Sitemaps)
        if (ends_with($this->request->url(), '.xml')) {
            return false;
        }
        
        
        // Redirect country not found
        if (!$this->isAvailableCountry($this->country->get('code'))) {
            // Redirect to country selection page
            header('Location: ' . $this->default_page, true, 301);
            exit();
        }
        
        // SiteInfo : Not logged
        if (!Auth::check() and !in_array($this->request->segment(2), [
                trans('routes.login'),
                trans('routes.signup'),
                trans('routes.create-ad'),
                trans('routes.about'),
                trans('routes.contact'),
                trans('routes.faq'),
                trans('routes.phishing'),
                trans('routes.anti-scam'),
                trans('routes.sitemap'),
                trans('routes.terms'),
                trans('routes.privacy')
            ]) and !Input::has('iam') and $this->request->segment(2) !== null and is_null(getAdId($this->request->segment(3))) and !str_contains(Route::currentRouteAction(),
                'SearchController') and !str_contains(Route::currentRouteAction(), 'SitemapController') and !str_contains(Route::currentRouteAction(),
                'PasswordController')
        ) {
            $msg = 'Login for faster access to the best deals. Click here if you don\'t have an account.';
            $this->site_country_info = t($msg, ['login_url' => lurl(trans('routes.login')), 'register_url' => lurl(trans('routes.signup'))]);
        }
        
        // SiteInfo : Country - We know the user IP country and selected country
        if (config('settings.activation_geolocation')) {
            if (!$this->ip_country->isEmpty() and !$this->country->isEmpty()) {
                if ($this->ip_country->get('code') != $this->country->get('code')) {
                    $url = url(CountryLocalization::getLangFromCountry($this->ip_country->get('languages'))->get('code') . '/?d=' . $this->ip_country->get('code'));
                    $msg = ':app_name is also available in your country: :country. Start the best deals here now!';
                    $this->site_country_info = t($msg,
                        ['app_name' => config('settings.app_name'), 'country' => $this->ip_country->get('name'), 'url' => $url]);
                }
            }
        }
        
        return true;
    }
    
    public function getDefaultCountry($default_country_code)
    {
        // Check default country
        if (trim($default_country_code) != '') {
            if ($this->isAvailableCountry($default_country_code)) {
                return self::getCountryInfo($default_country_code);
            }
        }
        
        return collect([]);
    }
    
    /**
     * Get Country from logged User
     * @return bool|\stdClass
     */
    public function getCountryFromUser()
    {
        if (Auth::check()) {
            if (isset($this->user) and isset($this->user->country_code)) {
                if ($this->isAvailableCountry($this->user->country_code)) {
                    return self::getCountryInfo($this->user->country_code);
                }
            }
        }
        
        return collect([]);
    }
    
    /**
     * Get Country from logged User
     * @return bool|\stdClass
     */
    public function getCountryFromAd()
    {
        $ad_id = getAdId($this->request->segment(3));
        if (is_null($ad_id)) {
            return collect([]);
        }
        
        // GET ADS INFO
        $ad = Ad::active()->where('id', $ad_id)->first();
        if (is_null($ad)) {
            return collect([]);
        }
        
        $country_code = $ad->country_code;
        
        if ($this->isAvailableCountry($country_code)) {
            return self::getCountryInfo($country_code);
        }
        
        return collect([]);
    }
    
    /**
     * Get Country from Domain
     * @return bool|\stdClass
     */
    public function getCountryFromDomain()
    {
        $country_code = getSubDomainName();
        if ($this->isAvailableCountry($country_code)) {
            return self::getCountryInfo($country_code);
        }
        
        return collect([]);
    }
    
    /**
     * Get Country from Query String
     * @return bool|\stdClass
     */
    public function getCountryFromQueryString()
    {
        $country_code = '';
        if (Input::has('site')) {
            $country_code = Input::get('site');
			//$this->request->session()->put('vin_country_code',  $country_code);
        }
        if (Input::has('d')) {
            $country_code = Input::get('d');
			//$this->request->session()->put('vin_country_code',  $country_code);
        }
		if (Input::has('p')) {
            $country_code = Input::get('p');
			$this->request->session()->put('vin_country_code',  $country_code);
        }
        
        if ($this->isAvailableCountry($country_code)) {
            return self::getCountryInfo($country_code);
        }
        
        return collect([]);
    }
    
    /**
     * Get Country from Query String
     * @return bool|\stdClass
     */
    public function getCountryFromURIPath()
    {
        $country_code = $this->request->segment(2);
        if ($this->isAvailableCountry($country_code)) {
            return self::getCountryInfo($country_code);
        }
        
        return collect([]);
    }
    
    /**
     * Get Country for Bots if not found
     * @return bool|\stdClass
     */
    public function getCountryForBots()
    {
        $CrawlerDetect = new CrawlerDetect();
        if ($CrawlerDetect->isCrawler()) {
            // Don't set the default country for homepage
            if (!str_contains(Route::currentRouteAction(), 'HomeController')) {
                $country_code = 'BJ';
                if ($this->isAvailableCountry($country_code)) {
                    return self::getCountryInfo($country_code);
                }
            }
        }
        
        return collect([]);
    }
    
    
    /**
     * @return bool|mixed|\stdClass
     */
    public function getCountryFromIP()
    {
        $country = $this->getCountryFromCookie();
        if (!$country->isEmpty()) {
            if ($country->get('level') == 'user') { // @todo: Check if user has logged
                $country = self::getCountryInfo($country->get('code'));
            }
            
            return $country;
        } else {
            // GeoIP
            $country_code = $this->getCountryCodeFromIP();
            if (!$country_code or trim($country_code) == '') {
                // Geolocalization has failed
                return collect([]);
            }
            
            return $this->setCountryToCookie($country_code);
        }
    }
    
    /**
     * @param $country
     * @return bool
     */
    public function setCountryToCookie($country_code)
    {
        if (trim($country_code) == '') {
            return collect([]);
        }
        
        if (isset($_COOKIE['ip_country_code'])) {
            unset($_COOKIE['ip_country_code']);
        }

        setcookie('ip_country_code', $country_code, self::$cookie_expire, '/', $this->getDomain());
        
        return self::getCountryInfo($country_code);
    }
    
    /**
     * @return bool|mixed
     */
    public function getCountryFromCookie()
    {
        if (isset($_COOKIE['ip_country_code'])) {
            $country_code = $_COOKIE['ip_country_code'];
            if (trim($country_code) == '') {
                return collect([]);
            } // TMP
            return self::getCountryInfo($country_code);
        } else {
            return collect([]);
        }
    }
    
    /**
     * @param $default_country
     * @return bool|string
     */
    public function getCountryCodeFromIP()
    {
        // Localize the user's country
        try {
            $ip_addr = $this->getIp();
            
            
            GeoIP::setIp($ip_addr);
            $country_code = GeoIP::getCountryCode();
            
            
            if (!is_string($country_code) or strlen($country_code) != 2) {
                return false;
            }
        } catch (\Exception $e) {
            if (config('settings.activation_geolocation')) {
                if (Auth::check()) {
                    $user = Auth::user();
                    if ($user->is_admin == 1) {
                        // Get settings
                        $setting = Setting::where('key', 'activation_geolocation')->first();
                        
                        // Notice message for admin users
                        $msg = "";
                        $msg .= "<h4><strong>Only Admin Users can see this message</strong></h4>";
                        $msg .= "<strong>Maxmind GeoLite2 City</strong> not found at: ";
                        $msg .= "<code>" . database_path('maxmind/') . "</code><br>";
                        $msg .= "Please check the <a href='" . self::$maxmind_support_url . "' target='_blank'>Maxmind database installation for LaraClassified</a> support.";
                        $msg .= "<br><br><a href='/admin/setting/" . $setting->id . "/edit' class='btn btn-xs btn-thin btn-default-lite' id='disableGeoOption'>Disable the Geolocalization</a>";
                        flash()->warning($msg);
                    }
                }
            }
            
            return false;
        }
        
        return strtolower($country_code);
    }
    
    /**
     * @param $country_code
     * @return bool|\stdClass
     */
    public static function getCountryInfo($country_code)
    {
        if (trim($country_code) == '') {
            return collect([]);
        }
        $country_code = strtoupper($country_code);
        
        $country = Country::find($country_code);
        if (is_null($country)) {
            return collect([]);
        }
        $country = $country->toArray();
        
        $currency = Currency::find($country['currency_code']);
        $lang = self::getLangFromCountry($country['languages']);
        $time_zone = TimeZone::where('country_code', 'LIKE', $country_code)->first();
        
        $country['currency'] = ($currency) ? $currency : [];
        $country['lang'] = ($lang) ? $lang : [];
        $country['timezone'] = ($time_zone) ? $time_zone : [];
        $country = collect($country);
        
        return $country;
    }
    
    /**
     * Only used for search bots
     * @param $languages
     * @return mixed
     */
    public static function getLangFromCountry($languages)
    {
        // Get language code
        $lang_code = $hreflang = '';
        if (trim($languages) != '') {
            $country_language = explode(',', $languages);
            $available_language = Language::all();
            if (!is_null($available_language)) {
                $found = false;
                foreach ($country_language as $isoLang) {
                    foreach ($available_language as $language) {
                        if (starts_with(strtolower($isoLang), strtolower($language->abbr))) {
                            $lang_code = $language->abbr;
                            $hreflang = $isoLang;
                            $found = true;
                            break;
                        }
                    }
                    if ($found) {
                        break;
                    }
                }
            }
        }
        
        // Get language info
        if ($lang_code != '') {
            $is_available_lang = collect(Language::where('abbr', $lang_code)->first());
            if (!$is_available_lang->isEmpty()) {
                $lang = $is_available_lang->merge(collect(['hreflang' => $hreflang]));
            } else {
                $lang = self::getLangFromConfig();
            }
        } else {
            $lang = self::getLangFromConfig();
        }
        
        return $lang;
    }
    
    /**
     * @return mixed
     */
    public static function getLangFromConfig()
    {
        // Default language
        $lang_code = $hreflang = config('app.locale');
        $language = Language::where('abbr', $lang_code)->first();
        $lang = collect($language)->merge(collect(['hreflang' => $hreflang]));
        
        return $lang;
    }
    
    /**
     * Load all Countries
     * @param $request
     * @return bool|\Illuminate\Support\Collection|\stdClass
     */
    public static function getCountries()
    {
        $countries = Country::with('continent')->with('currency')->orderBy('asciiname')->get()->keyBy('code');
        if (is_null($countries)) {
            return collect([]);
        }
        
        // Country filters
        $tab = [];
        foreach ($countries as $code => $country) {
            // Get only Countries with currency
            if (isset($country->currency) and count($country->currency) > 0) {
                $tab[$code] = collect($country)->forget('currency_code');
            } else {
                // Just for debug
                // dd(collect($item));
            }
            
            // Get only allowed Countries with active Continent
            if (!isset($country->continent) or $country->continent->active != 1) {
                unset($tab[$code]);
            }
        }
        $countries = collect($tab);
        
        return $countries;
    }
    
    /**
     * @param $country_code
     * @param $countries
     * @return bool
     */
    public function isAvailableCountry($country_code)
    {
        if (!is_string($country_code) or strlen($country_code) != 2) {
            return false;
        }
        
        $countries = self::getCountries();
        $available_country_codes = is_array($countries) ? collect(array_keys($countries)) : $countries->keys();
        $available_country_codes = $available_country_codes->map(function ($item, $key) {
            return strtolower($item);
        })->flip();
        if ($available_country_codes->has(strtolower($country_code))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get User IP address
     * @param string $default_ip
     * @return string
     *
     * E.g. '197.234.219.43' (BJ) - '5.135.32.116' (FR) => For debug | @todo: remove debug value.
     */
    public function getIp($default_ip = '')
    {
        $ip = '';
        
        foreach (array(
                     'HTTP_CLIENT_IP',
                     'HTTP_X_FORWARDED_FOR',
                     'HTTP_X_FORWARDED',
                     'HTTP_X_CLUSTER_CLIENT_IP',
                     'HTTP_FORWARDED_FOR',
                     'HTTP_FORWARDED',
                     'REMOTE_ADDR'
                 ) as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $item) {
                    if (filter_var($item, FILTER_VALIDATE_IP) && substr($item, 0, 4) != '127.' && $item != '::1' && $item != '' && !in_array($item,
                            array('255.255.255.0', '255.255.255.255'))
                    ) {
                        $ip = $item;
                        break;
                    }
                }
            }
        }
        
        return ($ip) ? $ip : $default_ip;
    }

    /**
     * Get host (domain with sub-domains)
     *
     * @return mixed
     */
    public function getHost()
    {
        $host = (trim(Request::server('HTTP_HOST')) != '') ? Request::server('HTTP_HOST') : $_SERVER['HTTP_HOST'];

        if ($host == '') {
            $parsed_url = parse_url(url()->current());
            if (!isset($parsed_url['host'])) {
                $host = $parsed_url['host'];
            }
        }

        return $host;
    }
    
    /**
     * Get domain without any sub-domains
     * @return string
     */
    public function getDomain()
    {
        $host = $this->getHost();
        $tmp = explode('.', $host);
        $tmp = array_reverse($tmp);

        if (isset($tmp[1]) and isset($tmp[0])) {
            $domain = $tmp[1] . '.' . $tmp[0];
        } else if (isset($tmp[0])) {
            $domain = $tmp[0];
        } else {
            $domain = $host;
        }

        return $domain;
    }

    /**
     * @return string
     */
    public function getSubDomainName()
    {
        $host = $this->getHost();
        $name = (substr_count($host, '.') > 1) ? trim(current(explode('.', $host))) : '';

        return $name;
    }

    /**
     * @return string
     */
    public function getScheme()
    {
        if ((isset($_SERVER['HTTPS']) and ($_SERVER['HTTPS'] == 'on' or $_SERVER['HTTPS'] == 1)) or (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) and $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') or (stripos($_SERVER['SERVER_PROTOCOL'],
                    'https') === true)
        ) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        
        return $protocol;
    }
    
    /**
     * Share vars in the Views
     */
    public function varsToViews()
    {
        View::share('user', $this->user);
        View::share('countries', $this->countries);
        View::share('country', $this->country);
        View::share('ip_country', $this->ip_country);
        if (isset($this->site_country_info) and $this->site_country_info != '') {
            View::share('site_country_info', $this->site_country_info);
        }
    }
    
    /**
     * Check if User is logged
     *
     * @return bool
     */
    public function checkUser()
    {
        if (Auth::check()) {
            $this->user = Auth::user();
            View::share('user', $this->user);
            $this->userLevel = 'user';
            
            return $this->user;
        }
        
        return false;
    }
}
