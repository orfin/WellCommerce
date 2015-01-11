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

namespace WellCommerce\Bundle\RoutingBundle\Helper;

/**
 * Class Sluggable
 *
 * @package WellCommerce\Bundle\RoutingBundle\Helper
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Sluggable
{
    const SLUG_DELIMITER = '-';

    public static function makeSlug($value)
    {
        $ascii = iconv('UTF-8', 'ASCII//TRANSLIT', $value);
        $slug  = strtolower(trim(preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $ascii), self::SLUG_DELIMITER));
        $slug  = preg_replace("/[\/_|+ -]+/", self::SLUG_DELIMITER, $slug);

        return $slug;
    }
}
