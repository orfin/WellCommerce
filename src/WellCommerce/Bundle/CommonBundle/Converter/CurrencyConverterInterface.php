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

namespace WellCommerce\Bundle\CommonBundle\Converter;

/**
 * Interface CurrencyConverterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyConverterInterface
{
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
     * Returns an exchange rate
     *
     * @param string|null $baseCurrency
     * @param string|null $targetCurrency
     *
     * @return int|float
     */
    public function getExchangeRate($baseCurrency = null, $targetCurrency = null);
}
