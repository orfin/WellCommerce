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
use WellCommerce\Bundle\CoreBundle\Entity\BlameableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TimestampableInterface;
use WellCommerce\Bundle\CoreBundle\Entity\TranslatableInterface;
use WellCommerce\Bundle\MultiStoreBundle\Entity\ShopInterface;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Interface CategoryInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface CategoryInterface extends TranslatableInterface, TimestampableInterface, BlameableInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return int
     */
    public function getHierarchy();

    /**
     * @param int $hierarchy
     */
    public function setHierarchy($hierarchy);

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

    /**
     * @return Collection
     */
    public function getShops();

    /**
     * @param Collection $shops
     */
    public function setShops(Collection $shops);

    /**
     * @param ShopInterface $shop
     */
    public function addShop(ShopInterface $shop);
}
