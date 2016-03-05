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

namespace WellCommerce\Bundle\LayoutBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class LayoutBoxManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('layout_box.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\LayoutBundle\Manager\Admin\LayoutBoxManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\LayoutBundle\Form\Admin\LayoutBoxFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\LayoutBundle\DataGrid\LayoutBoxDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\LayoutBundle\Repository\LayoutBoxRepositoryInterface::class;
    }
}
