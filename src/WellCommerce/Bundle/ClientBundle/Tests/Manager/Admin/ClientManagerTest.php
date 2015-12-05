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

namespace WellCommerce\Bundle\ClientBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class ClientManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('client.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\ClientBundle\Manager\Admin\ClientManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\ClientBundle\Form\Admin\ClientFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\ClientBundle\DataGrid\ClientDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\ClientBundle\Repository\ClientRepositoryInterface::class;
    }
}
