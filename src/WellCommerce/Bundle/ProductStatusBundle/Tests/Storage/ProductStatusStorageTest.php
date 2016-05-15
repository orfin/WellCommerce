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

namespace WellCommerce\Bundle\ProductStatusBundle\Tests\Context\Front;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\ProductStatusBundle\Entity\ProductStatusInterface;

/**
 * Class ProductStatusStorageTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusStorageTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory = $this->container->get('product_status.factory');
        $storage = $this->container->get('product_status.storage');
        $status  = $factory->create();

        $storage->setCurrentProductStatus($status);
        $this->assertInstanceOf(ProductStatusInterface::class, $storage->getCurrentProductStatus());
        $this->assertEquals($status, $storage->getCurrentProductStatus());
    }
}
