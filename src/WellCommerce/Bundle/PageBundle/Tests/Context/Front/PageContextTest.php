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

namespace WellCommerce\Bundle\PageBundle\Tests\Context\Front;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Class PageContextTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageContextTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory = $this->container->get('page.factory');
        $context = $this->container->get('page.context.front');
        $page    = $factory->create();

        $context->setCurrentPage($factory->create());
        $this->assertInstanceOf(PageInterface::class, $context->getCurrentPage());
        $this->assertEquals($page, $context->getCurrentPage());
    }
}
