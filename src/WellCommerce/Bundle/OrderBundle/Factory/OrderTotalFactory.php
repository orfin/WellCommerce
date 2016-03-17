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

use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotal;
use WellCommerce\Bundle\OrderBundle\Entity\OrderTotalInterface;

/**
 * Class OrderTotalFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderTotalFactory extends AbstractEntityFactory
{
    /**
     * Creates an order total from given values
     *
     * @param float  $grossAmount
     * @param float  $taxRate
     * @param string $currency
     *
     * @return OrderTotalInterface
     */
    public function createFromSpecifiedValues(float $grossAmount, float $taxRate, string $currency) : OrderTotalInterface
    {
        $orderTotal = $this->create();
        $orderTotal->setGrossAmount($grossAmount);
        $orderTotal->setTaxRate($taxRate);
        $orderTotal->setCurrency($currency);
        
        $orderTotal->recalculate();

        return $orderTotal;
    }

    /**
     * @return OrderTotalInterface
     */
    public function create() : OrderTotalInterface
    {
        $orderTotal = new OrderTotal();
        $orderTotal->setGrossAmount(0);
        $orderTotal->setTaxRate(0);

        return $orderTotal;
    }
}
