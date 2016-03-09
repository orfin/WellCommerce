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

namespace WellCommerce\Bundle\ProductBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareInterface;

/**
 * Interface ProductAttributeInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductAttributeInterface extends
    TimestampableInterface,
    AvailabilityAwareInterface,
    ProductAwareInterface,
    HierarchyAwareInterface,
    MediaAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return Collection
     */
    public function getAttributeValues();

    /**
     * @param Collection $attributeValues
     */
    public function setAttributeValues(Collection $attributeValues);

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @param float $weight
     */
    public function setWeight($weight);

    /**
     * @return string
     */
    public function getSymbol();

    /**
     * @param string $symbol
     */
    public function setSymbol($symbol);

    /**
     * @return float
     */
    public function getStock();

    /**
     * @param float $stock
     */
    public function setStock($stock);

    /**
     * @return DiscountablePrice
     */
    public function getSellPrice();

    /**
     * @param DiscountablePrice $sellPrice
     */
    public function setSellPrice(DiscountablePrice $sellPrice);

    /**
     * @return float
     */
    public function getModifierValue();

    /**
     * @param float $modifierValue
     */
    public function setModifierValue($modifierValue);

    /**
     * @return string
     */
    public function getModifierType();

    /**
     * @param string $modifierType
     */
    public function setModifierType($modifierType);
}
