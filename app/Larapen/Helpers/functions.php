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

/**
 * Default translator (e.g. en/global.php)
 *
 * @param $string
 * @return string
 */
 
use App\Larapen\Models\GoogleSearchModel;
use App\Larapen\Models\GoogleSearchIdsModel;
use App\Larapen\Models\City;
use App\Larapen\Models\SubAdmin1;
use App\Larapen\Models\Country;
use App\Larapen\Models\Category;
use App\Larapen\Models\Business;
use App\Larapen\Models\BusinessLocation;
use App\Larapen\Models\BusinessImage;
use App\Larapen\Models\Review;
use App\Larapen\Models\CategoryGoogleTypeModel;
use App\Larapen\Helpers\Ip;

function t($string, $params = [], $file = 'global', $locale = null)
{
    if (is_null($locale)) {
        $locale = config('app.locale');
        if (\Illuminate\Support\Facades\Session::has('language_code')) {
            $locale = session('language_code');
        }
    }

    return trans($file . '.' . $string, $params, null, $locale);
}

/**
 * Get URL query parameters
 *
 * @param array $except
 * @return string
 */
function query_params($except = [])
{
    $query = \Illuminate\Support\Facades\Input::query();
    
    if (!is_array($except)) {
        $except = [$except];
    }
    
    foreach ($except as $key => $value) {
        if (is_string($key)) {
            $query[$key] = $value;
        } else {
            unset($query[$value]);
        }
    }
    
    return (http_build_query($query));
}

/**
 * Get default max file upload size (from PHP.ini)
 *
 * @return mixed
 */
function maxUploadSize()
{
    $max_upload = (int)(ini_get('upload_max_filesize'));
    $max_post = (int)(ini_get('post_max_size'));
    
    return min($max_upload, $max_post);
}

/**
 * Get max file upload size
 *
 * @return int|mixed
 */
function maxApplyFileUploadSize()
{
    $size = maxUploadSize();
    if ($size >= 5) {
        return 5;
    }
    
    return $size;
}

/**
 * Check if is an AJAX request
 *
 * exemple:
 * if ( is_ajax() )
 * {
 *        $out = $this->template->load($templates, $page, $data, true);
 *        echo json_encode( array('out' => $out) );
 * }
 * else
 *        $this->template->load($templates, $page, $data);
 */
function is_ajax()
{
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
}

/**
 * Escape JSON string
 *
 * Escape this:
 * \b  Backspace (ascii code 08)
 * \f  Form feed (ascii code 0C)
 * \n  New line
 * \r  Carriage return
 * \t  Tab
 * \"  Double quote
 * \\  Backslash caracter
 *
 * @param $value
 * @return mixed
 */
function escape_json_string($value)
{
    # list from www.json.org: (\b backspace, \f formfeed)
    $escapers = array("\\", "/", "\"", "\n", "\r", "\t", "\x08", "\x0c");
    $replacements = array("\\\\", "\\/", "\\\"", "\\n", "\\r", "\\t", "\\f", "\\b");
    $result = str_replace($escapers, $replacements, trim($value));
    
    return $result;
}

/**
 * Get host (domain with sub-domains)
 *
 * @return string
 */
