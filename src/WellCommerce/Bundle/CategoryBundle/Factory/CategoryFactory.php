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

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\AppBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Factory\AbstractFactory;

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
