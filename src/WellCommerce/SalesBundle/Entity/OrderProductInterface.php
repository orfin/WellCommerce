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

namespace WellCommerce\SalesBundle\Entity;

use WellCommerce\CatalogBundle\Entity\ProductAttributeAwareInterface;
use WellCommerce\CatalogBundle\Entity\ProductAwareInterface;
use WellCommerce\CoreBundle\Entity\Price;
use WellCommerce\CoreBundle\Entity\TimestampableInterface;

/**
 * Interface OrderProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface OrderProductInterface extends ProductAwareInterface, ProductAttributeAwareInterface, TimestampableInterface, OrderAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getQuantity();

    /**
     * @param float $quantity
     */
    public function setQuantity($quantity);

    /**
     * @return Price
     */
    public function getSellPrice();

    /**
     * @param Price $sellPrice
     */
    public function setSellPrice(Price $sellPrice);

    /**
     * @return Price
     */
    public function getBuyPrice();

    /**
     * @param Price $buyPrice
     */
    public function setBuyPrice(Price $buyPrice);

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @param float $weight
     */
    public function setWeight($weight);
}
