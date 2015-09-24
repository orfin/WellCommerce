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

namespace WellCommerce\Bundle\TaxBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class TaxExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxExtensionTest extends AbstractExtensionTestCase
{
    public function testContainerHasRepositoryService()
    {
        $this->assertTrue($this->container->has('tax.repository'));
    }

    public function testContainerHasAdminManagerService()
    {
        $this->assertTrue($this->container->has('tax.manager.admin'));
    }

    public function testContainerHasAdminControllerService()
    {
        $this->assertTrue($this->container->has('tax.controller.admin'));
    }

    public function testContainerHasDatasetLoaderService()
    {
        $this->assertTrue($this->container->has('tax.dataset.loader'));
    }

    public function testContainerHasDatasetService()
    {
        $this->assertTrue($this->container->has('tax.dataset'));
    }

    public function testContainerHasDatagridService()
    {
        $this->assertTrue($this->container->has('tax.datagrid'));
    }

    public function testContainerHasFormBuilderService()
    {
        $this->assertTrue($this->container->has('tax.form_builder'));
    }
}
