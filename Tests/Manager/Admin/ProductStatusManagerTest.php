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

namespace WellCommerce\Bundle\ProductStatusBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class ProductStatusManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductStatusManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('product_status.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\ProductStatusBundle\Manager\Admin\ProductStatusManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\ProductStatusBundle\Form\Admin\ProductStatusFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\ProductStatusBundle\DataGrid\ProductStatusDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\ProductStatusBundle\Repository\ProductStatusRepositoryInterface::class;
    }
}
