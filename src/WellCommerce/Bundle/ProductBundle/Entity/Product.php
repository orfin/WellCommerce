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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup;
use WellCommerce\Bundle\AvailabilityBundle\Entity\Availability;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\PhotoTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Dimension;
use WellCommerce\Bundle\CoreBundle\Entity\Price;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;
use WellCommerce\Bundle\UnitBundle\Entity\Unit;

/**
 * Class Product
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table(name="product")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\ProductBundle\Repository\ProductRepository")
 */
class Product
{
    use ORMBehaviors\Translatable\Translatable;
    use ORMBehaviors\Timestampable\Timestampable;
    use ORMBehaviors\Blameable\Blameable;
    use PhotoTrait;
    use EnableableTrait;
    use HierarchyTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="sku", type="string", length=64, unique=false)
     */
    protected $sku;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProducerBundle\Entity\Producer")
     * @ORM\JoinColumn(name="producer_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $producer;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\UnitBundle\Entity\Unit")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $unit;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\AvailabilityBundle\Entity\Availability")
     * @ORM\JoinColumn(name="availability_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $availability;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\CategoryBundle\Entity\Category", inversedBy="products")
     * @ORM\JoinTable(name="category_product",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $categories;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductStatus", inversedBy="products")
     * @ORM\JoinTable(name="product_product_status",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_status_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $statuses;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\MultiStoreBundle\Entity\Shop", inversedBy="products")
     * @ORM\JoinTable(name="shop_product",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $shops;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductPhoto", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    protected $productPhotos;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     */
    protected $attributes;

    /**
     * @var float
     *
     * @ORM\Column(name="stock", type="decimal", precision=15, scale=4)
     */
    protected $stock;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Price", columnPrefix = "buy_price_")
     */
    protected $buyPrice;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\TaxBundle\Entity\Tax")
     * @ORM\JoinColumn(name="buy_tax_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $buyPriceTax;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\DiscountablePrice", columnPrefix = "sell_price_")
     */
    protected $sellPrice;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\TaxBundle\Entity\Tax")
     * @ORM\JoinColumn(name="sell_tax_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $sellPriceTax;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup")
     * @ORM\JoinColumn(name="attribute_group_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $attributeGroup;

    /**
     * @var bool
     *
     * @ORM\Column(name="track_stock", type="boolean")
     */
    protected $trackStock;

    /**
     * @var float
     *
     * @ORM\Column(name="weight", type="decimal", precision=15, scale=4)
     */
    protected $weight;

    /**
     * @ORM\Embedded(class = "WellCommerce\Bundle\CoreBundle\Entity\Dimension", columnPrefix = "dimension_")
     */
    protected $dimension;

    /**
     * @var float
     *
     * @ORM\Column(name="package_size", type="decimal", precision=15, scale=4)
     */
    protected $packageSize;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories    = new ArrayCollection();
        $this->productPhotos = new ArrayCollection();
        $this->statuses      = new ArrayCollection();
        $this->attributes    = new ArrayCollection();
        $this->shops         = new ArrayCollection();
        $this->dimension     = new Dimension();
        $this->sellPrice     = new Price();
        $this->buyPrice      = new Price();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns product sku
     *
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Returns products sku
     *
     * @param $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
    }

    /**
     * Returns product producer
     *
     * @return mixed
     */
    public function getProducer()
    {
        return $this->producer;
    }

    /**
     * Sets product producer
     *
     * @param $producer
     */
    public function setProducer($producer)
    {
        $this->producer = $producer;
    }

    /**
     * Returns product stock
     *
     * @return mixed
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Sets product stock
     *
     * @param string $stock
     */
    public function setStock($stock)
    {
        $this->stock = (float)$stock;
    }

    /**
     * Returns product stock
     *
     * @return boolean
     */
    public function getTrackStock()
    {
        return $this->trackStock;
    }

    /**
     * Sets product stock tracking status
     *
     * @param boolean $trackStock
     */
    public function setTrackStock($trackStock)
    {
        $this->trackStock = $trackStock;
    }

    /**
     * Returns product producer
     *
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Sets product unit
     *
     * @param Unit $unit
     */
    public function setUnit(Unit $unit = null)
    {
        $this->unit = $unit;
    }

    /**
     * Returns product availability
     *
     * @return Availability
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Sets product availability
     *
     * @param Availability $availability
     */
    public function setAvailability(Availability $availability = null)
    {
        $this->availability = $availability;
    }

    /**
     * Returns product statuses
     *
     * @return ArrayCollection
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * Sets product statuses
     *
     * @param ArrayCollection $statuses
     */
    public function setStatuses(ArrayCollection $statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * Get product photos
     *
     * @return ArrayCollection
     */
    public function getProductPhotos()
    {
        return $this->productPhotos;
    }

    /**
     * Sets product photos
     *
     * @param ArrayCollection $photos
     */
    public function setProductPhotos(ArrayCollection $photos)
    {
        $this->productPhotos = $photos;
    }

    /**
     * Adds product photo
     *
     * @param ProductPhoto $photo
     */
    public function addProductPhoto(ProductPhoto $photo)
    {
        $this->productPhotos[] = $photo;
    }

    /**
     * Returns all available categories for product
     *
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Sets product category collection
     *
     * @param ArrayCollection $collection
     */
    public function setCategories(ArrayCollection $collection)
    {
        $this->categories = $collection;
    }

    /**
     * Adds new category to product
     *
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
    }

    /**
     * Returns product sell price
     *
     * @return \WellCommerce\Bundle\CoreBundle\Entity\Price
     */
    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    /**
     * Sets product sell price
     *
     * @param float $sellPrice
     */
    public function setSellPrice($sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    /**
     * Returns product buy price
     *
     * @return float
     */
    public function getBuyPrice()
    {
        return $this->buyPrice;
    }

    /**
     * Sets product buy price
     *
     * @param float $buyPrice
     */
    public function setBuyPrice($buyPrice)
    {
        $this->buyPrice = $buyPrice;
    }

    /**
     * Returns product weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Sets product weight
     *
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Entity\Dimension
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * @param mixed $dimension
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;
    }

    /**
     * Returns product package size
     *
     * @return float
     */
    public function getPackageSize()
    {
        return $this->packageSize;
    }

    /**
     * Sets product package size
     *
     * @param float $packageSize
     */
    public function setPackageSize($packageSize)
    {
        $this->packageSize = $packageSize;
    }

    /**
     * Returns attribute group to which product is bound
     *
     * @return AttributeGroup
     */
    public function getAttributeGroup()
    {
        return $this->attributeGroup;
    }

    /**
     * Sets attribute group for product
     *
     * @param AttributeGroup $attributeGroup
     */
    public function setAttributeGroup(AttributeGroup $attributeGroup)
    {
        $this->attributeGroup = $attributeGroup;
    }

    /**
     * Returns product attributes
     *
     * @return ArrayCollection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Sets product attributes and removes unneeded ones
     *
     * @param ArrayCollection $attributes
     */
    public function setAttributes(ArrayCollection $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return mixed
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * @param mixed $shops
     */
    public function setShops($shops)
    {
        $this->shops = $shops;
    }

    /**
     * @param Shop $shop
     */
    public function addShop(Shop $shop)
    {
        $this->shops[] = $shop;
    }

    /**
     * @return Tax
     */
    public function getBuyPriceTax()
    {
        return $this->buyPriceTax;
    }

    /**
     * @param Tax $buyPriceTax
     */
    public function setBuyPriceTax(Tax $buyPriceTax)
    {
        $this->buyPriceTax = $buyPriceTax;
    }

    /**
     * @return Tax
     */
    public function getSellPriceTax()
    {
        return $this->sellPriceTax;
    }

    /**
     * @param Tax $sellPriceTax
     */
    public function setSellPriceTax(Tax $sellPriceTax)
    {
        $this->sellPriceTax = $sellPriceTax;
    }
}