function getHost()
{
    $host = (trim(\Illuminate\Support\Facades\Request::server('HTTP_HOST')) != '') ? \Illuminate\Support\Facades\Request::server('HTTP_HOST') : $_SERVER['HTTP_HOST'];

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
 *
 * @return string
 */
function getDomain()
{
    $host = getHost();
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
 * Get sub-domain name
 *
 * @return string
 */
function getSubDomainName()
{
    $host = getHost();
    $name = (substr_count($host, '.') > 1) ? trim(current(explode('.', $host))) : '';
    
    return $name;
}

/**
 * Generate a querystring url for the application.
 *
 * Assumes that you want a URL with a querystring rather than route params
 * (which is what the default url() helper does)
 *
 * @param  string $path
 * @param  mixed $qs
 * @param  bool $secure
 * @return string
 */
function qsurl($path = null, $qs = array(), $secure = null)
{
    $url = app('url')->to($path, $secure);
    if (count($qs)) {
        foreach ($qs as $key => $value) {
            $qs[$key] = sprintf('%s=%s', $key, urlencode($value));
        }
        $url = sprintf('%s?%s', $url, implode('&', $qs));
    }
    
    return $url;
}

/**
 * Get URL (via domain & sub-domain)
 *
 * @param null $path
 * @param null $secure
 * @return mixed
 */
function durl($path = null, $secure = null)
{
    $url = app('url')->to($path, $secure);
    //$url = preg_replace('|([A-Z]{' . strlen(getSubDomainName()) . '}\.' . getDomain() . ')+|i', 'www.' . getDomain(), $url, 1);
    
    return $url;
}

/**
 * Localized URL
 *
 * @param null $path
 * @return mixed
 */
function lurl($path = null)
{
	$locale = \Illuminate\Support\Facades\Request::segment(1);
	if (is_null($locale) || !is_available_lang($locale)) {
        $locale = config('app.locale');
        if (\Illuminate\Support\Facades\Session::has('language_code')) {
            $locale = session('language_code');
        }
    }
    return \Larapen\LaravelLocalization\Facades\LaravelLocalization::getLocalizedURL($locale, $path);
}

/**
 * Non localized URL
 *
 * @param null $path
 * @return mixed
 */
function nolurl($path = null)
{
    return \Larapen\LaravelLocalization\Facades\LaravelLocalization::getNonLocalizedURL($path);
}

/**
 * Format file size
 *
 * @param $bytes
 * @return string
 */
function size_format($bytes)
{
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    
    return $bytes;
}

/**
 * Format file size (2)
 *
 * @param $size
 * @return string
 */
function file_size($size)
{
    $file_size_name = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    
    return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $file_size_name[$i] : '0 Bytes';
}

/**
 * Time ago for human view
 *
 * @param \Carbon\Carbon $dt
 * @param $timeZone
 * @param string $lang_code
 * @return string
 */
function time_ago(\Carbon\Carbon $dt, $time_zone, $lang_code = 'en')
{
    $sec = $dt->diffInSeconds(\Carbon\Carbon::now($time_zone));
    \Carbon\Carbon::setLocale($lang_code);
    $string = mb_ucfirst(\Carbon\Carbon::now($time_zone)->subSeconds($sec)->diffForHumans());

    return $string;
}

/**
 * Get Ad ID from URL
 *
 * @param $segment
 * @return mixed|null
 */
function getAdId($segment)
{
    $segment = strip_tags($segment);
    $tmp = explode('-', $segment);
    $last = explode('.', end($tmp));
    $id = current($last);
    
    if (is_numeric($id)) {
        return $id;
    } else {
        return null;
    }
}

/**
 * Get file extension
 *
 * @param $filename
 * @return mixed
 */
function getExtension($filename)
{
    $tmp = explode('?', $filename);
    $tmp = explode('.', current($tmp));
    $ext = end($tmp);
    
    return $ext;
}

/**
 * Get URL Scheme
 *
 * @return string
 */
function getScheme()
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
 * String strip
 *
 * @param $string
 * @return string
 */
function str_strip($string)
{
    $string = trim(preg_replace('/\s\s+/u', ' ', $string));
    
    return $string;
}

/**
 * String cleaner
 *
 * @param $string
 * @return mixed|string
 */
function str_clean($string)
{
    $string = strip_tags($string, '<br><br/>');
    $string = str_replace(array('<br>', '<br/>', '<br />'), "\n", $string);
    $string = preg_replace("/[\r\n]+/", "\n", $string);
    /*
    Remove 4(+)-byte characters from a UTF-8 string
    It seems like MySQL does not support characters with more than 3 bytes in its default UTF-8 charset.
    NOTE: you should not just strip, but replace with replacement character U+FFFD to avoid unicode attacks, mostly XSS:
    http://unicode.org/reports/tr36/#Deletion_of_Noncharacters
    */
    $string = preg_replace('/[\x{10000}-\x{10FFFF}]/u', '', $string);
    $string = mb_ucfirst(trim($string));
    
    return $string;
}

/**
 * Fixed: MySQL don't accept the comma format number
 *
 * @param $float
 * @param int $decimals
 * @return mixed
 *
 * @todo: Learn why PHP 5.6.6 changes dot to comma in float vars
 */
function fixFloatVar($float, $decimals = 10)
{
    //$float = number_format($float, $decimals, '.', ''); // Best way !
    //$float = rtrim($float, "0");
    
    if (strpos($float, ',') !== false) {
        $float = str_replace(',', '.', $float);
    }
    
    return $float;
}

/**
 * Extract emails from string
 *
 * @param $string
 * @return string
 */
function extract_email_address($string)
{
    $tmp = [];
    preg_match_all('|([A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b)|i', $string, $tmp);
    $emails = (isset($tmp[1])) ? $tmp[1] : [];
    $email = head($emails);
    if ($email == '') {
        $tmp = [];
        preg_match("|[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})|i", $string, $tmp);
        $email = (isset($tmp[0])) ? trim($tmp[0]) : '';
        if ($email == '') {
            $tmp = [];
            preg_match("|[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b|i", $string, $tmp);
            $email = (isset($tmp[0])) ? trim($tmp[0]) : '';
        }
    }
    
    return strtolower($email);
}

/**
 * Check if language code is available
 *
 * @param $lang_code
 * @return bool
 */
function is_available_lang($lang_code)
{
    $is_available_lang = collect(\App\Larapen\Models\Language::where('abbr', $lang_code)->first());
    if (!$is_available_lang->isEmpty()) {
        return true;
    } else {
        return false;
    }
}

/**
 * Auto-link URL in string
 *
 * @param $str
 * @param array $attributes
 * @return mixed|string
 */
function auto_link($str, $attributes = array())
{
    $attrs = '';
    foreach ($attributes as $attribute => $value) {
        $attrs .= " {$attribute}=\"{$value}\"";
    }
    
    $str = ' ' . $str;
    $str = preg_replace('`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i', '$1<a rel="nofollow" href="$2"' . $attrs . ' target="_blank">$2</a>',
        $str);
    $str = substr($str, 1);
    
    return $str;
}

/**
 * Check tld is a valid tld
 *
 * @param $url
 * @return bool|int
 */
function check_tld($url)
{
    $parsed_url = parse_url($url);
    if ($parsed_url === false) {
        return false;
    }
    
    $tlds = config('tlds');
    $patten = implode('|', array_keys($tlds));
    
    return preg_match('/\.(' . $patten . ')$/i', $parsed_url['host']);
}

/**
 * Get Facebook Page Fans number
 *
 * @param $page_id
 * @return int
 */
function countFacebookFans($page_id)
{
    $count = 0;
    if (config('settings.facebook_page_fans')) {
        $count = (int) config('settings.facebook_page_fans');
    } else {
        $jsonUrl = 'http://api.facebook.com/method/fql.query?format=json&query=select+fan_count+from+page+where+page_id%3D' . $page_id;
        try {
            // Get content
            $json = file_get_contents($jsonUrl);
            $obj = json_decode($json);

            /*
             * Extract the likes count from the JSON object
             * NOTE: Limit the number of requests:
             * https://developers.facebook.com/docs/marketing-api/api-rate-limiting
             */
            if (!isset($obj->error_code) and isset($obj[0])) {
                if (isset($obj[0]->fan_count) and is_numeric($obj[0]->fan_count)) {
                    $count = $obj[0]->fan_count;
                }
            }
        } catch (\Exception $e) {
            $count = (int) config('settings.facebook_page_fans');
        }
    }
    
    return $count;
}

/**
 * Function to convert hex value to rgb array
 * @param $colour
 * @return array|bool
 *
 * @todo: improve this function
 */
function hex2rgb($colour)
{
    if ($colour[0] == '#') {
        $colour = substr($colour, 1);
    }
    if (strlen($colour) == 6) {
        list($r, $g, $b) = array($colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5]);
    } elseif (strlen($colour) == 3) {
        list($r, $g, $b) = array($colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2]);
    } else {
        return false;
    }
    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);
    
    return array('r' => $r, 'g' => $g, 'b' => $b);
}

/**
 * Convert hexdec color string to rgb(a) string
 *
 * @param $color
 * @param bool $opacity
 * @return string
 *
 * @todo: improve this function
 */
function hex2rgba($color, $opacity = false)
{
    $default = 'rgb(0,0,0)';
    
    //Return default if no color provided
    if (empty($color)) {
        return $default;
    }
    
    //Sanitize $color if "#" is provided
    if ($color[0] == '#') {
        $color = substr($color, 1);
    }
    
    //Check if color has 6 or 3 characters and get values
    if (strlen($color) == 6) {
        $hex = array($color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]);
    } elseif (strlen($color) == 3) {
        $hex = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    } else {
        return $default;
    }
    
    //Convert hexadec to rgb
    $rgb = array_map('hexdec', $hex);
    
    //Check if opacity is set(rgba or rgb)
    if ($opacity) {
        if (abs($opacity) > 1) {
            $opacity = 1.0;
        }
        $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
    } else {
        $output = 'rgb(' . implode(",", $rgb) . ')';
    }
    
    // Return rgb(a) color string
    return $output;
}

/**
 * ucfirst() function for multibyte character encodings
 *
 * @param $string
 * @param string $encoding
 * @return string
 */
function mb_ucfirst($string, $encoding = 'utf-8')
{
    $strlen = mb_strlen($string, $encoding);
    $first_char = mb_substr($string, 0, 1, $encoding);
    $then = mb_substr($string, 1, $strlen - 1, $encoding);
    
    return mb_strtoupper($first_char, $encoding) . $then;
}

/**
 * UTF-8 aware parse_url() replacement
 *
 * @param $url
 * @return mixed
 */
