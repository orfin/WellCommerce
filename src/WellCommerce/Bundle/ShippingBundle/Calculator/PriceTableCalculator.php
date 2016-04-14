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

namespace WellCommerce\Bundle\ShippingBundle\Calculator;

use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Class PriceTableCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PriceTableCalculator extends AbstractShippingMethodCalculator
{
    /**
     * {@inheritdoc}
     */
    public function calculate(ShippingMethodInterface $shippingMethod, ShippingCalculatorSubjectInterface $subject)
    {
        $ranges          = $shippingMethod->getCosts();
        $baseCurrency    = $subject->getShippingCostCurrency();
        $targetCurrency  = $shippingMethod->getCurrency()->getCode();
        $grossAmount     = $this->currencyHelper->convert($subject->getShippingCostGrossPrice(), $baseCurrency, $targetCurrency);
        $supportedRanges = $ranges->filter(function (ShippingMethodCostInterface $cost) use ($grossAmount) {
            return ($cost->getRangeFrom() <= $grossAmount && $cost->getRangeTo() >= $grossAmount);
        });

        if ($supportedRanges->count()) {
            return $supportedRanges->first();
        }

        return null;
    }
}
