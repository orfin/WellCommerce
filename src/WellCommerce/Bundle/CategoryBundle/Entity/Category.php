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

use Doctrine\Common\Collections\Collection;
use Knp\DoctrineBehaviors\Model\Blameable\Blameable;
use Knp\DoctrineBehaviors\Model\Timestampable\Timestampable;
use Knp\DoctrineBehaviors\Model\Translatable\Translatable;
use WellCommerce\Bundle\CoreBundle\Doctrine\ORM\Behaviours\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopCollectionAwareTrait;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class Category
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Category implements CategoryInterface
{
    use Translatable, Timestampable, Blameable, EnableableTrait, ShopCollectionAwareTrait, HierarchyAwareTrait;

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var null|CategoryInterface
     */
    protected $parent;

    /**
     * @var Collection
     */
    protected $children;

    /**
     * @var Collection
     */
    protected $products;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|CategoryInterface
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param CategoryInterface|null $parent
     */
    public function setParent(CategoryInterface $parent = null)
    {
        $this->parent = $parent;
    }

    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children)
    {
        $this->children = $children;
    }

    /**
     * @return Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param CategoryInterface $child
     */
    public function addChild(CategoryInterface $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }

    /**
     * @return Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Collection $products
     */
    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }

    /**
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product)
    {
        $this->products[] = $product;
    }
}
