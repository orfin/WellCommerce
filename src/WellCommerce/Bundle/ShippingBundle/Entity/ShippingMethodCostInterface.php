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

namespace WellCommerce\Bundle\ShippingBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;

/**
 * Interface ShippingMethodCostInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodCostInterface extends EntityInterface, TimestampableInterface, ShippingMethodAwareInterface
{
    /**
     * @return float
     */
    public function getRangeFrom() : float;

    /**
     * @param float $rangeFrom
     */
    public function setRangeFrom(float $rangeFrom);

    /**
     * @return float
     */
    public function getRangeTo() : float;

    /**
     * @param float $rangeTo
     */
    public function setRangeTo(float $rangeTo);

    /**
     * @return Price
     */
    public function getCost() : Price;

    /**
     * @param Price $cost
     */
    public function setCost(Price $cost);
}
