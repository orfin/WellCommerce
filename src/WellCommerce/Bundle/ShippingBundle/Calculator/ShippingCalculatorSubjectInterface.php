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
 * Interface ShippingCalculatorSubjectInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingCalculatorSubjectInterface
{
    /**
     * @return int
     */
    public function getShippingCostQuantity() : int;

    /**
     * @return float
     */
    public function getShippingCostWeight() : float;

    /**
     * @return float
     */
    public function getShippingCostGrossPrice() : float;

    /**
     * @return string
     */
    public function getShippingCostCurrency() : string;
}
