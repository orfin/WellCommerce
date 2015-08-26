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

namespace WellCommerce\Bundle\CoreBundle\Test\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractAdminManagerTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractAdminManagerTestCase extends AbstractTestCase
{
    /**
     * @return \WellCommerce\Bundle\AdminBundle\Manager\AdminManagerInterface
     */
    abstract protected function getService();

    /**
     * @return string
     */
    abstract protected function getServiceClassName();

    /**
     * @return string
     */
    abstract protected function getFormBuilderClassName();

    /**
     * @return string
     */
    abstract protected function getDataGridClassName();

    /**
     * @return string
     */
    abstract protected function getRepositoryInterfaceName();

    public function testManagerServiceIsValid()
    {
        $manager = $this->getService();
        $this->assertInstanceOf($this->getServiceClassName(), $manager);
    }

    public function testManagerReturnsValidFormBuilder()
    {
        $manager = $this->getService();
        $this->assertInstanceOf($this->getFormBuilderClassName(), $manager->getFormBuilder());
    }

    public function testManagerReturnsValidRepository()
    {
        $manager = $this->getService();
        $this->assertInstanceOf($this->getRepositoryInterfaceName(), $manager->getRepository());
    }

    public function testManagerReturnsValidDataGrid()
    {
        $manager = $this->getService();
        $this->assertInstanceOf($this->getDataGridClassName(), $manager->getDataGrid());
    }
}
