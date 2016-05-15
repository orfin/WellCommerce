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

namespace WellCommerce\Bundle\ProducerBundle\Tests\Storage;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface;

/**
 * Class ProducerStorageTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerStorageTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory  = $this->container->get('producer.factory');
        $storage  = $this->container->get('producer.storage');
        $producer = $factory->create();

        $storage->setCurrentProducer($factory->create());
        $this->assertInstanceOf(ProducerInterface::class, $storage->getCurrentProducer());
        $this->assertEquals($producer, $storage->getCurrentProducer());
    }
}
