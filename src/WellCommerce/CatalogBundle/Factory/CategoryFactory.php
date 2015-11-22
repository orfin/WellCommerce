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

namespace WellCommerce\CatalogBundle\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\CatalogBundle\Entity\Category;
use WellCommerce\AppBundle\Factory\AbstractFactory;

/**
 * Class CategoryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryFactory extends AbstractFactory
{
    /**
     * @return Category
     */
    public function create()
    {
        $category = new Category();
        $category->setChildren(new ArrayCollection());
        $category->setProducts(new ArrayCollection());
        $category->setEnabled(true);
        $category->setHierarchy(0);
        $category->setParent(null);
        $category->setShops(new ArrayCollection());

        return $category;
    }
}
