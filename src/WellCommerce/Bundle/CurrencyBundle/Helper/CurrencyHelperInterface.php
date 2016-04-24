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

namespace WellCommerce\Bundle\CurrencyBundle\Helper;

/**
 * Interface CurrencyHelperInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyHelperInterface
{
    /**
     * Formats the given amount
     *
     * @param float       $amount
     * @param string|null $currency
     * @param string|null $locale
     *
     * @return string
     */
    public function format(float $amount, string $currency = null, string $locale = null) : string;

    /**
     * Converts the amount between currencies
     *
     * @param float       $amount
     * @param string|null $baseCurrency
     * @param string|null $targetCurrency
     * @param int         $quantity
     *
     * @return float
     */
    public function convert(float $amount, string $baseCurrency = null, string $targetCurrency = null, int $quantity = 1) : float;

    /**
     * Firts converts and then formats the amount
     *
     * @param float       $amount
     * @param string|null $baseCurrency
     * @param string|null $targetCurrency
     * @param int         $quantity
     * @param string|null $locale
     *
     * @return string
     */
    public function convertAndFormat(
        float $amount,
        string $baseCurrency = null,
        string $targetCurrency = null,
        int $quantity = 1,
        string $locale = null
    ) : string;

    /**
     * Returns the exchange rate
     *
     * @param string|null $baseCurrency
     * @param string|null $targetCurrency
     *
     * @return float
     */
    public function getCurrencyRate(string $baseCurrency = null, string $targetCurrency = null) : float;
}
