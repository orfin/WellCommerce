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

namespace WellCommerce\Bundle\CompanyBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class CompanyManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('company.manager.admin');
    }

    protected function getServiceClassName()
    {
        return \WellCommerce\Bundle\CompanyBundle\Manager\Admin\CompanyManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\CompanyBundle\Form\Admin\CompanyFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Bundle\CompanyBundle\DataGrid\CompanyDataGrid::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\CompanyBundle\Repository\CompanyRepositoryInterface::class;
    }
}
