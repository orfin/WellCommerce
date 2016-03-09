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
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareTrait;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareTrait;

/**
 * Class ProductAttribute
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttribute implements ProductAttributeInterface
{
    use Timestampable;
    use HierarchyAwareTrait;
    use MediaAwareTrait;
    use AvailabilityAwareTrait;
    use ProductAwareTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var Collection
     */
    protected $attributeValues;

    /**
     * @var DiscountablePrice
     */
    protected $sellPrice;

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var string
     */
    protected $symbol;

    /**
     * @var float
     */
    protected $stock;

    /**
     * @var string
     */
    protected $modifierType;

    /**
     * @var float
     */
    protected $modifierValue;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    /**
     * @param Collection $attributeValues
     */
    public function setAttributeValues(Collection $attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @param string $symbol
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return float
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * @param float $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * @return DiscountablePrice
     */
    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    /**
     * @param DiscountablePrice $sellPrice
     */
    public function setSellPrice(DiscountablePrice $sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * @return string
     */
    public function getModifierValue()
    {
        return $this->modifierValue;
    }

    /**
     * @param string $modifierValue
     */
    public function setModifierValue($modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }

    /**
     * @return string
     */
    public function getModifierType()
    {
        return $this->modifierType;
    }

    /**
     * @param string $modifierType
     */
    public function setModifierType($modifierType)
    {
        $this->modifierType = $modifierType;
    }
}
