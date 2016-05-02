<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Bundle\CoreBundle\Helper;

/**
 * Class Helper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Helper
{
    /**
     * Replaces commas with dots
     *
     * @param $value
     *
     * @return string
     */
    public static function changeCommaToDot($value)
    {
        return str_replace(',', '.', $value);
    }
    
    /**
     * Converts string to snake-case
     *
     * @param string $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function snake($value, $delimiter = '_')
    {
        $replace = '$1' . $delimiter . '$2';
        
        return ctype_lower($value) ? $value : strtolower(preg_replace('/(.)([A-Z])/', $replace, $value));
    }
    
    /**
     * Converts string to studly-case
     *
     * @param string $value
     *
     * @return string
     */
    public static function studly($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        
        return str_replace(' ', '', $value);
    }
    
    /**
     * Converts dot-notation to proper property path notation
     * Example: menu.catalog.item > [menu][catalog][item]
     *
     * @param $path
     *
     * @return string
     */
    public static function convertDotNotation($path)
    {
        $elements = explode('.', $path);
        $path     = array_map(
            function ($element) {
                return '[' . $element . ']';
            },
            $elements
        );
        
        return implode('', $path);
    }
    
    /**
     * Generates a random password for given length
     *
     * @param int $length
     *
     * @return string
     */
    public static function generateRandomPassword($length = 8)
    {
        $chars    = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        
        return $password;
    }
    
    /**
     * Returns an array of values flattened to dot notation
     *
     * @param array $data
     *
     * @return array
     */
    public static function flattenArrayToDotNotation(array $data)
    {
        $nodes  = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($data));
        $result = [];
        foreach ($nodes as $leafValue) {
            $keys = [];
            foreach (range(0, $nodes->getDepth()) as $depth) {
                $keys[] = $nodes->getSubIterator($depth)->key();
            }
            $result[join('.', $keys)] = $leafValue;
        }
        
        return $result;
    }
}
