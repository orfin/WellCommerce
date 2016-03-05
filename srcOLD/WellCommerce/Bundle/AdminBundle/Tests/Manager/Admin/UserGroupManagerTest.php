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

namespace WellCommerce\Bundle\AdminBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class UserManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserGroupManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('user_group.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\AdminBundle\Manager\Admin\UserGroupManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\AdminBundle\Form\Admin\UserGroupFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\AdminBundle\DataGrid\UserGroupDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\AdminBundle\Repository\UserGroupRepositoryInterface::class;
    }
}
