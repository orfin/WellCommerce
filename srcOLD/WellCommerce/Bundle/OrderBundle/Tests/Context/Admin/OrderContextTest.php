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

namespace WellCommerce\Bundle\OrderBundle\Tests\Context\Admin;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class OrderContextTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderContextTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory = $this->container->get('order.factory');
        $context = $this->container->get('order.context.admin');
        $order   = $factory->create();
        $this->assertNull($context->getCurrentOrder());

        $context->setCurrentOrder($order);
        $this->assertInstanceOf(\WellCommerce\Bundle\OrderBundle\Entity\OrderInterface::class, $context->getCurrentOrder());
        $this->assertEquals($order, $context->getCurrentOrder());
    }
}
