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

namespace WellCommerce\Bundle\DelivererBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class DelivererManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('deliverer.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\DelivererBundle\Manager\Admin\DelivererManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\DelivererBundle\Form\Admin\DelivererFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\DelivererBundle\DataGrid\DelivererDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\DelivererBundle\Repository\DelivererRepositoryInterface::class;
    }
}
