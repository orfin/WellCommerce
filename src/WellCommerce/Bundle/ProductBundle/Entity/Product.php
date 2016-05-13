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
use WellCommerce\Bundle\AppBundle\Entity\Dimension;
use WellCommerce\Bundle\AppBundle\Entity\DiscountablePrice;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\AppBundle\Entity\Price;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroupInterface;
use WellCommerce\Bundle\AvailabilityBundle\Entity\AvailabilityAwareTrait;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\DoctrineBundle\Entity\AbstractEntity;
use WellCommerce\Bundle\MediaBundle\Entity\MediaAwareTrait;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\Extra\ProductExtraTrait;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareTrait;
use WellCommerce\Bundle\TaxBundle\Entity\TaxInterface;
use WellCommerce\Bundle\UnitBundle\Entity\UnitAwareTrait;

/**
 * Class Product
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Product extends AbstractEntity implements ProductInterface
{
    use Translatable;
    use Timestampable;
    use Blameable;
    use MediaAwareTrait;
    use EnableableTrait;
    use HierarchyAwareTrait;
    use ShopCollectionAwareTrait;
    use ProducerAwareTrait;
    use UnitAwareTrait;
    use AvailabilityAwareTrait;
    use ProductExtraTrait;

    /**
     * @var string
     */
    protected $sku = '';

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
    protected $reviews;

    /**
     * @var int
     */
    protected $stock = 0;

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
     * @var Collection
     */
    protected $variants;

    /**
     * @var AttributeGroupInterface
     */
    protected $attributeGroup;

    /**
     * @var bool
     */
    protected $trackStock = true;

    /**
     * @var float
     */
    protected $weight = 0;

    /**
     * @var Dimension
     */
    protected $dimension;

    /**
     * @var float
     */
    protected $packageSize = 1;

    /**
     * {@inheritdoc}
     */
    public function getSku() : string
    {
        return $this->sku;
    }

    /**
     * {@inheritdoc}
     */
    public function setSku(string $sku)
    {
        $this->sku = $sku;
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
    public function getTrackStock() : bool
    {
        return $this->trackStock;
    }

    /**
     * {@inheritdoc}
     */
    public function setTrackStock(bool $trackStock)
    {
        $this->trackStock = $trackStock;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatuses() : Collection
    {
        return $this->statuses;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatuses(Collection $statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * {@inheritdoc}
     */
    public function getProductPhotos() : Collection
    {
        return $this->productPhotos;
    }

    /**
     * {@inheritdoc}
     */
    public function setProductPhotos(Collection $photos)
    {
        $this->productPhotos = $photos;
    }

    /**
     * {@inheritdoc}
     */
    public function addProductPhoto(ProductPhoto $photo)
    {
        $this->productPhotos[] = $photo;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories() : Collection
    {
        return $this->categories;
    }

    /**
     * {@inheritdoc}
     */
    public function setCategories(Collection $collection)
    {
        $this->categories = $collection;
    }

    /**
     * {@inheritdoc}
     */
    public function addCategory(CategoryInterface $category)
    {
        $this->categories[] = $category;
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
    public function getBuyPrice() : Price
    {
        return $this->buyPrice;
    }

    /**
     * {@inheritdoc}
     */
    public function setBuyPrice(Price $buyPrice)
    {
        $this->buyPrice = $buyPrice;
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
    public function getDimension() : Dimension
    {
        return $this->dimension;
    }

    /**
     * {@inheritdoc}
     */
    public function setDimension(Dimension $dimension)
    {
        $this->dimension = $dimension;
    }

    /**
     * {@inheritdoc}
     */
    public function getPackageSize() : float
    {
        return $this->packageSize;
    }

    /**
     * {@inheritdoc}
     */
    public function setPackageSize(float $packageSize)
    {
        $this->packageSize = $packageSize;
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeGroup()
    {
        return $this->attributeGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function setAttributeGroup(AttributeGroupInterface $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function getVariants() : Collection
    {
        return $this->variants;
    }

    /**
     * {@inheritdoc}
     */
    public function setVariants(Collection $variants)
    {
        if ($this->variants instanceof Collection) {
            $this->synchronizeVariants($variants);
        }

        $this->variants = $variants;
    }

    protected function synchronizeVariants(Collection $variants)
    {
        $this->variants->map(function (VariantInterface $variant) use ($variants) {
            if (false === $variants->contains($variant)) {
                $this->removeVariant($variant);
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function removeVariant(VariantInterface $variant)
    {
        $this->variants->removeElement($variant);
    }

    /**
     * {@inheritdoc}
     */
    public function getBuyPriceTax() : TaxInterface
    {
        return $this->buyPriceTax;
    }

    /**
     * {@inheritdoc}
     */
    public function setBuyPriceTax(TaxInterface $buyPriceTax)
    {
        $this->buyPriceTax = $buyPriceTax;
    }

    /**
     * {@inheritdoc}
     */
    public function getSellPriceTax() : TaxInterface
    {
        return $this->sellPriceTax;
    }

    /**
     * {@inheritdoc}
     */
    public function setSellPriceTax(TaxInterface $sellPriceTax)
    {
        $this->sellPriceTax = $sellPriceTax;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostQuantity() : int
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostWeight() : float
    {
        return $this->weight;
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostGrossPrice() : float
    {
        return $this->sellPrice->getFinalGrossAmount();
    }

    /**
     * {@inheritdoc}
     */
    public function getShippingCostCurrency() : string
    {
        return $this->sellPrice->getCurrency();
    }

    /**
     * {@inheritdoc}
     */
    public function getReviews() : Collection
    {
        return $this->reviews;
    }
}
