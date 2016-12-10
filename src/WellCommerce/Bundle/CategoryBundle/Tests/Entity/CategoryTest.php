<?php
/**
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */

namespace WellCommerce\Bundle\CategoryBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use WellCommerce\Bundle\CategoryBundle\Entity\Category;
use WellCommerce\Bundle\CoreBundle\Test\Entity\AbstractEntityTestCase;
use WellCommerce\Bundle\ProductBundle\Entity\Product;
use WellCommerce\Bundle\ShopBundle\Entity\Shop;

/**
 * Class CategoryTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryTest extends AbstractEntityTestCase
{
    protected function createEntity()
    {
        return new Category();
    }
    
    public function providerTestAccessor()
    {
        return [
            ['shops', new ArrayCollection()],
            ['shops', new ArrayCollection([new Shop()])],
            ['children', new ArrayCollection()],
            ['children', new ArrayCollection([new Category()])],
            ['products', new ArrayCollection()],
            ['products', new ArrayCollection([new Product()])],
            ['parent', null],
            ['parent', new Category()],
            ['productsCount', rand(0, 100)],
            ['childrenCount', rand(0, 100)],
            ['createdAt', new \DateTime()],
            ['updatedAt', new \DateTime()],
        ];
    }
}
