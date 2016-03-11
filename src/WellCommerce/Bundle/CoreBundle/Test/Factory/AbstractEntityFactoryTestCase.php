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

namespace WellCommerce\Bundle\CoreBundle\Test\Factory;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractEntityFactoryTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractEntityFactoryTestCase extends AbstractTestCase
{
    public function testImplementsProperInterface()
    {
        $factory = $this->getFactoryService();
        if (null !== $factory) {
            $this->assertInstanceOf('WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface', $factory);
        }
    }

    /**
     * @return \WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface
     */
    abstract protected function getFactoryService();

    public function testExpectedObjectIsReturned()
    {
        $factory = $this->getFactoryService();
        if (null !== $factory) {
            $this->assertInstanceOf($this->getExpectedInterface(), $factory->create());
        }
    }

    abstract protected function getExpectedInterface();
}
