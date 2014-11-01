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
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\PhotoTrait;
use WellCommerce\Bundle\IntlBundle\Entity\Currency;
use WellCommerce\Bundle\TaxBundle\Entity\Tax;
use WellCommerce\Bundle\UnitBundle\Entity\Unit;

/**
 * Class Product
 *
 * @package WellCommerce\Bundle\ProductBundle\Entity
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
    private $id;

    /**
     * @ORM\Column(name="sku", type="string", length=64, unique=false)
     */
    private $sku;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\ProducerBundle\Entity\Producer")
     * @ORM\JoinColumn(name="producer_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $producer;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\TaxBundle\Entity\Tax")
     * @ORM\JoinColumn(name="tax_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $tax;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\UnitBundle\Entity\Unit")
     * @ORM\JoinColumn(name="unit_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $unit;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\AvailabilityBundle\Entity\Availability")
     * @ORM\JoinColumn(name="availability_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $availability;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\CategoryBundle\Entity\Category", inversedBy="products")
     * @ORM\JoinTable(name="category_product",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductStatus", inversedBy="products")
     * @ORM\JoinTable(name="product_product_status",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="product_status_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $statuses;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductPhoto", mappedBy="product", cascade={"persist"}, orphanRemoval=true)
     */
    private $productPhotos;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\ProductAttribute", mappedBy="product", cascade={"all"}, orphanRemoval=true)
     */
    private $attributes;

    /**
     * @var string
     *
     * @ORM\Column(name="stock", type="decimal", precision=15, scale=4)
     */
    private $stock;

    /**
     * @var string
     *
     * @ORM\Column(name="buy_price", type="decimal", precision=15, scale=4)
     */
    private $buyPrice;

    /**
     * @var string
     *
     * @ORM\Column(name="sell_price", type="decimal", precision=15, scale=4)
     */
    private $sellPrice;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\IntlBundle\Entity\Currency")
     * @ORM\JoinColumn(name="buy_currency_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $buyCurrency;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\AttributeBundle\Entity\AttributeGroup")
     * @ORM\JoinColumn(name="attribute_group_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $attributeGroup;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\IntlBundle\Entity\Currency")
     * @ORM\JoinColumn(name="sell_currency_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $sellCurrency;

    /**
     * @var bool
     *
     * @ORM\Column(name="track_stock", type="boolean")
     */
    private $trackStock;

    /**
     * @var string
     *
     * @ORM\Column(name="weight", type="decimal", precision=15, scale=4)
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="width", type="decimal", precision=15, scale=4)
     */
    private $width;

    /**
     * @var string
     *
     * @ORM\Column(name="height", type="decimal", precision=15, scale=4)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="depth", type="decimal", precision=15, scale=4)
     */
    private $depth;

    /**
     * @var string
     *
     * @ORM\Column(name="package_size", type="decimal", precision=15, scale=4)
     */
    private $packageSize;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categories    = new ArrayCollection();
        $this->categories    = new ArrayCollection();
        $this->productPhotos = new ArrayCollection();
        $this->statuses      = new ArrayCollection();
        $this->attributes    = new ArrayCollection();
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
     * Returns product tax
     *
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * Sets product tax
     *
     * @param Tax $tax
     */
    public function setTax(Tax $tax)
    {
        $this->tax = $tax;
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
        $this->stock = $stock;
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
     * @param array $data Data passed from transformer
     *
     * @return bool
     */
    public function setProductPhotos(array $data)
    {
        $params        = $data['data'];
        $collection    = $data['collection'];
        $productPhotos = new ArrayCollection();

        // if collection was not modified, do nothing
        if ($params['unmodified'] == 1) {
            return false;
        }

        foreach ($collection as $photo) {
            $mainPhoto    = (int)($photo->getId() == $params['main']);
            $productPhoto = new ProductPhoto();
            $productPhoto->setPhoto($photo);
            $productPhoto->setMainPhoto($mainPhoto);
            $productPhoto->setProduct($this);
            $productPhotos->add($productPhoto);

            // ad main photo as product default photo
            if ($mainPhoto == 1) {
                $this->setPhoto($photo);
            }
        }

        // loop through old photos and remove those which haven't been submitted
        foreach ($this->productPhotos as $oldPhoto) {
            if (!$productPhotos->contains($oldPhoto)) {
                $this->productPhotos->removeElement($oldPhoto);
            }
        }

        // if we don't have any photos, reset main product photo
        if ($productPhotos->count() == 0) {
            $this->setPhoto(null);
        }
        $this->productPhotos = $productPhotos;
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
     * Returns buy currency
     *
     * @return Currency
     */
    public function getBuyCurrency()
    {
        return $this->buyCurrency;
    }

    /**
     * Sets buy currency for product
     *
     * @param Currency $buyCurrency
     */
    public function setBuyCurrency(Currency $buyCurrency)
    {
        $this->buyCurrency = $buyCurrency;
    }

    /**
     * Returns sell currency
     *
     * @return Currency
     */
    public function getSellCurrency()
    {
        return $this->sellCurrency;
    }

    /**
     * Sets sell currency for product
     *
     * @param Currency $sellCurrency
     */
    public function setSellCurrency($sellCurrency)
    {
        $this->sellCurrency = $sellCurrency;
    }

    /**
     * Returns product sell price
     *
     * @return float
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
     * Returns product width
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Sets product width
     *
     * @param float $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
    }

    /**
     * Returns product height
     *
     * @return float
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Sets product height
     *
     * @param float $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
    }

    /**
     * Returns product depth
     *
     * @return float
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Sets product depth
     *
     * @param float $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
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
        foreach ($this->attributes as $attribute) {
            if (!$attributes->contains($attribute)) {
                $this->attributes->removeElement($attribute);
            }
        }

        foreach ($attributes as $attribute) {
            $attribute->setProduct($this);
        }

        $this->attributes = $attributes;
    }
}

