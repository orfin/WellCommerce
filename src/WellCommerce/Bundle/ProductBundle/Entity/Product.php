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
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityInterface;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\PhotoTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Dimension;
use WellCommerce\Bundle\CoreBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\CoreBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Price;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopCollectionAwareTrait;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerAwareTrait;
use WellCommerce\Bundle\TaxBundle\Entity\TaxInterface;
use WellCommerce\Bundle\UnitBundle\Entity\UnitAwareTrait;

/**
 * Class Product
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Product implements ProductInterface
{
    use Translatable, Timestampable, Blameable, PhotoTrait, EnableableTrait, HierarchyAwareTrait, ShopCollectionAwareTrait, ProducerAwareTrait, UnitAwareTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var AvailabilityInterface
     */
    protected $availability;

    /**
     * @var Collection
     */
    protected $categories;

    /**
     * @var Collection
     */
    protected $statuses;

    /**
     * @var Collection
     */
    protected $productPhotos;

    /**
     * @var Collection
     */
    protected $attributes;

    /**
     * @var float
     */
    protected $stock;

    /**
     * @var Price
     */
    protected $buyPrice;

    /**
     * @var TaxInterface
     */
    protected $buyPriceTax;

    /**
     * @var DiscountablePrice
     */
    protected $sellPrice;

    /**
     * @var TaxInterface
     */
    protected $sellPriceTax;

    /**
     * @var AttributeGroupInterface
     */
    protected $attributeGroup;

    /**
     * @var bool
     */
    protected $trackStock;

    /**
     * @var float
     */
    protected $weight;

    /**
     * @var Dimension
     */
    protected $dimension;

    /**
     * @var float
     */
    protected $packageSize;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param string $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
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
        $this->stock = (float)$stock;
    }

    /**
     * @return boolean
     */
    public function getTrackStock()
    {
        return $this->trackStock;
    }

    /**
     * @param boolean $trackStock
     */
    public function setTrackStock($trackStock)
    {
        $this->trackStock = $trackStock;
    }

    /**
     * @return AvailabilityInterface
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * @param AvailabilityInterface $availability
     */
    public function setAvailability(AvailabilityInterface $availability = null)
    {
        $this->availability = $availability;
    }

    /**
     * @return Collection
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @return Collection
     */
    public function setStatuses(Collection $statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * @return Collection
     */
    public function getProductPhotos()
    {
        return $this->productPhotos;
    }

    /**
     * @param Collection $photos
     */
    public function setProductPhotos(Collection $photos)
    {
        $this->productPhotos = $photos;
    }

    /**
     * @param ProductPhoto $photo
     */
    public function addProductPhoto(ProductPhoto $photo)
    {
        $this->productPhotos[] = $photo;
    }

    /**
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Collection $collection
     */
    public function setCategories(Collection $collection)
    {
        $this->categories = $collection;
    }

    /**
     * @param CategoryInterface $category
     */
    public function addCategory(CategoryInterface $category)
    {
        $this->categories[] = $category;
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
     * @return Price
     */
    public function getBuyPrice()
    {
        return $this->buyPrice;
    }

    /**
     * @param Price $buyPrice
     */
    public function setBuyPrice(Price $buyPrice)
    {
        $this->buyPrice = $buyPrice;
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
        $this->weight = (float)$weight;
    }

    /**
     * @return Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * @param Dimension $dimension
     */
    public function setDimension(Dimension $dimension)
    {
        $this->dimension = $dimension;
    }

    /**
     * @return float
     */
    public function getPackageSize()
    {
        return $this->packageSize;
    }

    /**
     * @param float $packageSize
     */
    public function setPackageSize($packageSize)
    {
        $this->packageSize = (float)$packageSize;
    }

    /**
     * @return AttributeGroupInterface
     */
    public function getAttributeGroup()
    {
        return $this->attributeGroup;
    }

    /**
     * @param AttributeGroupInterface $attributeGroup
     */
    public function setAttributeGroup(AttributeGroupInterface $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
    }

    /**
     * @return Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param Collection $attributes
     */
    public function setAttributes(Collection $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return TaxInterface
     */
    public function getBuyPriceTax()
    {
        return $this->buyPriceTax;
    }

    /**
     * @param TaxInterface $buyPriceTax
     */
    public function setBuyPriceTax(TaxInterface $buyPriceTax)
    {
        $this->buyPriceTax = $buyPriceTax;
    }

    /**
     * @return TaxInterface
     */
    public function getSellPriceTax()
    {
        return $this->sellPriceTax;
    }

    /**
     * @param TaxInterface $sellPriceTax
     */
    public function setSellPriceTax(TaxInterface $sellPriceTax)
    {
        $this->sellPriceTax = $sellPriceTax;
    }
}