function mb_parse_url($url)
{
    $enc_url = preg_replace_callback('%[^:/@?&=#]+%usD', function ($matches) {
        return urlencode($matches[0]);
    }, $url);
    
    $parts = parse_url($enc_url);
    
    if ($parts === false) {
        throw new \InvalidArgumentException('Malformed URL: ' . $url);
    }
    
    foreach ($parts as $name => $value) {
        $parts[$name] = urldecode($value);
    }
    
    return $parts;
}

/**
 * Friendly UTF-8 URL for all languages
 *
 * @param $string
 * @param string $separator
 * @return mixed|string
 */
function slugify($string, $separator = '-')
{
    // Remove accents
    $string = remove_accents($string);
    
    // Slug
    $string = mb_strtolower($string);
    $string = @trim($string);
    $replace = "/(\\s|\\" . $separator . ")+/mu";
    $subst = $separator;
    $string = preg_replace($replace, $subst, $string);
    
    // Remove unwanted punctuation, convert some to '-'
    $punc_table = array(
        // remove
        "'" => '',
        '"' => '',
        '`' => '',
        '=' => '',
        '+' => '',
        '*' => '',
        '&' => '',
        '^' => '',
        '' => '',
        '%' => '',
        '$' => '',
        '#' => '',
        '@' => '',
        '!' => '',
        '<' => '',
        '>' => '',
        '?' => '',
        // convert to minus
        '[' => '-',
        ']' => '-',
        '{' => '-',
        '}' => '-',
        '(' => '-',
        ')' => '-',
        ' ' => '-',
        ',' => '-',
        ';' => '-',
        ':' => '-',
        '/' => '-',
        '|' => '-'
    );
    $string = str_replace(array_keys($punc_table), array_values($punc_table), $string);
    
    // Clean up multiple '-' characters
    $string = preg_replace('/-{2,}/', '-', $string);
    
    // Remove trailing '-' character if string not just '-'
    if ($string != '-') {
        $string = rtrim($string, '-');
    }
    
    //$string = rawurlencode($string);
    
    return $string;
}

/**
 * @return mixed|string
 */
function get_locale()
{
    $lang = get_lang();
    $locale = (isset($lang) and !$lang->isEmpty()) ? $lang->get('locale') : 'en_US';
    
    return $locale;
}

/**
 * @return \Illuminate\Support\Collection|static
 */
function get_lang()
{
    $obj = new \Larapen\CountryLocalization\LanguageLocalization();
    $lang = $obj->findLang();
    
    return $lang;
}

function getRandWord($nos=12) {
	$randno = "";
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for($i=0;$i<$nos;$i++) {
		$num = rand(0,9);
		if(rand(0,9)<$num)	$randno .= substr(str_shuffle($str),0,1); 
		else $randno .= rand(0,9);
	} // end for
	return $randno;
} // end function

function curl_fetch($Url, $refUrl=''){
	if (!function_exists('curl_init')){die('Sorry cURL is not installed!');}
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $Url);
	if($refUrl!=''){
		curl_setopt($ch, CURLOPT_REFERER, $refUrl);
	}
	curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:2.0) Gecko/20100101 Firefox/4.0");
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	$output = curl_exec($ch);
	curl_close($ch);
	return $output;
}

function get_cat_from_key($keyA){
	if(is_array($keyA) && count($keyA)>0){
		$cat = Category::whereIn('name', $keyA)->where('parent_id','>',0)->where('active', 1)->first();
		if(isset($cat->parent_id) && $cat->parent_id>0){
			$catA = Category::where('id', $cat->parent_id)->where('parent_id',0)->where('active', 1)->first();
			if(isset($catA->translation_of)){
				if($catA->translation_of>0){
					return $catA->translation_of;
				}else{
					return $catA->id;
				}
			}
		}
	}
	return 0;
}

function get_google_key(){
	return 'AIzaSyC-7PxJuZIVZMQOteUn24i8wylaFyn6OEA';
}

function google_img($ref){
	$gKey = get_google_key();
	$imgUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=100&key='.$gKey.'&photoreference='.urlencode(trim($ref));
	return $imgUrl;
}

function exclude_keywords(){
	return array('point_of_interest', 'establishment');
}

