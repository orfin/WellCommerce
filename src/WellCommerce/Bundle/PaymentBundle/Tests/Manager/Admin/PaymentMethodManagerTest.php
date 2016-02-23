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

namespace WellCommerce\Bundle\PaymentBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class PaymentMethodManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('payment_method.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\PaymentBundle\Manager\Admin\PaymentMethodManager::class;
    }
    
    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\PaymentBundle\Form\Admin\PaymentMethodFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\PaymentBundle\DataGrid\PaymentMethodDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\PaymentBundle\Repository\PaymentMethodRepositoryInterface::class;
    }
}
