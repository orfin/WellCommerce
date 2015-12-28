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

namespace WellCommerce\Bundle\ShippingBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class ShippingMethodManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShippingMethodManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('shipping_method.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\ShippingBundle\Manager\Admin\ShippingMethodManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\ShippingBundle\Form\Admin\ShippingMethodFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\ShippingBundle\DataGrid\ShippingMethodDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\ShippingBundle\Repository\ShippingMethodRepositoryInterface::class;
    }
}
