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
use WellCommerce\Bundle\AppBundle\Entity\Dimension;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareInterface;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\DoctrineBundle\Entity\EntityInterface;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerAwareInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareInterface;
use WellCommerce\Bundle\TaxBundle\Entity\TaxInterface;
use WellCommerce\Bundle\UnitBundle\Entity\UnitAwareInterface;

/**
 * Interface ProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductInterface extends
    EntityInterface,
    HierarchyAwareInterface,
    EnableableInterface,
    TranslatableInterface,
    TimestampableInterface,
    BlameableInterface,
    ShopCollectionAwareInterface,
    ProducerAwareInterface,
    UnitAwareInterface,
    AvailabilityAwareInterface
{
    /**
     * @return string
     */
    public function getSku() : string;

    /**
     * @param string $sku
     */
    public function setSku(string $sku);

    /**
     * @return int
     */
    public function getStock() : int;

    /**
     * @param int $stock
     */
    public function setStock(int $stock);

    /**
     * @return boolean
     */
    public function getTrackStock() : bool;

    /**
     * @param boolean $trackStock
     */
    public function setTrackStock(bool $trackStock);

    /**
     * @return Collection
     */
    public function getStatuses() : Collection;

    /**
     * @return Collection
     */
    public function setStatuses(Collection $statuses);

    /**
     * @return Collection
     */
    public function getProductPhotos() : Collection;

    /**
     * @param Collection $photos
     */
    public function setProductPhotos(Collection $photos);

    /**
     * @param ProductPhoto $photo
     */
    public function addProductPhoto(ProductPhoto $photo);

    /**
     * @return Collection
     */
    public function getCategories() : Collection;

    /**
     * @param Collection $collection
     */
    public function setCategories(Collection $collection);

    /**
     * @param CategoryInterface $category
     */
    public function addCategory(CategoryInterface $category);

    /**
     * @return DiscountablePrice
     */
    public function getSellPrice() : DiscountablePrice;

    /**
     * @param DiscountablePrice $sellPrice
     */
    public function setSellPrice(DiscountablePrice $sellPrice);

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

    /**
     * @return Dimension
     */
    public function getDimension() : Dimension;

    /**
     * @param Dimension $dimension
     */
    public function setDimension(Dimension $dimension);

    /**
     * @return float
     */
    public function getPackageSize() : float;

    /**
     * @param float $packageSize
     */
    public function setPackageSize(float $packageSize);

    /**
     * @return AttributeGroupInterface
     */
    public function getAttributeGroup();

    /**
     * @param AttributeGroupInterface $attributeGroup
     */
    public function setAttributeGroup(AttributeGroupInterface $attributeGroup);

    /**
     * @return Collection
     */
    public function getVariants() : Collection;

    /**
     * @param Collection $attributes
     */
    public function setVariants(Collection $attributes);

    /**
     * @param VariantInterface $variant
     */
    public function removeVariant(VariantInterface $variant);

    /**
     * @return TaxInterface
     */
    public function getBuyPriceTax() : TaxInterface;

    /**
     * @param TaxInterface $buyPriceTax
     */
    public function setBuyPriceTax(TaxInterface $buyPriceTax);

    /**
     * @return TaxInterface
     */
    public function getSellPriceTax() : TaxInterface;

    /**
     * @param TaxInterface $sellPriceTax
     */
    public function setSellPriceTax(TaxInterface $sellPriceTax);

    /**
     * @return Collection
     */
    public function getReviews() : Collection;
}
