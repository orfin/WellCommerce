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

namespace WellCommerce\SalesBundle\Tests\Context\Front;

use WellCommerce\CoreBundle\Test\AbstractTestCase;

/**
 * Class CartContextTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartContextTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory = $this->container->get('cart.factory');
        $context = $this->container->get('cart.context.front');
        $cart    = $factory->create();
        $this->assertNull($context->getCurrentCart());

        $context->setCurrentCart($cart);
        $this->assertInstanceOf(\WellCommerce\SalesBundle\Entity\CartInterface::class, $context->getCurrentCart());
        $this->assertEquals($cart, $context->getCurrentCart());
    }
}
