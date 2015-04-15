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

namespace WellCommerce\Bundle\CategoryBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\CategoryBundle\Entity\Extra\CategoryExtraTrait;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\EnableableTrait;
use WellCommerce\Bundle\MultiStoreBundle\Entity\Shop;
use WellCommerce\Bundle\ProductBundle\Entity\Product;

/**
 * Class Category
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 *
 * @ORM\Table("category")
 * @ORM\Entity(repositoryClass="WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepository")
 */
class Category
{
    use Translatable;
    use Timestampable;
    use Blameable;
    use EnableableTrait;
    use CategoryExtraTrait;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="hierarchy", type="integer", options={"default" = 0})
     */
    private $hierarchy;

    /**
     * @ORM\ManyToOne(targetEntity="WellCommerce\Bundle\CategoryBundle\Entity\Category", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="WellCommerce\Bundle\CategoryBundle\Entity\Category", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\ProductBundle\Entity\Product", mappedBy="categories")
     */
    private $products;

    /**
     * @ORM\ManyToMany(targetEntity="WellCommerce\Bundle\MultiStoreBundle\Entity\Shop", inversedBy="categories")
     * @ORM\JoinTable(name="shop_category",
     *      joinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="shop_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    private $shops;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->shops    = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns hierarchy for category
     *
     * @return int
     */
    public function getHierarchy()
    {
        return $this->hierarchy;
    }

    /**
     * Sets hierarchy for category
     *
     * @param $hierarchy
     */
    public function setHierarchy($hierarchy)
    {
        $this->hierarchy = $hierarchy;
    }

    /**
     * Returns category parent
     *
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets category parent
     *
     * @param null|Category $parent
     */
    public function setParent(Category $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * Returns category children
     *
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Adds new child to category
     *
     * @param Category $child
     */
    public function addChild(Category $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    /**
     * Get products in category
     *
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;
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
}
