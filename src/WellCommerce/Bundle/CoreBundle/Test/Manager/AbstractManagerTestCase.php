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

namespace WellCommerce\Bundle\CoreBundle\Test\Manager;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\DoctrineBundle\Manager\Manager;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;

/**
 * Class AbstractManagerTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractManagerTestCase extends AbstractTestCase
{
    public function testManagerServiceIsValid()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getServiceClassName(), $manager);
    }

    public function testManagerReturnsValidRepository()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getRepositoryInterfaceName(), $manager->getRepository());
    }

    public function testManagerReturnsValidFactory()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getFactoryInterfaceName(), $manager->getFactory());
    }

    protected function getServiceClassName() : string
    {
        return Manager::class;
    }

    abstract protected function get() : ManagerInterface;

    abstract protected function getRepositoryInterfaceName() : string;

    abstract protected function getFactoryInterfaceName() : string;

}
