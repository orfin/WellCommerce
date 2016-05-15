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

namespace WellCommerce\Bundle\PageBundle\Tests\Storage;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\PageBundle\Entity\PageInterface;

/**
 * Class PageStorageTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageStorageTest extends AbstractTestCase
{
    public function testStorageReturnsValidData()
    {
        $factory = $this->container->get('page.factory');
        $storage = $this->container->get('page.storage');
        $page    = $factory->create();

        $storage->setCurrentPage($factory->create());
        $this->assertInstanceOf(PageInterface::class, $storage->getCurrentPage());
        $this->assertEquals($page, $storage->getCurrentPage());
    }
}
