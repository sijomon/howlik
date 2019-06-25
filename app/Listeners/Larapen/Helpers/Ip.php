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

class Ip
{
    /**
     * Fonction de récupération de l'adresse IP du visiteur
     * @defaultId string
     * @return IP Address
     */
    public static function get($default_ip = '127.0.0.1')
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
                    if (self::isValid($item) && substr($item, 0, 4) != '127.' && $item != '::1' && $item != '' && !in_array($item,
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
     * Check IP address version
     *
     * @param  string $ip
     * @return boolean - 4/6
     */
    public static function version($ip)
    {
        return strpos($ip, ":") === false ? 4 : 6;
    }
    
    /**
     * Validate an IP address
     *
     * @param  string $ip
     * @return boolean - true/false
     */
    public static function isValid($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Validate an IPv4 IP address
     *
     * @param  string $ip
     * @return boolean - true/false
     */
    public static function isValidIPv4($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Validate an IPv4 IP address
     *
     * @param  string $ip
     * @return boolean - true/false
     */
    public static function isValidIPv4RegEx($ip)
    {
        return preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', $ip);
    }
    
    /**
     * Validate an IPv4 IP address
     * excluding private range addresses
     *
     * @param  string $ip
     * @return boolean - true/false
     */
    public static function isValidIPv4NoPriv($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Validate an IPv6 IP address
     *
     * @param  string $ip
     * @return boolean - true/false
     */
    public static function isValidIPv6($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Validate an IPv6 IP address
     * excluding private range addresses
     *
     * @param  string $ip
     * @return boolean - true/false
     */
    public static function isValidIPv6NoPriv($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 | FILTER_FLAG_NO_PRIV_RANGE)) {
            return true;
        } else {
            return false;
        }
    }
    
    # convert ip address to ip number
    public static function ipToNumber($ip)
    {
        if (trim($ip) == '') {
            return 0;
        } else {
            $tmp = preg_split("#\.#", $ip);
            
            return ($tmp[3] + $tmp[2] * 256 + $tmp[1] * 256 * 256 + $tmp[0] * 256 * 256 * 256);
        }
    }
}
