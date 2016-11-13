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
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareTrait;
use WellCommerce\Bundle\CategoryBundle\Entity\Extra\CategoryExtraTrait;
use WellCommerce\Bundle\CoreBundle\Behaviours\Enableable\EnableableTrait;
use WellCommerce\Bundle\CoreBundle\Entity\IdentifiableTrait;
use WellCommerce\Bundle\ShopBundle\Entity\ShopCollectionAwareTrait;

/**
 * Class Category
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Category implements CategoryInterface
{
    use IdentifiableTrait;
    use Translatable;
    use Timestampable;
    use Blameable;
    use EnableableTrait;
    use ShopCollectionAwareTrait;
    use HierarchyAwareTrait;
    use CategoryExtraTrait;
    
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
     * @var int
     */
    protected $productsCount;
    
    /**
     * @var int
     */
    protected $childrenCount;
    
    public function getParent()
    {
        return $this->parent;
    }
    
    public function setParent(CategoryInterface $parent = null)
    {
        $this->parent = $parent;
    }
    
    public function setChildren(Collection $children)
    {
        $this->children = $children;
    }
    
    public function getChildren() : Collection
    {
        return $this->children;
    }
    
    public function addChild(CategoryInterface $child)
    {
        $this->children[] = $child;
        $child->setParent($this);
    }
    
    public function getProducts() : Collection
    {
        return $this->products;
    }
    
    public function setProducts(Collection $products)
    {
        $this->products = $products;
    }
    
    public function getProductsCount() : int
    {
        return $this->productsCount;
    }
    
    public function setProductsCount(int $productsCount)
    {
        $this->productsCount = $productsCount;
    }
    
    public function getChildrenCount() : int
    {
        return $this->childrenCount;
    }
    
    public function setChildrenCount(int $childrenCount)
    {
        $this->childrenCount = $childrenCount;
    }
}
