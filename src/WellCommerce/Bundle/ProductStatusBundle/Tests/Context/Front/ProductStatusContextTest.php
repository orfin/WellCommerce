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
 * Class ProductStatusContextTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusContextTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory = $this->container->get('product_status.factory');
        $context = $this->container->get('product_status.context.front');
        $status  = $factory->create();

        $context->setCurrentProductStatus($status);
        $this->assertInstanceOf(ProductStatusInterface::class, $context->getCurrentProductStatus());
        $this->assertEquals($status, $context->getCurrentProductStatus());
    }
}
