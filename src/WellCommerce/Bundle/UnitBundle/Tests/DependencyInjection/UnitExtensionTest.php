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

namespace WellCommerce\Bundle\UnitBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class UnitExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitExtensionTest extends AbstractExtensionTestCase
{
    public function testContainerHasRepositoryService()
    {
        $this->assertTrue($this->container->has('unit.repository'));
    }

    public function testContainerHasAdminManagerService()
    {
        $this->assertTrue($this->container->has('unit.manager.admin'));
    }

    public function testContainerHasAdminControllerService()
    {
        $this->assertTrue($this->container->has('unit.controller.admin'));
    }

    public function testContainerHasDatasetLoaderService()
    {
        $this->assertTrue($this->container->has('unit.dataset.loader'));
    }

    public function testContainerHasDatasetService()
    {
        $this->assertTrue($this->container->has('unit.dataset'));
    }

    public function testContainerHasDatagridService()
    {
        $this->assertTrue($this->container->has('unit.datagrid'));
    }

    public function testContainerHasFormBuilderService()
    {
        $this->assertTrue($this->container->has('unit.form_builder'));
    }
}