function googlefetch($data){
	$page = 1;
	if(isset($data['page']) && $data['page']>1){
		$page = $data['page'];
	}
	$where = '';
	$cat = '';
	if(isset($data['cat']) && trim($data['cat'])!=''){
		$cat = trim($data['cat']);
		//$where .= " AND cat='".$cat."'";
	}
	$cat_id = '';
	if(isset($data['cat_id']) && $data['cat_id']>0){
		$cat_id = $data['cat_id'];
		$where .= " AND cat='".$cat_id."'";
	}
	$keyword = '';
	if(isset($data['keyword']) && trim($data['keyword'])!=''){
		$keyword = trim($data['keyword']);
		$where .= " AND keyword='".addslashes($keyword)."'";
	}
	$lat = '0';
	if(isset($data['lat']) && trim($data['lat'])!=''){
		$lat = trim($data['lat']);
	}
	$lng = '0';
	if(isset($data['lng']) && trim($data['lng'])!=''){
		$lng = trim($data['lng']);
	}
	$c_code = '';
	if(isset($data['c_code']) && trim($data['c_code'])!=''){
		$c_code = trim($data['c_code']);
	}
	$fImg = 'no';
	if(isset($data['img']) && trim($data['img'])=='yes'){
		$fImg = 'yes';
	}
	$type = '';
	if(isset($data['type']) && trim($data['type'])!=''){
		$type = trim($data['type']);
		$where .= " AND gtype='".addslashes($type)."'";
	}
	$searchId = 0;
	
	//$googleRes = GoogleSearchModel::where('page', $page)->where('keyword', $keyword)->first();
	$googleRes = \DB::select("SELECT id, (
									3959 * acos (
									  cos ( radians(".$lat.") )
									  * cos( radians( lat ) )
									  * cos( radians( lon ) - radians(".$lng.") )
									  + sin ( radians(".$lat.") )
									  * sin( radians( lat ) )
									)
								  ) AS distance 
								  FROM businessGoogleSearch 
								  WHERE id>0 ".$where."
								  HAVING distance < 1 ORDER BY distance LIMIT 1");
	if(count($googleRes)>0){
		$searchId = $googleRes[0]->id;
		if($cat_id>0){
			/*$biz = \DB::select("UPDATE business b SET b.category_id = '".$cat_id."' WHERE b.id IN (SELECT b2.id						  
								  FROM businessGoogleSearchIds bs, business b2 
								  WHERE bs.googleId=b2.googleId AND bs.searchId='".$searchId."')");
			\DB::select("UPDATE business b, businessGoogleSearchIds bs SET b.category_id = '".$cat_id."' WHERE bs.googleId=b.googleId AND bs.searchId='".$searchId."'");
			*/					  					  
		}
	}else{
		$googleResA = new GoogleSearchModel();
		$googleResA->lat 	 = $lat;
		$googleResA->lon 	 = $lng;
		$googleResA->cat 	 = $cat_id;
		$googleResA->countryCode = $c_code;
		$googleResA->keyword = $keyword;
		$googleResA->gtype = $type;
		$googleResA->save();
		$searchId = $googleResA->id;
		
		$gKey = get_google_key();
		$urlBase = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key='.$gKey;
		$url = $urlBase.'&radius=5000&location='.urlencode($lat.' '.$lng);
		/*if($cat_id>0){
			$gTypes = CategoryGoogleTypeModel::where('category_id', $cat_id)->get();
			if(count($gTypes)>0){
				$tvalueA = array();
				foreach($gTypes as $tkey => $tvalue){
					$tvalueA[] =  $tvalue->google_type;
				}
				//$url .= '&type='. urlencode(implode(',', $tvalueA));
				if($keyword==''){
					$keyword = implode(',', $tvalueA); //Removed because less results are showing 17/05/2019
				}
			}
		}Removed because new code in caller section. */
		if($keyword!=''){
			$url .= '&keyword='. urlencode($keyword);
		}elseif($type!=''){
			$url .= '&type='. urlencode($type);
		}
		
		$tExp = exclude_keywords();
		
		$googleResA->url = $url;
		$googleResA->save();
		
		$i = 0;
		do{
			$i = 1;
			
			$result = curl_fetch($url);
			$resA = json_decode($result);
			/*echo "<pre>";
			print_r($resA);
			exit;*/
			//BOF If result is < 5 then fetch with in 10 KM
			if(isset($resA->results) && count($resA->results)<=5){
				$url = str_replace('radius=5000', 'radius=10000', $url);
				$result = curl_fetch($url);
				$resA = json_decode($result);
				$googleResA->url = $url;
				$googleResA->save();
			}
			//EOF If result is < 5 then fetch with in 10 KM
			
			if(isset($resA->results) && count($resA->results)>0){
				foreach($resA->results as $key => $value){
					////////////////////
					$description = '';
					$google_keywords = '';
					if(isset($value->types) && is_array($value->types) && isset($value->types[0])){
						$typesArray = array_map('strtolower', $value->types);
						$typeA = array_filter(array_diff( $typesArray, $tExp ));
						if(count($typeA)>0){
							$google_keywords = ','.implode(',',$typeA).',';
						}
						if(isset($typeA[0])){
							$description = ucfirst(trim($typeA[0]));
						}
					}
					$gKeywords = array_filter(array_unique(explode(',', $google_keywords)));
					if(trim($keyword)!=''){
						$gKeywords[] = trim($keyword);
					}
					if(is_array($gKeywords) && count($gKeywords)>0){
						$google_keywords = ','.implode(',',$gKeywords).',';
						if(!($cat_id>0)){
							$cat_id = get_cat_from_key($gKeywords);
						}
					}
					////////////////////
					$googleId = trim($value->place_id);
					$business = Business::where('googleId', $googleId)->first();
					if(isset($business->id) && $business->id>0){
						if($cat_id>0 && $business->category_id==0){
							$business->category_id = $cat_id;
						}
						$google_keywords .= $business->keywordsgoogle;
						$keywordsgoogleA = array_filter(array_unique(explode(',', $google_keywords)));
						$business->keywordsgoogle = ','.implode(',',$keywordsgoogleA).',';
						$business->save();
					}else{
						//SELECT COUNT(id) as cid, googleId FROM `business` GROUP BY googleId ORDER BY cid DESC
						$name = trim($value->name);
						$address = trim($value->vicinity);
						$lat = 0;
						if(isset($value->geometry->location->lat) && trim($value->geometry->location->lat)!=''){
							$lat = trim($value->geometry->location->lat);
						}
						$lng = 0;
						if(isset($value->geometry->location->lng) && trim($value->geometry->location->lng)!=''){
							$lng = trim($value->geometry->location->lng);
						}
						
						$city_id = '';
						$city = '';
						$subadmin1_code = '';
						$country_code = '';
						if(isset($value->plus_code->compound_code) && trim($value->plus_code->compound_code)!=''){
							$compound_code = trim($value->plus_code->compound_code);
							$compound_codeA = explode(' ', $compound_code);
							$compound_code = str_replace($compound_codeA[0], '', $compound_code);
							$compound_codeA = explode(',', $compound_code);
							$cKey = count($compound_codeA)-1;
							if(isset($compound_codeA[$cKey])){
								$country = trim($compound_codeA[$cKey]);
								$countryA = Country::where('asciiname', $country)->first();
								if(isset($countryA->code) && trim($countryA->code)!=''){
									$country_code = $countryA->code;
								}
							}
							if(isset($compound_codeA[0])){
								$city = trim($compound_codeA[0]);
								$cityM = City::where('asciiname', $city)->where('country_code', $country_code )->first();
								if(isset($cityM->id) && $cityM->id>0){
									$city_id = $cityM->id;
									$subadmin1_code = $cityM->subadmin1_code;
								}
							}
						}
						
						// BOF Fetch details if city is null
						if($city_id == ''){
							$jsonDet = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?placeid=".$googleId."&fields=address_component&key=$gKey");
							$bizData=json_decode($jsonDet);
							if(isset($bizData->result->address_components)){
								$pData['address'] = $bizData->result->address_components;
								$pData['lat'] = $lat;
								$pData['lng'] = $lng;
								$rData = addresstoarray($pData);
								//$address 		= $rData['address'];
								$city			= $rData['city'];
								$subadmin1 		= $rData['subadmin1'];
								if($rData['country_code']!='')
								$country_code 	= $rData['country_code'];
							} 
							
							if($city==''){
								$url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$gKey.'&language=en&latlng='.trim($lat).','.trim($lng).'&sensor=true';
								$jsonDet = @file_get_contents($url);
								$bizData=json_decode($jsonDet);
								if(isset($bizData->results[0]->address_components)){
									$pData['address'] = $bizData->results[0]->address_components;
									$pData['lat'] = $lat;
									$pData['lng'] = $lng;
									$rData = addresstoarray($pData);
									//$address 		= $rData['address'];
									$city			= $rData['city'];
									$subadmin1 		= $rData['subadmin1'];
									if($rData['country_code']!='')
									$country_code 	= $rData['country_code'];
								} 
							}
							
							if($city!=''){
								$cityM = City::where('asciiname', $city)->where('country_code', $country_code )->first();
								if(isset($cityM->id) && $cityM->id>0){
									$city_id = $cityM->id;
									$subadmin1_code = $cityM->subadmin1_code;
								}
							}
						}
						// EOF Fetch details if country code is null
						
						if($city_id == '' && isset($data['city_id']) && $data['city_id']>0){
							$city_id = $data['city_id'];
							$city = City::where('id', $data['city_id'])->first();
							if(isset($city->id) && $city->id>0){
								$city_id = $city->id;
								$subadmin1_code = $city->subadmin1_code;
								$country_code = $city->country_code;
							}
						}
						
						$subadmin1_code = str_replace($country_code.'.','',$subadmin1_code);//to make unique
						$subadmin1_code = $country_code.'.'.$subadmin1_code;
						
						/*$description = '';
						$google_keywords = '';
						if(isset($value->types) && is_array($value->types) && isset($value->types[0])){
							$typesArray = array_map('strtolower', $value->types);
							$typeA = array_filter(array_diff( $typesArray, $tExp ));
							if(count($typeA)>0){
								$google_keywords = ','.implode(',',$typeA).',';
							}
							if(isset($typeA[0])){
								$description = ucfirst(trim($typeA[0]));
							}
						}
						
						if(!($cat_id>0)){
							$gKey = array_filter(array_unique(explode(',', $google_keywords)));
							if(trim($keyword)!=''){
								$gKey[] = trim($keyword);
							}
							if(count($gKey)>0){
								$cat_id = get_cat_from_key($gKey);
							}
						}*/
						
						//'keywords' => $keywords,
						$business_info = array(
											'country_code' => $country_code,
											'googleId' => $googleId,
											'keywordsgoogle' => $google_keywords,
											'user_id' => 0,
											'category_id' => $cat_id,
											'title' => $name,
											'description' => $description,
											'title_ar' => $name,
											'description_ar' => $description,
											'address1' => $address,
											'city_id' => $city_id,
											'subadmin1_code' => $subadmin1_code,
											'lat' => $lat,
											'lon' => $lng,
											'ip_addr' => Ip::get(),
											'activation_token' => md5(uniqid()),
											'active' => 1,
										);
						$business = new Business($business_info);
						$business->save();
						
						// Save a reference of this Business to database table businessLocations
						$business_location = array(
							'biz_id' => $business->id,
							'address_1' => $address,
							'country_id' => $country_code,
							'location_id' => $subadmin1_code,
							'city_id' => $city_id,
							'lat' => $lat,
							'lon' => $lng,
							'active' => 1,
						);
						$locationTbl = new BusinessLocation($business_location);
						$locationTbl->save();
						
						$img = '';
						if($fImg=='yes'){
							if(isset($value->photos[0]->photo_reference)){
								if(is_array($value->photos[0]->photo_reference)){
									
								}elseif(trim($value->photos[0]->photo_reference)!=''){
									//$img = trim($value->photos[0]->photo_reference);
									$imgUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=200&key='.$gKey.'&photoreference='.urlencode(trim($value->photos[0]->photo_reference));
									$imgCnt = @file_get_contents($imgUrl);
									$destinationPath = 'uploads/pictures/business'; // upload path
									$extension = 'jpg'; // getting file extension
									$fileName = 'g'.$business->id . '.' . $extension;
									@file_put_contents(public_path().'/'.$destinationPath.'/'.$fileName, $imgCnt);
									$img = $destinationPath.'/'.$fileName;
								}
							}
						}
						
						if($img != ''){
							$picture = new BusinessImage(array(
								'biz_id'    => $business->id,
								'filename' => $img,
							));
							$picture->save();
						}
					}
					$googleIds = new GoogleSearchIdsModel();
					$googleIds->searchId 	= $googleResA->id;
					$googleIds->googleId 	= $business->googleId;
					$googleIds->lat 	 	= $business->lat;
					$googleIds->lon 		= $business->lon;
					$googleIds->save();
				} 
			}
		
			if(isset($resA->next_page_token) && trim($resA->next_page_token)!=''){
				//$i = 0; //Only fetching first page 
				$url = $urlBase.'&pagetoken='.urlencode(trim($resA->next_page_token));
			}
			
		}while($i < 1);
	}
	return $searchId;
}

