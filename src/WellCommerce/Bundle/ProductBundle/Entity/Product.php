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
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\HierarchyTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\MetaDataTrait;
use WellCommerce\Bundle\CoreBundle\Entity\Behaviours\PhotoTrait;
use WellCommerce\Bundle\DelivererBundle\Entity\Deliverer;
use WellCommerce\Bundle\ShopBundle\Entity\Shop;

/**
 * Class Locale
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
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ShopBundle\Entity\Shop", inversedBy="products")
     * @ORM\JoinTable(name="shop_product",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $shops;

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
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\CurrencyBundle\Entity\Currency")
     * @ORM\JoinColumn(name="buy_currency_id", referencedColumnName="id", onDelete="SET NULL")
     */
    private $buyCurrency;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\CurrencyBundle\Entity\Currency")
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
        $this->shops         = new ArrayCollection();
        $this->categories    = new ArrayCollection();
        $this->categories    = new ArrayCollection();
        $this->productPhotos = new ArrayCollection();
        $this->statuses      = new ArrayCollection();
    }

    /**
     * Get id.
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
     * Returns product producer
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
     * @param $tax
     */
    public function setTax($tax)
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
     * @param $stock
     */
    public function setStock($stock)
    {
        $this->stock = $stock;
    }

    /**
     * Returns product stock
     *
     * @return mixed
     */
    public function getTrackStock()
    {
        return $this->trackStock;
    }

    /**
     * Sets product stock tracking status
     *
     * @param $trackStock
     */
    public function setTrackStock($trackStock)
    {
        $this->trackStock = $trackStock;
    }

    /**
     * Returns product producer
     *
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Sets product unit
     *
     * @param $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * Returns product availability
     *
     * @return mixed
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Sets product availability status
     *
     * @param $availability
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;
    }

    /**
     * Sets shops for product
     *
     * @param ArrayCollection $shops
     */
    public function setShops(ArrayCollection $shops)
    {
        $this->shops = $shops;
    }

    /**
     * Get shops for product
     *
     * @return mixed
     */
    public function getShops()
    {
        return $this->shops;
    }

    /**
     * Adds product to shop
     *
     * @param Shop $shop
     */
    public function addShop(Shop $shop)
    {
        $this->shops[] = $shop;
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
     * Returns product statuses
     *
     * @return mixed
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * Get product photos
     *
     * @return mixed
     */
    public function getProductPhotos()
    {
        return $this->productPhotos;
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
     * Sets product photos
     *
     * @param ArrayCollection $photos
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
     * Returns all available categories for product
     *
     * @return ArrayCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Adds new category to product
     *
     * @param Deliverer $deliverer
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;
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

    public function getBuyCurrency()
    {
        return $this->buyCurrency;
    }

    public function setBuyCurrency($buyCurrency)
    {
        $this->buyCurrency = $buyCurrency;
    }

    public function getSellCurrency()
    {
        return $this->sellCurrency;
    }

    public function setSellCurrency($sellCurrency)
    {
        $this->sellCurrency = $sellCurrency;
    }

    public function getSellPrice()
    {
        return $this->sellPrice;
    }

    public function setSellPrice($sellPrice)
    {
        $this->sellPrice = $sellPrice;
    }

    public function getBuyPrice()
    {
        return $this->buyPrice;
    }

    public function setBuyPrice($buyPrice)
    {
        $this->buyPrice = $buyPrice;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height)
    {
        $this->height = $height;
    }

    public function getDepth()
    {
        return $this->depth;
    }

    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    public function getPackageSize()
    {
        return $this->packageSize;
    }

    public function setPackageSize($packageSize)
    {
        $this->packageSize = $packageSize;
    }
}

