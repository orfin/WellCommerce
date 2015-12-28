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
    public function testManagerServiceIsValid()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getServiceClassName(), $manager);
    }

    /**
     * @return \WellCommerce\Bundle\CoreBundle\Manager\Admin\AdminManagerInterface
     */
    abstract protected function get();

    /**
     * @return string
     */
    abstract protected function getServiceClassName();

    public function testManagerReturnsValidFormBuilder()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getFormBuilderClassName(), $manager->getFormBuilder());
    }

    /**
     * @return string
     */
    abstract protected function getFormBuilderClassName();

    public function testManagerReturnsValidRepository()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getRepositoryInterfaceName(), $manager->getRepository());
    }

    /**
     * @return string
     */
    abstract protected function getRepositoryInterfaceName();

    public function testManagerReturnsValidDataGrid()
    {
        $manager = $this->get();
        $this->assertInstanceOf($this->getDataGridClassName(), $manager->getDataGrid());
    }

    /**
     * @return string
     */
    abstract protected function getDataGridClassName();
}