function googlefetchdetails($biz_id, $gImg = 0){
	
	$timeNow = \Carbon\Carbon::now()->subHours(24);//server time
	$gKey = get_google_key();
	
	//echo "<pre>".$biz_id.$timeNow;
	$business = Business::where('id', $biz_id)->whereDate('google_update','<',$timeNow)->first();
	//print_r($business);
	if(isset($business->googleId) && trim($business->googleId)!=''){
		$googleId = trim($business->googleId);
		$gUrl = "https://maps.googleapis.com/maps/api/place/details/json?key=$gKey";
		$json = file_get_contents($gUrl."&placeid=".$googleId."&fields=photo,user_ratings_total,formatted_phone_number,opening_hours,website,rating,review,price_level");
		$json = json_decode($json);
		// BOF If Google Place Id Expired then refresh to get new place id.
		if(!(isset($json->status) && trim($json->status)=='OK')){
			$jsonP = file_get_contents($gUrl."&placeid=".$googleId."&fields=place_id");
			$jsonP = json_decode($jsonP);
			if(isset($jsonP->status) && trim($jsonP->status)=='OK'){
				if(isset($jsonP->result->place_id) && trim($jsonP->result->place_id)!=''){
					$business->googleId = trim($jsonP->result->place_id);
					$business->save();
					
					$googleId = trim($business->googleId);
					$json = file_get_contents($gUrl."&placeid=".$googleId."&fields=photo,user_ratings_total,formatted_phone_number,opening_hours,website,rating,review,price_level");
					$json = json_decode($json);
				}
			}
		}
		// EOF If Google Place Id Expired then refresh to get new place id.
		/*if(isset($json->result->address_components)){
			$pData['address'] = $json->result->address_components;
			$pData['lat'] = $business->lat;
			$pData['lng'] = $business->lon;
			$rData = addresstoarray($pData);
			//$address 		= $rData['address'];
			$city			= $rData['city'];
			$subadmin1 		= $rData['subadmin1'];
			if($rData['country_code']!='')
			$country_code 	= $rData['country_code'];
			
			if($city!=''){
				$cityM = City::where('asciiname', $city)->where('country_code', $country_code )->first();
				if(isset($cityM->id) && $cityM->id>0){
					$city_id = $cityM->id;
					$subadmin1_code = $cityM->subadmin1_code;
					
					$business->city_id = $city_id;
					$business->subadmin1_code = $subadmin1_code;
					$business->save();
				}
			}
		}*/
							
		if(isset($json->result->reviews) && is_array($json->result->reviews) && count($json->result->reviews)>0){
			$price_level = '';
			if(isset($json->result->price_level)){
				$price_level = trim($json->result->price_level);
			}
			foreach($json->result->reviews as $key => $review){
				$user_name = trim($review->author_name);
				$gtime = trim($review->time);
				$revMdl = Review::where('user_name', $user_name)->where('gtime', $gtime)->where('biz_id', $biz_id)->first();
				if(!(isset($revMdl->id) && $revMdl->id>0)){
					$revMdl = new Review();
					$revMdl->biz_id = $biz_id;
					$revMdl->user_name = $user_name;
					$revMdl->rating  = $review->rating;
					$revMdl->review  = $review->text;
					$revMdl->expense = $price_level;
					$revMdl->gtime   = $gtime;
					$revMdl->created_at  = date("Y-m-d H:i:s", $gtime);
					$revMdl->save();
				}
			}
		} 
		
		$bizHoursA = array();
		if(isset($json->result->opening_hours->periods) && is_array($json->result->opening_hours->periods) && count($json->result->opening_hours->periods)>0){
			$tA = array();
			$sortA = array();
			foreach($json->result->opening_hours->periods as $key => $opening_hours){
				if(isset($opening_hours->open->time) && isset($opening_hours->close->time)){
					$openH = ceil($opening_hours->open->time / 100);
					$openM = ($opening_hours->open->time % 100);
					$open  = sprintf('%02d', $openH).'.'.sprintf('%02d', $openM);
					
					$closeH = ceil($opening_hours->close->time / 100);
					$closeM = ($opening_hours->close->time % 100);
					$close  = sprintf('%02d', $closeH).'.'.sprintf('%02d', $closeM);
					
					$bizHourStr = $opening_hours->open->day.' '.$open.' '.$close;
					
					$bizhrsA = explode(' ', $bizHourStr);
					if(isset($tA[$bizhrsA[0]]))
						$tsize = count($tA[$bizhrsA[0]]);
					else
						$tsize =0;
					$tA[$bizhrsA[0]][$tsize] = $bizhrsA;
					$sortA[$bizhrsA[0]][$tsize] = $bizhrsA[1];
				}elseif(isset($opening_hours->open->time)){
					$openH = ceil($opening_hours->open->time / 100);
					$openM = ($opening_hours->open->time % 100);
					$open  = sprintf('%02d', $openH).'.'.sprintf('%02d', $openM);
					
					$closeH = ceil(0000 / 100);
					$closeM = (0000 % 100);
					$close  = sprintf('%02d', $closeH).'.'.sprintf('%02d', $closeM);
					
					for($i = $opening_hours->open->day; $i<=6; $i++){
						$bizHourStr = $i.' '.$open.' '.$close;
						
						$bizhrsA = explode(' ', $bizHourStr);
						if(isset($tA[$bizhrsA[0]]))
							$tsize = count($tA[$bizhrsA[0]]);
						else
							$tsize =0;
						$tA[$bizhrsA[0]][$tsize] = $bizhrsA;
						$sortA[$bizhrsA[0]][$tsize] = $bizhrsA[1];
					}
				}
			}
			
			foreach($tA as $key => $value){
				array_multisort($sortA[$key], SORT_ASC, $value);
				foreach($value as $key1 => $value1){
					$bizHoursA[] = implode(' ', $value1);
				}
			}
		}
		
		if($gImg==1){
			if(isset($json->result->photos) && is_array($json->result->photos) && count($json->result->photos)>0){
				BusinessImage::where('biz_id', $biz_id)->where('google_ref', '!=', '')->delete();
				$k = 1;
				foreach($json->result->photos as $key => $photos){
					if(isset($photos->photo_reference) && trim($photos->photo_reference)!='' && $k<=5){
						$imgUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=400&key='.$gKey.'&photoreference='.urlencode(trim($photos->photo_reference));
						$imgCnt = @file_get_contents($imgUrl);
						$destinationPath = 'uploads/pictures/business'; // upload path
						$extension = 'jpg'; // getting file extension
						$fileName = 'g'.$biz_id.time().rand(11, 999) . '.' . $extension;
						@file_put_contents(public_path().'/'.$destinationPath.'/'.$fileName, $imgCnt);
						$img = $destinationPath.'/'.$fileName;
						
						$picture = new BusinessImage(array(
							'biz_id'     => $biz_id,
							'filename'   => $img,
							'google_ref' => trim($photos->photo_reference)
						));
						$picture->save();
						$k++;
					}
				}
			}
		}
		
		if(isset($json->result->website) && trim($json->result->website)!=''){
			$business->web = trim($json->result->website);
		}
		if(isset($json->result->formatted_phone_number) && trim($json->result->formatted_phone_number)!=''){
			$formatted_phone_number = str_replace(' ', '', trim($json->result->formatted_phone_number));
			$business->phone = $formatted_phone_number;
		}
		$timeNow = \Carbon\Carbon::now();//server time
		$business->google_update = $timeNow;
		$business->biz_hours = serialize($bizHoursA);
		$business->save();
	}
}

