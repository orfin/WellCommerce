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

namespace WellCommerce\Plugin\Currency\Converter;

/**
 * Interface CurrencyConverterInterface
 *
 * @package WellCommerce\Plugin\Currency\Converter
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyConverterInterface
{
    /**
     * Recalculates value using new currency
     *
     * @param $value
     * @param $currency
     *
     * @return mixed
     */
    public function exchange($value, $currency);
} 