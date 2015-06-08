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

/**
 * Class FixedPriceCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FixedPriceCalculator extends AbstractShippingMethodCalculator
{
    protected $alias = 'fixed_price';

    public function getName()
    {
        return 'Fixed price';
    }

    /**
     * {@inheritdoc}
     */
    public function calculate()
    {
        $cart   = $this->cartProvider->getCurrentCart();
        $totals = $cart->getTotals();

        return $totals->getQuantity() * 9;
    }
}
