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

namespace WellCommerce\Bundle\CartBundle\Tests\Provider;


use WellCommerce\Bundle\CartBundle\Entity\Cart;
use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

class CartProviderTest extends AbstractTestCase
{
    public function testCartIsAccessible()
    {
        $provider = $this->container->get('cart.manager.front')->getCartProvider();
        $provider->setCurrentResource(new Cart());

        $this->assertInstanceOf(
            'WellCommerce\Bundle\CartBundle\Entity\Cart',
            $provider->getCurrentResource()
        );
    }
}
