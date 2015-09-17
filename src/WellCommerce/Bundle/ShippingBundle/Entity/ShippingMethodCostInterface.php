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
     * @return float
     */
    public function getCost();

    /**
     * @param float $cost
     */
    public function setCost($cost);
}
