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

namespace WellCommerce\SalesBundle\Provider;

use WellCommerce\SalesBundle\Calculator\ShippingCalculatorSubjectInterface;

/**
 * Interface ShippingMethodProviderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodProviderInterface
{
    /**
     * Returns all shipping methods that can handle given subject
     *
     * @param ShippingCalculatorSubjectInterface $subject
     *
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getShippingMethodCostsCollection(ShippingCalculatorSubjectInterface $subject);

    /**
     * Returns all shipping options for given subject
     *
     * @param ShippingCalculatorSubjectInterface $subject
     *
     * @return array
     */
    public function getShippingMethodOptions(ShippingCalculatorSubjectInterface $subject);

    /**
     * Returns all payment options fetched from collection of available shipping methods for given subject
     *
     * @param ShippingCalculatorSubjectInterface $subject
     *
     * @return array
     */
    public function getShippingMethodsPaymentOptions(ShippingCalculatorSubjectInterface $subject);
}
