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

namespace WellCommerce\Bundle\CouponBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class CouponManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('coupon.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\CouponBundle\Manager\Admin\CouponManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\CouponBundle\Form\Admin\CouponFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\CouponBundle\DataGrid\CouponDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\CouponBundle\Repository\CouponRepositoryInterface::class;
    }
}
