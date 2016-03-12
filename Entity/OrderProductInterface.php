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

namespace WellCommerce\Bundle\OrderBundle\Entity;

use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeAwareInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;

/**
 * Interface OrderProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderProductInterface extends
    EntityInterface,
    ProductAwareInterface,
    ProductAttributeAwareInterface,
    TimestampableInterface,
    OrderAwareInterface
{

    /**
     * @return int
     */
    public function getQuantity() : float;

    /**
     * @param float $quantity
     */
    public function setQuantity(float $quantity);

    /**
     * @return Price
     */
    public function getSellPrice() : Price;

    /**
     * @param Price $sellPrice
     */
    public function setSellPrice(Price $sellPrice);

    /**
     * @return Price
     */
    public function getBuyPrice() : Price;

    /**
     * @param Price $buyPrice
     */
    public function setBuyPrice(Price $buyPrice);

    /**
     * @return float
     */
    public function getWeight() : float;
    
    /**
     * @param float $weight
     */
    public function setWeight(float $weight);
}
