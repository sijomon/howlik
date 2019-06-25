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

use Larapen\CountryLocalization\Models\Language;
use Larapen\CountryLocalization\Helpers\Country as CountryHelper;
use Larapen\CountryLocalization\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

class LanguageLocalization
{
    protected $country;
    
    public function __construct()
    {
        $this->app = app();
        
        $this->configRepository = $this->app['config'];
        $this->view = $this->app['view'];
        $this->translator = $this->app['translator'];
        $this->router = $this->app['router'];
        $this->request = $this->app['request'];
        
        // set default locale
        $this->defaultLocale = $this->configRepository->get('app.locale');
    }
    
    /**
     * @param array $country
     * @return Collection|static
     */
    public function findLang()
    {
        // Detect Language
        return $this->fromUrl();
    }
    
    /**
     * @return LanguageLocalization|Collection
     */
    public function fromUrl()
    {
        $lang_code = $hreflang = Request::segment(1);
        
        if ($lang_code != '') {
            $is_available_lang = collect(Language::where('abbr', $lang_code)->first());
            if (!$is_available_lang->isEmpty()) {
                $lang = $is_available_lang->merge(collect(['hreflang' => $hreflang]));
            } else {
                $lang = $this->fromBrowser();
            }
        } else {
            $lang = $this->fromBrowser();
        }
        
        return $lang;
    }
    
    /**
     * @return LanguageLocalization|Collection
     */
    public function fromBrowser()
    {
        // Get browser language
        $accept_language = Request::server('HTTP_ACCEPT_LANGUAGE');
        $lang_code = substr($accept_language, 0, 2);
        $hreflang = strstr($accept_language, ',', true);
        if ($lang_code != '') {
            $is_available_lang = collect(Language::where('abbr', $lang_code)->first());
            if (!$is_available_lang->isEmpty()) {
                $lang = $is_available_lang->merge(collect(['hreflang' => $hreflang]));
            } else {
                $lang = $this->fromConfig();
            }
        } else {
            $lang = $this->fromConfig();
        }
        
        return $lang;
    }
    
    /**
     * @return mixed
     */
    public function fromConfig()
    {
        // Default language
        $lang_code = $hreflang = config('app.locale');
        $lang = collect(Language::find($lang_code))->merge(collect(['hreflang' => $hreflang]));
        
        return $lang;
    }
    
    
    public static function supportedLanguage()
    {
        $languages = Language::where('active', 1)->get();
        
        return collect($languages);
    }
    
    public function countries($countries, $locale = 'en', $source = 'cldr')
    {
        // Security
        if (!$countries instanceof Collection) {
            return collect([]);
        }
        
        //$locale = 'en'; // debug
        $country_lang = new CountryHelper();
        $tab = [];
        foreach ($countries as $code => $country) {
            $tab[$code] = $country;
            if ($name = $country_lang->get($code, $locale, $source)) {
                $tab[$code]['name'] = $name;
            }
        }
        
        //return collect($tab);
        return collect($tab)->sortBy('name');
    }
    
    public function country($country, $locale = 'en', $source = 'cldr')
    {
        // Security
        if (!$country instanceof Collection) {
            return collect([]);
        }
        
        //$locale = 'en'; // debug
        $country_lang = new CountryHelper();
        if ($name = $country_lang->get($country->get('code'), $locale, $source)) {
            return $country->merge(['name' => $name]);
        } else {
            return $country;
        }
    }
    
    /**
     * @param $country_code
     * @return bool|\stdClass
     */
    public function getCountryInfo($country_code)
    {
        if (trim($country_code) == '') {
            return collect([]);
        }
        $country_code = strtoupper($country_code);
        
        $country = Country::find($country_code)->toArray();
        if (count($country) == 0) {
            return collect([]);
        }
        
        $country = collect($country);
        
        return $country;
    }
}
