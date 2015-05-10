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

namespace WellCommerce\Bundle\IntlBundle\Converter;

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
     * @param float  $amount
     * @param string $baseCurrency
     * @param string $targetCurrency
     *
     * @return float
     */
    public function convert($amount, $baseCurrency, $targetCurrency = null);
}