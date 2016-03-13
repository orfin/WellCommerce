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
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareTrait;

/**
 * Class ProductAttribute
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductAttribute extends AbstractEntity implements ProductAttributeInterface
{
    use Timestampable;
    use HierarchyAwareTrait;
    use MediaAwareTrait;
    use AvailabilityAwareTrait;
    use ProductAwareTrait;

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
     * @var int
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
     * {@inheritdoc}
     */
    public function getAttributeValues() : Collection
    {
        return $this->attributeValues;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeValues(Collection $attributeValues)
    {
        $this->attributeValues = $attributeValues;
    }

    /**
     * {@inheritdoc}
     */
    public function getWeight() : float
    {
        return $this->weight;
    }

    /**
     * {@inheritdoc}
     */
    public function setWeight(float $weight)
    {
        $this->weight = $weight;
    }

    /**
     * {@inheritdoc}
     */
    public function getSymbol() : string
    {
        return $this->symbol;
    }

    /**
     * {@inheritdoc}
     */
    public function setSymbol(string $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * {@inheritdoc}
     */
    public function getStock() : int
    {
        return $this->stock;
    }

    /**
     * {@inheritdoc}
     */
    public function setStock(int $stock)
    {
        $this->stock = $stock;
    }

    /**
     * {@inheritdoc}
     */
    public function getSellPrice() : DiscountablePrice
    {
        return $this->sellPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setSellPrice(DiscountablePrice $sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifierValue() : float
    {
        return $this->modifierValue;
    }

    /**
     * {@inheritdoc}
     */
    public function setModifierValue(float $modifierValue)
    {
        $this->modifierValue = $modifierValue;
    }

    /**
     * {@inheritdoc}
     */
    public function getModifierType() : string
    {
        return $this->modifierType;
    }

    /**
     * {@inheritdoc}
     */
    public function setModifierType(string $modifierType)
    {
        $this->modifierType = $modifierType;
    }
}