function addresstoarray($pData){
	$address 		= '';
	$sublocality 	= '';
	$locality 		= '';
	$subadmin1		= '';
	$country_code	= '';
	$city			= '';
	$lat 			= $pData['lat'];
	$lng 			= $pData['lng'];
	$address_components = array_reverse($pData['address']);
	foreach($address_components as $aKey => $aVal){
		if(isset($aVal->types) && is_array($aVal->types) && in_array('premise', $aVal->types)){
			if(trim($aVal->long_name)!=''){
				$address = trim($aVal->long_name);
			}
		}
		if(isset($aVal->types) && is_array($aVal->types) && in_array('sublocality', $aVal->types)){
			if(trim($sublocality)=='')
			$sublocality 	  = trim($aVal->long_name);
		}
		if(isset($aVal->types) && is_array($aVal->types) && in_array('locality', $aVal->types)){
			if(trim($locality)=='')
			$locality = trim($aVal->long_name);
		}
		if(isset($aVal->types) && is_array($aVal->types) && in_array('administrative_area_level_1', $aVal->types)){
			$subadmin1 = trim($aVal->long_name);
		}
		if(isset($aVal->types) && is_array($aVal->types) && in_array('country', $aVal->types)){
			$country_code = trim($aVal->short_name);
		}
	}
	if(trim($locality)!=''){
		$city = trim($locality);
	}elseif(trim($sublocality)!=''){
		$city = trim($sublocality);
	}
	$rData['address'] 		= $address;
	$rData['city'] 			= $city;
	$rData['subadmin1'] 	= $subadmin1;
	$rData['country_code'] 	= $country_code;
	
	//BOF Code to insert City
	if($country_code!=''){
		$code = '';
		if($subadmin1!=''){
			$SubAdmin1A = SubAdmin1::where('code', 'LIKE', $country_code.'.%')->where('asciiname', $subadmin1)->first();
			if(isset($SubAdmin1A->asciiname)){
				$code = str_replace($country_code.'.', '', $SubAdmin1A->code);
			}else{
				
				$cot = SubAdmin1::select('code')->where('code', 'LIKE', $country_code.'.%')->orderBy('code', 'DESC')->first();
				if(!empty($cot)){
					$code1 = explode('.', $cot->code, 2);
					$code2 = $code1[1];
				}else{
					$code2 ='00';
				}
				
				$subadmin_code = $code2 + 01;
				$code = str_pad($subadmin_code,  2, "0",STR_PAD_LEFT);
				$subadmin_code1 = $country_code.".".$code;
				
				$tQry = new SubAdmin1();
				$tQry->code 	 = $subadmin_code1;
				$tQry->name 	 = $subadmin1;
				$tQry->asciiname = $subadmin1;
				$tQry->active 	 = 1;
				$tQry->save();
			}
		}
		
		if(!(strlen($city) != mb_strlen($city, 'utf-8')) && trim($city)!=''){
		//if(trim($city)!='' && $code != ''){
			$cityA = City::where('country_code', $country_code)->where('asciiname', $city)->first();
			if(isset($cityA->asciiname)){
				$city_id	= $cityA->id;
				if(trim($cityA->subadmin1_code)==''){
					$cityA->subadmin1_code 	 = $code;
					$cityA->save();
				}
				$code  = $cityA->subadmin1_code;
			}else{
				$time_zone = '';
				$city1 = City::where('country_code', $country_code)->where('time_zone', '!=', '')->first();
				if(isset($city1->time_zone)){
					$time_zone = $city1->time_zone;
				}
				$cityA = new City();
				$cityA->country_code = $country_code;
				$cityA->name 		 = $city;
				$cityA->asciiname 	 = $city;
				$cityA->latitude 	 = trim($lat);
				$cityA->longitude 	 = trim($lng);
				$cityA->subadmin1_code 	 = $code;
				$cityA->time_zone 	 = $time_zone;
				$cityA->active 	 	 = 1;
				$cityA->save();
			}
		}
	}
	//EOF Code to insert City
	return $rData;
}

