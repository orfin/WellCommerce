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

namespace WellCommerce\CommonBundle\Helper;

/**
 * Interface CurrencyHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyHelperInterface
{
    /**
     * Formats given amount
     *
     * @param float       $amount
     * @param null|string $currency
     * @param null|string $locale
     *
     * @return string
     */
    public function format($amount, $currency = null, $locale = null);

    /**
     * Converts amount from base currency to target currency
     *
     * @param float       $amount
     * @param null|string $baseCurrency
     * @param null|string $targetCurrency
     * @param int         $quantity
     *
     * @return float
     */
    public function convert($amount, $baseCurrency = null, $targetCurrency = null, $quantity = 1);

    /**
     * Converts and formats the given amount
     *
     * @param int|float   $amount
     * @param null|string $baseCurrency
     * @param null|string $targetCurrency
     * @param int         $quantity
     * @param null|string $locale
     *
     * @return string
     */
    public function convertAndFormat($amount, $baseCurrency = null, $targetCurrency = null, $quantity = 1, $locale = null);
}
