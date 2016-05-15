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

namespace WellCommerce\Bundle\ProductBundle\Tests\Context\Front;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\ProductBundle\Entity\ProductInterface;

/**
 * Class ProductStorageTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStorageTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory = $this->container->get('product.factory');
        $storage = $this->container->get('product.storage');
        $product = $factory->create();

        $storage->setCurrentProduct($factory->create());
        $this->assertInstanceOf(ProductInterface::class, $storage->getCurrentProduct());
        $this->assertEquals($product, $storage->getCurrentProduct());
    }
}
