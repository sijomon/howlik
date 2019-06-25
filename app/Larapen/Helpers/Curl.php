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

namespace App\Larapen\Helpers;

class Curl
{
    /**
     * @param $url
     * @param string $cookie_file
     * @param string $post_data
     * @return mixed
     */
    public static function fetch($url, $cookie_file = '', $post_data = '')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        
        if ($post_data != '') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data); // Set the post data
            curl_setopt($ch, CURLOPT_POST, 1); // This is a POST query
        }
        
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        if (str_contains(strtolower($url), 'https://')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //to disable SSL Cert checks
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept-Charset: utf-8',
            //'Accept-Language: en-us,en;q=0.7,bn-bd;q=0.3',
            'Accept-Language: fr-fr,fr;q=0.7,bn-bd;q=0.3',
            'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5'
        ]);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_REFERER, "http://m.facebook.com");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // We want the content after the query
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // Follow Location redirects
        
        if ($cookie_file != '') {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); // Read cookie information
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); // Write cookie information
        }
        
        $result = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($result) {
            return $result;
        } else {
            return $error;
        }
    }
    
    /**
     * @param $url
     * @param $saveTo
     * @param string $cookieFile
     */
    public static function grabImage($url, $save_to, $cookie_file = '')
    {
        $url = str_replace(['&amp;'], ['&'], $url);
        //echo 'PHOTO: '.$url.'<hr>'; // debug
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if (str_contains(strtolower($url), 'https://')) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($cookie_file != '') {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); // Read cookie information
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file); // Write cookie information
        }
        $raw = curl_exec($ch);
        curl_close($ch);
        
        if (file_exists($save_to)) {
            unlink($save_to);
        }
        if (file_put_contents($save_to, $raw) === false) {
            echo $url . ' don\'t save in ' . $save_to . ".\n";
        }
    }
    
    public static function getCookies($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT,
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        
        preg_match_all('|Set-Cookie: (.*);|U', $result, $tmp);
        $cookies = implode(';', $tmp[1]);
        
        return $cookies;
    }
    
    public static function getContent($url, $cookies, $utf8 = true)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT,
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        $out = curl_exec($ch);
        curl_close($ch);
        
        return ($utf8) ? utf8_encode($out) : $out;
    }
    
    public static function getContentByForm($url, $params, $cookies = '', $utf8 = false)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERAGENT,
            "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2490.86 Safari/537.36");
        if ($cookies != '') {
            curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $out = curl_exec($ch);
        curl_close($ch);
        
        return ($utf8) ? utf8_encode($out) : $out;
    }
	
	public static function curl_fetch($Url, $refUrl = ''){
		if (!function_exists('curl_init')){ die('Sorry cURL is not installed!'); }
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $Url);
		if($refUrl != '') {
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
}
