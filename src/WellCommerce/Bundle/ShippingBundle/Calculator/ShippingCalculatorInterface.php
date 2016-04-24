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

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodCostInterface;
use WellCommerce\Bundle\ShippingBundle\Entity\ShippingMethodInterface;

/**
 * Interface ShippingCalculatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingCalculatorInterface
{
    public function getAlias() : string;

    /**
     * Returns the shipping costs collection for given amount
     *
     * @param ShippingMethodInterface  $method
     * @param ShippingSubjectInterface $subject
     *
     * @return Collection
     */
    public function calculate(ShippingMethodInterface $method, ShippingSubjectInterface $subject) : Collection;
}

