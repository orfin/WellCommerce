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

namespace WellCommerce\Bundle\OrderBundle\Factory;

use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotal;

/**
 * Class OrderTotalFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderTotalFactory extends AbstractFactory
{
    /**
     * Creates an order total from given values
     *
     * @param int|float $grossAmount
     * @param int|float $taxRate
     * @param string    $currency
     *
     * @return OrderTotal
     */
    public function createFromSpecifiedValues($grossAmount, $taxRate, $currency)
    {
        $orderTotal = $this->create();
        $orderTotal->setGrossAmount($grossAmount);
        $orderTotal->setTaxRate($taxRate);
        $orderTotal->setCurrency($currency);

        $orderTotal->recalculate();

        return $orderTotal;
    }

    /**
     * @return OrderTotal
     */
    public function create()
    {
        $orderTotal = new OrderTotal();
        $orderTotal->setGrossAmount(0);
        $orderTotal->setTaxRate(0);

        return $orderTotal;
    }
}
