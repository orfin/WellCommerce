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
 * Class MissingCurrencyRatesException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MissingCurrencyRatesException extends \InvalidArgumentException
{
    /**
     * MissingCurrencyRatesException constructor.
     *
     * @param string $targetCurrency
     */
    public function __construct($targetCurrency)
    {
        $msg = sprintf('There are no exchange rates for "%s"', $targetCurrency);
        parent::__construct($msg);
    }
}
