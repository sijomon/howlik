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

class Arr
{
    public static function groupBy($array, $field, $create_array = true)
    {
        $tab_sort = array();
        if (is_object(current($array))) {
            foreach ($array as $item) {
                if ($create_array) {
                    if (!@is_array($tab_sort[$item->$field])) {
                        $tab_sort[$item->$field] = array();
                    }
                    $tab_sort[$item->$field][] = $item;
                } else {
                    $tab_sort[$item->$field] = $item;
                }
            }
        } elseif (is_array(current($array))) {
            foreach ($array as $item) {
                if ($create_array) {
                    if (!@is_array($tab_sort[$item[$field]])) {
                        $tab_sort[$item[$field]] = array();
                    }
                    $tab_sort[$item[$field]][] = $item;
                } else {
                    $tab_sort[$item[$field]] = $item;
                }
            }
        } else {
            return $array;
        }
        
        return $tab_sort;
    }
    
    
    // Sort
    public static function sortBy($array, $field, $order = 'asc', $keep_index = true)
    {
        if (empty($array)) {
            return false;
        }
        
        $int = 1;
        if (strtolower($order) == 'desc') {
            $int = -1;
        }
        
        if (is_object($array)) {
            // @todo: fixme on PHP5+
            if ($keep_index) {
                uasort($array, create_function('$a, $b', 'if ($a->' . $field . ' == $b->' . $field . ') return 0;
                            return ($a->' . $field . ' < $b->' . $field . ') ? ' . -$int . ' : ' . $int . ';'));
            } else {
                usort($array, create_function('$a, $b', 'if ($a->' . $field . ' == $b->' . $field . ') return 0;
                            return ($a->' . $field . ' < $b->' . $field . ') ? ' . -$int . ' : ' . $int . ';'));
            }
        } elseif (is_array($array)) {
            if ($keep_index) {
                uasort($array, create_function('$a, $b', 'if ($a[' . $field . '] == $b[' . $field . ']) return 0;
                            return ($a[' . $field . '] < $b[' . $field . ']) ? ' . -$int . ' : ' . $int . ';'));
            } else {
                usort($array, create_function('$a, $b', 'if ($a[' . $field . '] == $b[' . $field . ']) return 0;
                            return ($a[' . $field . '] < $b[' . $field . ']) ? ' . -$int . ' : ' . $int . ';'));
            }
        }
        
        return $array;
    }
    
    // Object to Array
    public static function fromObject($object)
    {
        if (is_array($object) || is_object($object)) {
            $array = array();
            foreach ($object as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $array[$key] = self::fromObject($value);
                } else {
                    $array[$key] = $value;
                }
            }
            
            return $array;
        }
        
        return $object;
    }
    
    // Array to Object (PHP5)
    public static function toObject($array)
    {
        if (!is_array($array)) {
            return $array;
        }
        
        $object = new \stdClass();
        if (is_array($array) && !empty($array)) {
            foreach ($array as $key => $value) {
                $key = trim($key);
                if ($key != '') {
                    $object->$key = self::toObject($value);
                }
            }
            
            return $object;
        } else {
            return [];
        }
    }
    
    /**
     * array_unique multidimension
     */
    public static function unique($array)
    {
        if (is_object($array)) {
            $array = self::fromObject($array);
            $array = self::unique($array);
            $array = self::toObject($array);
        } else {
            $array = array_map('serialize', $array);
            $array = array_map('base64_encode', $array);
            $array = array_unique($array);
            $array = array_map('base64_encode', $array);
            $array = array_map('unserialize', $array);
        }
        
        return $array;
    }
    
    /**
     * This function will remove all the specified keys from an array and return the final array.
     * Arguments : The first argument is the array that should be edited
     *             The arguments after the first argument is a list of keys that must be removed.
     * Example    : array_remove_key($arr, "one", "two", "three");
     * Return    : The function will return an array after deleting the said keys
     */
    public static function removeKey()
    {
        $args = func_get_args();
        $arr = $args[0];
        $keys = array_slice($args, 1);
        foreach ($arr as $k => $v) {
            if (in_array($k, $keys)) {
                unset($arr[$k]);
            }
        }
        
        return $arr;
    }
    
    /**
     * This function will remove all the specified values from an array and return the final array.
     * Arguments : The first argument is the array that should be edited
     *             The arguments after the first argument is a list of values that must be removed.
     * Example : array_remove_value($arr,"one","two","three");
     * Return : The function will return an array after deleting the said values
     */
    public static function removeValue()
    {
        $args = func_get_args();
        $arr = $args[0];
        $values = array_slice($args, 1);
        foreach ($arr as $k => $v) {
            if (in_array($v, $values)) {
                unset($arr[$k]);
            }
        }
        
        return $arr;
    }
}
