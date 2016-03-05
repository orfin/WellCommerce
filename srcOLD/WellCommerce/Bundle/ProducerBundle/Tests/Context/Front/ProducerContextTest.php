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

namespace WellCommerce\Bundle\ProducerBundle\Tests\Context\Front;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class ProducerContextTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerContextTest extends AbstractTestCase
{
    public function testContextReturnsValidData()
    {
        $factory  = $this->container->get('producer.factory');
        $context  = $this->container->get('producer.context.front');
        $producer = $factory->create();
        $this->assertNull($context->getCurrentProducer());

        $context->setCurrentProducer($factory->create());
        $this->assertInstanceOf(\WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface::class, $context->getCurrentProducer());
        $this->assertEquals($producer, $context->getCurrentProducer());
    }
}
