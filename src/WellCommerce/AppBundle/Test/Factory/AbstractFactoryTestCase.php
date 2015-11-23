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

namespace WellCommerce\AppBundle\Test\Factory;

use WellCommerce\AppBundle\Test\AbstractTestCase;

/**
 * Class AbstractFactoryTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractFactoryTestCase extends AbstractTestCase
{
    /**
     * @return \WellCommerce\AppBundle\Factory\FactoryInterface
     */
    abstract protected function getFactoryService();

    abstract protected function getExpectedInterface();

    public function testImplementsProperInterface()
    {
        $factory = $this->getFactoryService();
        if (null !== $factory) {
            $this->assertInstanceOf('WellCommerce\AppBundle\Factory\FactoryInterface', $factory);
        }
    }

    public function testExpectedObjectIsReturned()
    {
        $factory = $this->getFactoryService();
        if (null !== $factory) {
            $this->assertInstanceOf($this->getExpectedInterface(), $factory->create());
        }
    }
}
