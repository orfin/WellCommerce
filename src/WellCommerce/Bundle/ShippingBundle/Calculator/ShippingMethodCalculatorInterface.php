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

use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Interface ShippingMethodCalculatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodCalculatorInterface
{
    public function getAlias() : string;

    /**
     * Returns shipping costs for given amount
     *
     * @param ShippingMethodInterface            $shippingMethod
     * @param ShippingCalculatorSubjectInterface $subject
     *
     * @return null|\WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface
     */
    public function calculate(ShippingMethodInterface $shippingMethod, ShippingCalculatorSubjectInterface $subject);
}

