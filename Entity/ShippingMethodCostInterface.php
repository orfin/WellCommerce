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

namespace WellCommerce\Bundle\AppBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface ShippingMethodCostInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ShippingMethodCostInterface extends TimestampableInterface, ShippingMethodAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return float
     */
    public function getRangeFrom();

    /**
     * @param float $rangeFrom
     */
    public function setRangeFrom($rangeFrom);

    /**
     * @return float
     */
    public function getRangeTo();

    /**
     * @param float $rangeTo
     */
    public function setRangeTo($rangeTo);

    /**
     * @return Price
     */
    public function getCost();

    /**
     * @param Price $cost
     */
    public function setCost(Price $cost);
}
