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
use WellCommerce\Bundle\DoctrineBundle\Factory\EntityFactoryInterface;
use WellCommerce\Bundle\DoctrineBundle\Manager\ManagerInterface;
use WellCommerce\Bundle\DoctrineBundle\Repository\RepositoryInterface;

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
        $this->assertInstanceOf($this->getManagerInterfaceName(), $manager);
    }

    public function testManagerReturnsValidRepository()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getRepositoryInterfaceClass(), $manager->getRepository());
    }

    public function testManagerReturnsValidFactory()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getFactoryInterfaceClass(), $manager->getFactory());
    }

    protected function getManagerInterfaceName() : string
    {
        return ManagerInterface::class;
    }

    protected function getRepositoryInterfaceClass() : string
    {
        return RepositoryInterface::class;
    }

    protected function getFactoryInterfaceClass() : string
    {
        return EntityFactoryInterface::class;
    }

    abstract protected function get() : ManagerInterface;


}
