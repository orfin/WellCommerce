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

namespace WellCommerce\Bundle\WebBundle\Tests\Manager\Front;

use WellCommerce\Bundle\CoreBundle\Tests\AbstractTestCase;

/**
 * Class HomePageManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class HomePageManagerTest extends AbstractTestCase
{

    public function testGetCartProvider()
    {
        $manager = $this->container->get('home_page.manager.front');
        $this->assertInstanceOf(
            'WellCommerce\Bundle\CartBundle\Provider\CartProductProviderInterface',
            $manager->getCartProductProvider()
        );
    }

}