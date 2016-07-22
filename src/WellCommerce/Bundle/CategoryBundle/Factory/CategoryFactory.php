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

namespace WellCommerce\Bundle\CategoryBundle\Factory;

use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CategoryBundle\Entity\CategoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Factory\AbstractEntityFactory;

/**
 * Class CategoryFactory
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryFactory extends AbstractEntityFactory
{
    public function create() : CategoryInterface
    {
        $category = new Category();
        $category->setEnabled(true);
        $category->setHierarchy(0);
        $category->setParent(null);
        $category->setShops($this->createEmptyCollection());
        $category->setChildren($this->createEmptyCollection());
        $category->setProducts($this->createEmptyCollection());
        $category->setProductsCount(0);
        $category->setChildrenCount(0);

        return $category;
    }
}