function googlefetchDev($data){
	$page = 1;
	if(isset($data['page']) && $data['page']>1){
		$page = $data['page'];
	}
	$where = '';
	$cat = '';
	if(isset($data['cat']) && trim($data['cat'])!=''){
		$cat = trim($data['cat']);
		//$where .= " AND cat='".$cat."'";
	}
	$cat_id = '';
	if(isset($data['cat_id']) && $data['cat_id']>0){
		$cat_id = $data['cat_id'];
		$where .= " AND cat='".$cat_id."'";
	}
	$keyword = '';
	if(isset($data['keyword']) && trim($data['keyword'])!=''){
		$keyword = trim($data['keyword']);
		$where .= " AND keyword='".addslashes($keyword)."'";
	}
	$lat = '0';
	if(isset($data['lat']) && trim($data['lat'])!=''){
		$lat = trim($data['lat']);
	}
	$lng = '0';
	if(isset($data['lng']) && trim($data['lng'])!=''){
		$lng = trim($data['lng']);
	}
	$c_code = '';
	if(isset($data['c_code']) && trim($data['c_code'])!=''){
		$c_code = trim($data['c_code']);
	}
	$fImg = 'no';
	if(isset($data['img']) && trim($data['img'])=='yes'){
		$fImg = 'yes';
	}
	$searchId = 0;
	
	//$googleRes = GoogleSearchModel::where('page', $page)->where('keyword', $keyword)->first();
	$googleRes = \DB::select("SELECT id, (
									3959 * acos (
									  cos ( radians(".$lat.") )
									  * cos( radians( lat ) )
									  * cos( radians( lon ) - radians(".$lng.") )
									  + sin ( radians(".$lat.") )
									  * sin( radians( lat ) )
									)
								  ) AS distance 
								  FROM businessGoogleSearch 
								  WHERE id>0 ".$where."
								  HAVING distance < 1 ORDER BY distance LIMIT 1");
	if(count($googleRes)<0){
		$searchId = $googleRes[0]->id;
		if($cat_id>0){
			/*$biz = \DB::select("UPDATE business b SET b.category_id = '".$cat_id."' WHERE b.id IN (SELECT b2.id						  
								  FROM businessGoogleSearchIds bs, business b2 
								  WHERE bs.googleId=b2.googleId AND bs.searchId='".$searchId."')");
			\DB::select("UPDATE business b, businessGoogleSearchIds bs SET b.category_id = '".$cat_id."' WHERE bs.googleId=b.googleId AND bs.searchId='".$searchId."'");
			*/					  					  
		}
	}else{
		$googleResA = new GoogleSearchModel();
		$googleResA->lat 	 = $lat;
		$googleResA->lon 	 = $lng;
		$googleResA->cat 	 = $cat_id;
		$googleResA->countryCode = $c_code;
		$googleResA->keyword = $keyword;
		//$googleResA->save();
		$searchId = $googleResA->id;
		$searchId = $googleRes[0]->id;
		
		$gKey = get_google_key();
		$urlBase = 'https://maps.googleapis.com/maps/api/place/nearbysearch/json?key='.$gKey;
		$url = $urlBase.'&radius=5000&location='.urlencode($lat.' '.$lng);
		if($cat_id>0){
			$gTypes = CategoryGoogleTypeModel::where('category_id', $cat_id)->get();
			if(count($gTypes)>0){
				$tvalueA = array();
				foreach($gTypes as $tkey => $tvalue){
					$tvalueA[] =  $tvalue->google_type;
				}
				$url .= '&type='. urlencode(implode(',', $tvalueA));
				if($keyword==''){
					$keyword = implode('+', $tvalueA);
				}
			}
		}
		if($keyword!=''){
			$url .= '&keyword='. urlencode($keyword);
		}
		
		$tExp = exclude_keywords();
		
		$googleResA->url = $url;
		$googleResA->save();
		
		$i = 0;
		do{
			$i = 1;
			$result = curl_fetch($url);
			$resA = json_decode($result);
			
			if(isset($resA->results) && count($resA->results)>0){
				foreach($resA->results as $key => $value){
					echo "<pre>";
					print_r($value);
					echo "<br/>===============================================================================<br/>";
					////////////////////
					$description = '';
					$google_keywords = '';
					if(isset($value->types) && is_array($value->types) && isset($value->types[0])){
						$typesArray = array_map('strtolower', $value->types);
						$typeA = array_filter(array_diff( $typesArray, $tExp ));
						if(count($typeA)>0){
							$google_keywords = ','.implode(',',$typeA).',';
						}
						if(isset($typeA[0])){
							$description = ucfirst(trim($typeA[0]));
						}
					}
					$gKeywords = array_filter(array_unique(explode(',', $google_keywords)));
					if(trim($keyword)!=''){
						$gKeywords[] = trim($keyword);
					}
					if(is_array($gKeywords) && count($gKeywords)>0){
						$google_keywords = ','.implode(',',$gKeywords).',';
						if(!($cat_id>0)){
							$cat_id = get_cat_from_key($gKeywords);
						}
					}
					////////////////////
					$googleId = trim($value->place_id);
					$business = Business::where('googleId', $googleId)->first();
					if(isset($business->id) && $business->id>0){
						if($cat_id>0 && $business->category_id==0){
							$business->category_id = $cat_id;
							$business->save();
						}
					}else{
						//SELECT COUNT(id) as cid, googleId FROM `business` GROUP BY googleId ORDER BY cid DESC
						$name = trim($value->name);
						$address = trim($value->vicinity);
						$lat = 0;
						if(isset($value->geometry->location->lat) && trim($value->geometry->location->lat)!=''){
							$lat = trim($value->geometry->location->lat);
						}
						$lng = 0;
						if(isset($value->geometry->location->lng) && trim($value->geometry->location->lng)!=''){
							$lng = trim($value->geometry->location->lng);
						}
						
						$city_id = '';
						$city = '';
						$subadmin1_code = '';
						$country_code = '';
						if(isset($value->plus_code->compound_code) && trim($value->plus_code->compound_code)!=''){
							$compound_code = trim($value->plus_code->compound_code);
							$compound_codeA = explode(' ', $compound_code);
							$compound_code = str_replace($compound_codeA[0], '', $compound_code);
							$compound_codeA = explode(',', $compound_code);
							$cKey = count($compound_codeA)-1;
							if(isset($compound_codeA[$cKey])){
								$country = trim($compound_codeA[$cKey]);
								$countryA = Country::where('asciiname', $country)->first();
								if(isset($countryA->code) && trim($countryA->code)!=''){
									$country_code = $countryA->code;
								}
							}
							if(isset($compound_codeA[0])){
								$city = trim($compound_codeA[0]);
								$cityM = City::where('asciiname', $city)->where('country_code', $country_code )->first();
								if(isset($cityM->id) && $cityM->id>0){
									$city_id = $cityM->id;
									$subadmin1_code = $cityM->subadmin1_code;
								}
							}
						}
						
						// BOF Fetch details if city is null
						if($city_id == ''){
							$jsonDet = file_get_contents("https://maps.googleapis.com/maps/api/place/details/json?placeid=".$googleId."&fields=address_component&key=$gKey");
							$bizData=json_decode($jsonDet);
							if(isset($bizData->result->address_components)){
								$pData['address'] = $bizData->result->address_components;
								$pData['lat'] = $lat;
								$pData['lng'] = $lng;
								$rData = addresstoarray($pData);
								//$address 		= $rData['address'];
								$city			= $rData['city'];
								$subadmin1 		= $rData['subadmin1'];
								if($rData['country_code']!='')
								$country_code 	= $rData['country_code'];
							} 
							
							if($city==''){
								$url = 'https://maps.googleapis.com/maps/api/geocode/json?key='.$gKey.'&language=en&latlng='.trim($lat).','.trim($lng).'&sensor=true';
								$jsonDet = @file_get_contents($url);
								$bizData=json_decode($jsonDet);
								if(isset($bizData->results[0]->address_components)){
									$pData['address'] = $bizData->results[0]->address_components;
									$pData['lat'] = $lat;
									$pData['lng'] = $lng;
									$rData = addresstoarray($pData);
									//$address 		= $rData['address'];
									$city			= $rData['city'];
									$subadmin1 		= $rData['subadmin1'];
									if($rData['country_code']!='')
									$country_code 	= $rData['country_code'];
								} 
							}
							
							if($city!=''){
								$cityM = City::where('asciiname', $city)->where('country_code', $country_code )->first();
								if(isset($cityM->id) && $cityM->id>0){
									$city_id = $cityM->id;
									$subadmin1_code = $cityM->subadmin1_code;
								}
							}
						}
						// EOF Fetch details if country code is null
						
						if($city_id == '' && isset($data['city_id']) && $data['city_id']>0){
							$city_id = $data['city_id'];
							$city = City::where('id', $data['city_id'])->first();
							if(isset($city->id) && $city->id>0){
								$city_id = $city->id;
								$subadmin1_code = $city->subadmin1_code;
								$country_code = $city->country_code;
							}
						}
						
						$subadmin1_code = str_replace($country_code.'.','',$subadmin1_code);//to make unique
						$subadmin1_code = $country_code.'.'.$subadmin1_code;
						
						/*$description = '';
						$google_keywords = '';
						if(isset($value->types) && is_array($value->types) && isset($value->types[0])){
							$typesArray = array_map('strtolower', $value->types);
							$typeA = array_filter(array_diff( $typesArray, $tExp ));
							if(count($typeA)>0){
								$google_keywords = ','.implode(',',$typeA).',';
							}
							if(isset($typeA[0])){
								$description = ucfirst(trim($typeA[0]));
							}
						}
						
						if(!($cat_id>0)){
							$gKey = array_filter(array_unique(explode(',', $google_keywords)));
							if(trim($keyword)!=''){
								$gKey[] = trim($keyword);
							}
							if(count($gKey)>0){
								$cat_id = get_cat_from_key($gKey);
							}
						}*/
						
						//'keywords' => $keywords,
						$business_info = array(
											'country_code' => $country_code,
											'googleId' => $googleId,
											'keywordsgoogle' => $google_keywords,
											'user_id' => 0,
											'category_id' => $cat_id,
											'title' => $name,
											'description' => $description,
											'title_ar' => $name,
											'description_ar' => $description,
											'address1' => $address,
											'city_id' => $city_id,
											'subadmin1_code' => $subadmin1_code,
											'lat' => $lat,
											'lon' => $lng,
											'ip_addr' => Ip::get(),
											'activation_token' => md5(uniqid()),
											'active' => 1,
										);
						$business = new Business($business_info);
						$business->save();
						
						// Save a reference of this Business to database table businessLocations
						$business_location = array(
							'biz_id' => $business->id,
							'address_1' => $address,
							'country_id' => $country_code,
							'location_id' => $subadmin1_code,
							'city_id' => $city_id,
							'lat' => $lat,
							'lon' => $lng,
							'active' => 1,
						);
						$locationTbl = new BusinessLocation($business_location);
						$locationTbl->save();
						
						$img = '';
						if($fImg=='yes'){
							if(isset($value->photos[0]->photo_reference)){
								if(is_array($value->photos[0]->photo_reference)){
									
								}elseif(trim($value->photos[0]->photo_reference)!=''){
									//$img = trim($value->photos[0]->photo_reference);
									$imgUrl = 'https://maps.googleapis.com/maps/api/place/photo?maxwidth=200&key='.$gKey.'&photoreference='.urlencode(trim($value->photos[0]->photo_reference));
									$imgCnt = @file_get_contents($imgUrl);
									$destinationPath = 'uploads/pictures/business'; // upload path
									$extension = 'jpg'; // getting file extension
									$fileName = 'g'.$business->id . '.' . $extension;
									@file_put_contents(public_path().'/'.$destinationPath.'/'.$fileName, $imgCnt);
									$img = $destinationPath.'/'.$fileName;
								}
							}
						}
						
						if($img != ''){
							$picture = new BusinessImage(array(
								'biz_id'    => $business->id,
								'filename' => $img,
							));
							$picture->save();
						}
					}
					exit;
					$googleIds = new GoogleSearchIdsModel();
					$googleIds->searchId 	= $googleResA->id;
					$googleIds->googleId 	= $business->googleId;
					$googleIds->lat 	 	= $business->lat;
					$googleIds->lon 		= $business->lon;
					$googleIds->save();
				} 
			}
		
			if(isset($resA->next_page_token) && trim($resA->next_page_token)!=''){
				//$i = 0; //Only fetching first page 
				$url = $urlBase.'&pagetoken='.urlencode(trim($resA->next_page_token));
			}
			
		}while($i < 1);
	}
	return $searchId;
}
