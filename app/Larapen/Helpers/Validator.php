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

use App\Larapen\Models\Blacklist;
use App\Larapen\Helpers\Ip;

class Validator
{
    /**
     * @return bool
     */
    public static function checkIp()
    {
        $ip = Ip::get();
        $res = Blacklist::ofType('ip')->where('entry', $ip)->first();
        if ($res) {
            return false;
        }
        
        return true;
    }
    
    /**
     * @param $domain
     * @return bool
     */
    public static function checkDomain($domain)
    {
        $domain = strtolower($domain);
        $domain = str_replace(['http://', 'www.'], '', $domain);
        if (str_contains($domain, '/')) {
            $domain = strstr($domain, '/', true);
        }
        if (str_contains($domain, '@')) {
            $domain = strstr($domain, '@');
            $domain = str_replace('@', '', $domain);
        }
        $res = Blacklist::ofType('domain')->where('entry', $domain)->first();
        if ($res) {
            return false;
        }
        
        return true;
    }
    
    /**
     * @param $email
     * @return bool
     */
    public static function checkEmail($email)
    {
        $email = strtolower($email);
        $res = Blacklist::ofType('email')->where('entry', $email)->first();
        if ($res) {
            return false;
        }
        
        return true;
    }
    
    /**
     * @param $text
     * @return bool
     */
    public static function checkWord($text)
    {
        $text = trim(mb_strtolower($text));
        $words = Blacklist::ofType('word')->get();
        if ($words->count() > 0) {
            foreach ($words as $word) {
                // Check if a ban's word is contained in the user entry
                $patten = '\s-.,;:=/#\|_s';
                try {
                    if (preg_match('|[' . $patten . '\\\]+' . $word->entry . '[' . $patten . '\\\]+|i', ' ' . $text . ' ')) {
                        return false;
                    }
                } catch (\Exception $e) {
                    if (preg_match('|[' . $patten . ']+' . $word->entry . '[' . $patten . ']+|i', ' ' . $text . ' ')) {
                        return false;
                    }
                }
            }
        }
        
        return true;
    }
    
    /**
     * @param $text
     * @return bool
     */
    public static function checkTitle($text)
    {
        if (!self::checkWord($text)) {
            return false;
        }
        // Banned all domain name from title
        $tlds = config('tlds');
        if (count($tlds) > 0) {
            foreach ($tlds as $tld => $label) {
                if (str_contains($text, '.' . strtolower($tld))) {
                    return false;
                }
            }
        }
        
        return true;
    }
    
    /**
     * @param $text
     * @param array $parameters
     * @return bool
     */
    public static function mbBetween($text, $parameters)
    {
        $min = (isset($parameters['min'])) ? (int)$parameters['min'] : 0;
        $max = (isset($parameters['max'])) ? (int)$parameters['max'] : 999999;
        
        if (mb_strlen($text) < $min) {
            return false;
        } else {
            if (mb_strlen($text) > $max) {
                return false;
            }
        }

        return true;
    }
}
