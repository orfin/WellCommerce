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

namespace WellCommerce\Bundle\AppBundle\Helper;

/**
 * Class TaxHelper
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxHelper
{
    /**
     * Calculates net price
     *
     * @param int|float $grossPrice
     * @param int|float $taxRate
     *
     * @return float
     */
    public static function calculateNetPrice($grossPrice, $taxRate)
    {
        return round($grossPrice / (1 + $taxRate / 100), 2);
    }
}
