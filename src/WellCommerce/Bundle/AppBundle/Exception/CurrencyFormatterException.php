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

namespace WellCommerce\Bundle\AppBundle\Exception;

/**
 * Class CurrencyFormatterException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyFormatterException extends \InvalidArgumentException
{
    /**
     * Constructor
     *
     * @param float  $amount
     * @param string $currency
     * @param string $locale
     */
    public function __construct($amount, $currency, $locale)
    {
        $msg = sprintf('Cannot format price with amount "%s" and currency "%s" for locale "%s"', $amount, $currency, $locale);
        parent::__construct($msg);
    }
}
