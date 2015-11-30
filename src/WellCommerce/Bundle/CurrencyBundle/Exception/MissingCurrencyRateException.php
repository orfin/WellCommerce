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
 * Class MissingCurrencyRateException
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MissingCurrencyRateException extends \InvalidArgumentException
{
    /**
     * MissingCurrencyRateException constructor.
     *
     * @param string $baseCurrency
     * @param string $targetCurrency
     */
    public function __construct($baseCurrency, $targetCurrency)
    {
        $msg = sprintf('No exchange rate found for base "%s" and target "%s" currency.', $baseCurrency, $targetCurrency);
        parent::__construct($msg);
    }
}
