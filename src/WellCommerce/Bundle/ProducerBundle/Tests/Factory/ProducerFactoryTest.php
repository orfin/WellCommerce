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

namespace WellCommerce\Bundle\ProducerBundle\Tests\Factory;

use WellCommerce\Bundle\CoreBundle\Test\Factory\AbstractEntityFactoryTestCase;

/**
 * Class ProducerFactoryTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProducerFactoryTest extends AbstractEntityFactoryTestCase
{
    protected function getFactoryService()
    {
        return $this->container->get('producer.factory');
    }

    protected function getExpectedInterface()
    {
        return 'WellCommerce\Bundle\ProducerBundle\Entity\ProducerInterface';
    }
}
