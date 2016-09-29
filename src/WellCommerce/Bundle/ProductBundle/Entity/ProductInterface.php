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
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePriceInterface;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\AppBundle\Entity\PriceInterface;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareInterface;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\EntityInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
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
    public function getSku() : string;
    
    public function setSku(string $sku);
    
    public function getStock() : int;
    
    public function setStock(int $stock);
    
    public function getTrackStock() : bool;
    
    public function setTrackStock(bool $trackStock);
    
    public function getDistinctions() : Collection;
    
    public function setDistinctions(Collection $distinctions);
    
    public function getProductPhotos() : Collection;
    
    public function setProductPhotos(Collection $photos);
    
    public function addProductPhoto(ProductPhotoInterface $photo);
    
    public function getCategories() : Collection;
    
    public function setCategories(Collection $collection);
    
    public function addCategory(CategoryInterface $category);
    
    public function getSellPrice() : DiscountablePriceInterface;
    
    public function setSellPrice(DiscountablePriceInterface $sellPrice);
    
    public function getBuyPrice() : PriceInterface;
    
    public function setBuyPrice(PriceInterface $buyPrice);
    
    public function getWeight() : float;
    
    public function setWeight(float $weight);
    
    public function getDimension() : Dimension;
    
    public function setDimension(Dimension $dimension);
    
    public function getPackageSize() : float;
    
    public function setPackageSize(float $packageSize);
    
    public function getAttributeGroup();
    
    public function setAttributeGroup(AttributeGroupInterface $attributeGroup);
    
    public function getVariants() : Collection;
    
    public function setVariants(Collection $attributes);
    
    public function removeVariant(VariantInterface $variant);
    
    public function getBuyPriceTax();
    
    public function setBuyPriceTax(TaxInterface $buyPriceTax = null);
    
    public function getSellPriceTax();
    
    public function setSellPriceTax(TaxInterface $sellPriceTax = null);
}
