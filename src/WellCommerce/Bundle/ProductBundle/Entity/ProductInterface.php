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
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareInterface;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerAwareInterface;
use WellCommerce\Bundle\ShippingBundle\Calculator\ShippingCalculatorSubjectInterface;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareInterface;
use WellCommerce\Bundle\TaxBundle\Entity\TaxInterface;
use WellCommerce\Bundle\UnitBundle\Entity\UnitAwareInterface;

/**
 * Interface ProductInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface ProductInterface extends
    TranslatableInterface,
    TimestampableInterface,
    BlameableInterface,
    ShopCollectionAwareInterface,
    ProducerAwareInterface,
    UnitAwareInterface,
    AvailabilityAwareInterface,
    ShippingCalculatorSubjectInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getSku();

    /**
     * @param string $sku
     */
    public function setSku($sku);

    /**
     * @return int
     */
    public function getStock();

    /**
     * @param int $stock
     */
    public function setStock($stock);

    /**
     * @return boolean
     */
    public function getTrackStock();

    /**
     * @param boolean $trackStock
     */
    public function setTrackStock($trackStock);

    /**
     * @return Collection
     */
    public function getStatuses();

    /**
     * @return Collection
     */
    public function setStatuses(Collection $statuses);

    /**
     * @return Collection
     */
    public function getProductPhotos();

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
    public function getCategories();

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
    public function getSellPrice();

    /**
     * @param DiscountablePrice $sellPrice
     */
    public function setSellPrice(DiscountablePrice $sellPrice);

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

    /**
     * @return Dimension
     */
    public function getDimension();

    /**
     * @param Dimension $dimension
     */
    public function setDimension(Dimension $dimension);

    /**
     * @return float
     */
    public function getPackageSize();

    /**
     * @param float $packageSize
     */
    public function setPackageSize($packageSize);

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
    public function getAttributes();

    /**
     * @param Collection $attributes
     */
    public function setAttributes(Collection $attributes);

    /**
     * @param ProductAttributeInterface $productAttribute
     */
    public function removeAttribute(ProductAttributeInterface $productAttribute);

    /**
     * @return TaxInterface
     */
    public function getBuyPriceTax();

    /**
     * @param TaxInterface $buyPriceTax
     */
    public function setBuyPriceTax(TaxInterface $buyPriceTax);

    /**
     * @return TaxInterface
     */
    public function getSellPriceTax();

    /**
     * @param TaxInterface $sellPriceTax
     */
    public function setSellPriceTax(TaxInterface $sellPriceTax);

    /**
     * @return Collection
     */
    public function getReviews();
}
