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

namespace WellCommerce\Bundle\AvailabilityBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class AvailabilityExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityExtensionTest extends AbstractExtensionTestCase
{
    public function testContainerHasRepositoryService()
    {
        $this->assertTrue($this->container->has('availability.repository'));
    }

    public function testContainerHasAdminManagerService()
    {
        $this->assertTrue($this->container->has('availability.manager.admin'));
    }

    public function testContainerHasAdminControllerService()
    {
        $this->assertTrue($this->container->has('availability.controller.admin'));
    }

    public function testContainerHasDatasetLoaderService()
    {
        $this->assertTrue($this->container->has('availability.dataset.loader'));
    }

    public function testContainerHasDatasetService()
    {
        $this->assertTrue($this->container->has('availability.dataset'));
    }

    public function testContainerHasCollectionService()
    {
        $this->assertTrue($this->container->has('availability.dataset'));
    }

    public function testContainerHasDatagridService()
    {
        $this->assertTrue($this->container->has('availability.datagrid'));
    }

    public function testContainerHasFormBuilderService()
    {
        $this->assertTrue($this->container->has('availability.form_builder'));
    }
}
