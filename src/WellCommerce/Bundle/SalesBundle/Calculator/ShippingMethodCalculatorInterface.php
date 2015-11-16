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

namespace WellCommerce\Bundle\SalesBundle\Calculator;

use WellCommerce\Bundle\SalesBundle\Entity\ShippingCostSubjectInterface;
use WellCommerce\Bundle\SalesBundle\Entity\ShippingMethodInterface;

/**
 * Interface ShippingMethodCalculatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodCalculatorInterface
{
    /**
     * Returns alias
     *
     * @return string
     */
    public function getAlias();

    /**
     * Returns name
     *
     * @return string
     */
    public function getName();

    /**
     * Returns shipping costs for given amount
     *
     * @param ShippingMethodInterface            $shippingMethod
     * @param ShippingCalculatorSubjectInterface $subject
     *
     * @return null|\WellCommerce\Bundle\SalesBundle\Entity\ShippingMethodCostInterface
     */
    public function calculate(ShippingMethodInterface $shippingMethod, ShippingCalculatorSubjectInterface $subject);
}

