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

namespace WellCommerce\AppBundle\Service\Currency\Formatter;

/**
 * Interface CurrencyFormatterInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CurrencyFormatterInterface
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
}
