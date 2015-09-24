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

use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAttributeAwareInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductAwareInterface;

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
     * @return float
     */
    public function getQuantity();

    /**
     * @param float $quantity
     */
    public function setQuantity($quantity);

    /**
     * @return float
     */
    public function getNetPrice();

    /**
     * @param float $netPrice
     */
    public function setNetPrice($netPrice);

    /**
     * @return float
     */
    public function getTaxValue();

    /**
     * @param float $taxValue
     */
    public function setTaxValue($taxValue);

    /**
     * @return float
     */
    public function getGrossPrice();

    /**
     * @param float $grossPrice
     */
    public function setGrossPrice($grossPrice);

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @param float $weight
     */
    public function setWeight($weight);
}
