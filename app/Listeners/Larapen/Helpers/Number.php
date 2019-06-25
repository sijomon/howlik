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

class Number
{
    public static function setLanguage()
    {
        // Get browser language
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        $browser_lang = substr($browser_lang, 0, 2);
        
        // Get locale from cookie
        $accept_langs = (isset($_COOKIE['locale'])) ? $_COOKIE['locale'] : $browser_lang;
        if ($accept_langs != '') {
            $tmp = explode(',', $accept_langs);
            $locale_code = str_replace('-', '_', $tmp[0]);
        } else {
            $locale_code = 'en_US';
        }
        
        // Set locale
        setlocale(LC_ALL, $locale_code);
        
        return $locale_code;
    }
    
    public static function localeFormat($number, $decimals = 2)
    {
        self::setLanguage();
        
        $locale = localeconv();
        $number = number_format($number, $decimals, $locale['decimal_point'], $locale['thousands_sep']);
        
        return $number;
    }
    
    public static function format($number, $locale_code = '')
    {
        if (empty($locale_code)) {
            $locale_code = self::setLanguage();
        }
        
        // Convert string to numeric
        $number = self::rawFormat($number);
        
        // French - 100,234.56 to 100 234,56
        $sep_thousand = (starts_with($locale_code, 'fr')) ? ' ' : ',';
        $sep_decimal = (starts_with($locale_code, 'fr')) ? ',' : '.';
        
        if (is_float($number)) {
            $number = number_format($number, 2, $sep_decimal, $sep_thousand);
        } else {
            $number = number_format($number, 0, $sep_decimal, $sep_thousand);
        }
        
        return $number;
    }
    
    public static function short($number)
    {
        //$number = (0+str_replace(',', '', $number));
        //$number = number_format($number, 10, '.', '');
        $number = (0 + str_replace(',', '.', $number));
        $number = number_format($number, 2, '.', '');
        
        if (!is_numeric($number)) {
            return 0;
        }
        
        if ($number > 1000000) {
            //$number = self::format($number/1000000).'M';
            $number = self::format($number);
        } else {
            $number = self::format($number);
        }
        
        return $number;
    }
    
    public static function rawFormat($number)
    {
        if (is_numeric($number)) {
            return $number;
        }
        
        $number = trim($number);
        $number = strtr($number, array(' ' => ''));
        $number = preg_replace('/ +/', '', $number);
        $number = str_replace(',', '.', $number);
        
        return $number;
    }
    
    public static function leadZero($int, $nb)
    {
        $diff = $nb - strlen($int);
        if ($diff <= 0) {
            return $int;
        } else {
            return str_repeat('0', $diff) . $int;
        }
    }
    
    public static function zeroPad($number, $limit)
    {
        return (strlen($number) >= $limit) ? $number : self::zeroPad("0" . $number, $limit);
    }
    
    // @todo: test me
    public static function tofloat($num)
    {
        $dot_pos = strrpos($num, '.');
        $comma_pos = strrpos($num, ',');
        $sep = (($dot_pos > $comma_pos) && $dot_pos) ? $dot_pos : ((($comma_pos > $dot_pos) && $comma_pos) ? $dot_pos : false);
        
        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }
        
        return floatval(preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' . preg_replace("/[^0-9]/", "",
                substr($num, $sep + 1, strlen($num))));
    }
}
