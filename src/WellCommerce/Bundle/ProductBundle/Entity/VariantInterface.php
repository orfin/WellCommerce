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
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareInterface;

/**
 * Interface VariantInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface VariantInterface extends
    EntityInterface,
    TimestampableInterface,
    AvailabilityAwareInterface,
    ProductAwareInterface,
    HierarchyAwareInterface,
    MediaAwareInterface
{
    /**
     * @return float
     */
    public function getWeight() : float;

    /**
     * @param float $weight
     */
    public function setWeight(float $weight);

    /**
     * @return string
     */
    public function getSymbol() : string;

    /**
     * @param string $symbol
     */
    public function setSymbol(string $symbol);

    /**
     * @return int
     */
    public function getStock() : int;

    /**
     * @param int $stock
     */
    public function setStock(int $stock);

    /**
     * @return DiscountablePrice
     */
    public function getSellPrice() : DiscountablePrice;

    /**
     * @param DiscountablePrice $sellPrice
     */
    public function setSellPrice(DiscountablePrice $sellPrice);

    /**
     * @return float
     */
    public function getModifierValue() : float;

    /**
     * @param float $modifierValue
     */
    public function setModifierValue(float $modifierValue);

    /**
     * @return string
     */
    public function getModifierType() : string;

    /**
     * @param string $modifierType
     */
    public function setModifierType(string $modifierType);

    /**
     * @return Collection
     */
    public function getOptions() : Collection;

    /**
     * @param Collection $sets
     */
    public function setOptions(Collection $options);
}
