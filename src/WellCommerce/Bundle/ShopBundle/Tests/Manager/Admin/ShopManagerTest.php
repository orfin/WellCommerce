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

namespace WellCommerce\Bundle\ShopBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class ShopManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('shop.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\ShopBundle\Manager\Admin\ShopManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\ShopBundle\Form\Admin\ShopFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\ShopBundle\DataGrid\ShopDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\ShopBundle\Repository\ShopRepositoryInterface::class;
    }
}
