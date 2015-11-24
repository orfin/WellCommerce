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

namespace WellCommerce\AppBundle\Tests\Context\Front;

use WellCommerce\CoreBundle\Test\AbstractTestCase;

/**
 * Class ProductContextTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductContextTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory = $this->container->get('product.factory');
        $context = $this->container->get('product.context.front');
        $product = $factory->create();
        $this->assertNull($context->getCurrentProduct());

        $context->setCurrentProduct($factory->create());
        $this->assertInstanceOf('WellCommerce\AppBundle\Entity\ProductInterface', $context->getCurrentProduct());
        $this->assertEquals($product, $context->getCurrentProduct());
    }
}
