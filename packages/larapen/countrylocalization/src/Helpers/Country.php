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

namespace Larapen\CountryLocalization\Helpers;

use Illuminate\Support\Collection;

class Country
{
    /**
     * The URL of the country list package (default package is umpirsky/country-list)
     *
     * @var   string
     */
    protected $data_dir;
    
    /**
     * @var array
     * Available data sources.
     */
    protected $data_sources = array('icu', 'icu');
    
    /**
     * The name of the country list file
     *
     * @var   string
     */
    protected $filename = 'country.php';
    
    /**
     * Variable holding the country list
     *
     * @var   array
     */
    protected $countries_list = array();
    
    public function __construct($data_dir = null)
    {
        if (isset($data_dir)) {
            if (!is_dir($data_dir)) {
                die(sprintf('Unable to locate the country data directory at "%s"', $data_dir));
            }
            $this->data_dir = $data_dir;
        } else {
            $this->data_dir = base_path() . '/database/umpirsky/country';
        }
    }
    
    /**
     * Returns one country.
     *
     * @param string $country_code The country
     * @param string $locale The locale (default: en)
     * @param string $source Data source: "icu" or "cldr"
     * @return string
     * @throws CountryNotFoundException  If the country code doesn't match any country.
     */
    public function get($country_code, $locale = 'en', $source = 'icu')
    {
        $country_code = mb_strtoupper($country_code);
        
        if (!$this->has($country_code, $locale, $source)) {
            return false;
        }
        
        return $this->countries_list[mb_strtoupper($country_code)];
    }
    
    /**
     * Returns a list of countries.
     *
     * @param string $locale The locale (default: en)
     * @param string $format The format (default: php)
     * @param string $source Data source: "icu" or "cldr"
     * @return array
     */
    public function all($locale = 'en', $format = 'php', $source = 'icu')
    {
        return $this->loadData($locale, mb_strtolower($source), $format);
    }
    
    /**
     * This function is used as a quick way for
     * the user to return an array with countries
     * and their corresponding ISO codes in a
     * specific language.
     *
     * @param   string $lang The language for with to fetch the country list
     * @return  array   Contains the countries and their corresponding ISO codes in the chosen language
     */
    public function loadData($locale = 'en', $source = 'icu', $format = 'php')
    {
        if (!in_array($source, $this->data_sources)) {
            return false;
        }
        
        $file = $this->data_dir . '/' . $source . '/' . $locale . '/' . $this->filename;
        if (!file_exists($file)) {
            return false;
        }
        $this->countries_list = ($format == 'php') ? require($file) : file_get_contents($file);
        if (!is_array($this->countries_list)) {
            return false;
        }
        
        return $this->sortData($locale, $this->countries_list);
    }
    
    /**
     * Sorts the data array for a given locale, using the locale translations.
     * It is UTF-8 aware if the Collator class is available (requires the intl
     * extension).
     *
     * @param string $locale The locale whose collation rules should be used.
     * @param array $data Array of strings to sort.
     * @return array          The $data array, sorted.
     */
    protected function sortData($locale, $data)
    {
        if (is_array($data)) {
            if (class_exists('Collator')) {
                $collator = new \Collator($locale);
                $collator->asort($data);
            } else {
                asort($data);
            }
        }
        
        return $data;
    }
    
    /**
     * Indicates whether or not a given $country_code matches a country.
     *
     * @param string $country_code A 2-letter country code
     * @param string $locale The locale (default: en)
     * @param string $source Data source: "icu" or "cldr"
     * @return bool                <code>true</code> if a match was found, <code>false</code> otherwise
     */
    public function has($country_code, $locale = 'en', $source = 'icu')
    {
        $countries = $this->all($locale, 'php', mb_strtolower($source));
        if (!$countries) {
            return false;
        }
        $checker = isset($countries[mb_strtoupper($country_code)]);
        
        return $checker;
    }
    
    
    /**
     * @param Collection $countries
     * @param string $locale
     * @param string $source
     * @return static
     */
    public static function transAll($countries, $locale = 'en', $source = 'icu')
    {
        // Security
        if (!$countries instanceof Collection) {
            return collect([]);
        }
        
        // Load translated file
        $country_lang = new Country();
        
        $tab = [];
        foreach ($countries as $code => $country) {
            $tab[$code] = $country;
            if ($name = $country_lang->get($code, $locale, $source)) {
                $tab[$code]['name'] = $name;
            }
        }
        
        return collect($tab)->sortBy('name');
        
        /*
        // Get translated countries
        $loaded_countries = $country_lang->all($locale);

        // Check countries array
        if (count($loaded_countries) <= 0) return collect([]);

        foreach ($loaded_countries as $code => $name)
        {
            if ($countries->has($code))
            {
                $country 	= $countries->get($code)->merge(['name' => $name]);
                $countries 	= $countries->merge([$code => $country]);
            }
        }
        return $countries->sortBy('name');
        */
    }
    
    /**
     * @param Collection $country
     * @param string $locale
     * @param string $source
     * @return Collection|static
     */
    public static function trans($country, $locale = 'en', $source = 'icu')
    {
        // Security
        if (!$country instanceof Collection) {
            return collect([]);
        }
        
        //$locale = 'en'; // debug
        $country_lang = new Country();
        if ($name = $country_lang->get($country->get('code'), $locale, $source)) {
            return $country->merge(['name' => $name]);
        } else {
            return $country;
        }
    }
}
