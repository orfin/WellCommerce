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

namespace WellCommerce\Bundle\AppBundle\Entity;

use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\AppBundle\Entity\ShopCollectionAwareInterface;
use WellCommerce\Bundle\AppBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\AppBundle\Entity\HierarchyAwareInterface;
use WellCommerce\Bundle\AppBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\AppBundle\Entity\TranslatableInterface;

/**
 * Interface CategoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryInterface
    extends TranslatableInterface, TimestampableInterface, BlameableInterface, ShopCollectionAwareInterface, HierarchyAwareInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return null|CategoryInterface
     */
    public function getParent();

    /**
     * @param CategoryInterface|null $parent
     */
    public function setParent(CategoryInterface $parent = null);

    /**
     * @param Collection $children
     */
    public function setChildren(Collection $children);

    /**
     * @return Collection
     */
    public function getChildren();

    /**
     * @param CategoryInterface $child
     */
    public function addChild(CategoryInterface $child);

    /**
     * @return Collection
     */
    public function getProducts();

    /**
     * @param Collection $products
     */
    public function setProducts(Collection $products);

    /**
     * @param ProductInterface $product
     */
    public function addProduct(ProductInterface $product);
}
