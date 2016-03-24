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

namespace WellCommerce\Bundle\CurrencyBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class CurrencyManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('currency.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\CurrencyBundle\Manager\Admin\CurrencyManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\CurrencyBundle\Form\Admin\CurrencyFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\CurrencyBundle\DataGrid\CurrencyDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\CurrencyBundle\Repository\CurrencyRepositoryInterface::class;
    }
}
