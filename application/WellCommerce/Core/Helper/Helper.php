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
namespace WellCommerce\Core\Helper;

use WellCommerce\Core\AbstractComponent;

/**
 * Class Helper
 *
 * @package WellCommerce\Core
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Helper extends AbstractComponent
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
     * Makes a sluggable from passed string
     *
     * @param        $string
     * @param string $delimiter
     *
     * @return string
     */
    public static function makeSlug($string, $delimiter = '-')
    {
        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    /**
     * Converts string to snake-case
     *
     * @param        $value
     * @param string $delimiter
     *
     * @return string
     */
    public static function snake($value, $delimiter = '_')
    {
        $replace = '$1' . $delimiter . '$2';

        return ctype_lower($value) ? $value : strtolower(preg_replace('/(.)([A-Z])/', $replace, $value));
    }
}