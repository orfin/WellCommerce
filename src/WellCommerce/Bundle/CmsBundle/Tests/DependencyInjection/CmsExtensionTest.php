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

namespace WellCommerce\Bundle\CmsBundle\Tests\DependencyInjection;

use WellCommerce\Bundle\CoreBundle\Test\DependencyInjection\AbstractExtensionTestCase;

/**
 * Class ContactExtensionTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactExtensionTest extends AbstractExtensionTestCase
{
    public function testContainerHasRepositoryService()
    {
        $this->assertTrue($this->container->has('contact.repository'));
        $this->assertTrue($this->container->has('page.repository'));
        $this->assertTrue($this->container->has('news.repository'));
    }

    public function testContainerHasAdminManagerService()
    {
        $this->assertTrue($this->container->has('contact.manager.admin'));
        $this->assertTrue($this->container->has('page.manager.admin'));
        $this->assertTrue($this->container->has('page.manager.front'));
        $this->assertTrue($this->container->has('news.manager.admin'));
    }

    public function testContainerHasAdminControllerService()
    {
        $this->assertTrue($this->container->has('contact.controller.admin'));
        $this->assertTrue($this->container->has('page.controller.admin'));
        $this->assertTrue($this->container->has('page.controller.front'));
        $this->assertTrue($this->container->has('news.controller.admin'));
    }

    public function testContainerHasDatasetLoaderService()
    {
        $this->assertTrue($this->container->has('contact.dataset.loader'));
        $this->assertTrue($this->container->has('page.dataset.loader.admin'));
        $this->assertTrue($this->container->has('page.dataset.loader.front'));
        $this->assertTrue($this->container->has('news.dataset.loader'));
    }

    public function testContainerHasDatasetService()
    {
        $this->assertTrue($this->container->has('contact.dataset'));
        $this->assertTrue($this->container->has('page.dataset.admin'));
        $this->assertTrue($this->container->has('page.dataset.front'));
        $this->assertTrue($this->container->has('news.dataset'));
    }

    public function testContainerHasDatagridService()
    {
        $this->assertTrue($this->container->has('contact.datagrid'));
        $this->assertTrue($this->container->has('page.datagrid'));
        $this->assertTrue($this->container->has('news.datagrid'));
    }

    public function testContainerHasFormBuilderService()
    {
        $this->assertTrue($this->container->has('contact.form_builder'));
        $this->assertTrue($this->container->has('page.form_builder'));
        $this->assertTrue($this->container->has('news.form_builder'));
    }
}
