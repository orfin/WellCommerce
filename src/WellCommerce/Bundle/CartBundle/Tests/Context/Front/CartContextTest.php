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

namespace WellCommerce\Bundle\CartBundle\Tests\Context\Front;

use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class CartContextTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CartContextTest extends AbstractTestCase
{
    public function testCartContextReturnsData()
    {
        $context = $this->container->get('cart.context.front');
        $this->assertNull($context->getCurrentCart());

        $context->setCurrentCart(new Cart());
        $this->assertInstanceOf('WellCommerce\Bundle\CartBundle\Entity\CartInterface', $context->getCurrentCart());
    }
}
