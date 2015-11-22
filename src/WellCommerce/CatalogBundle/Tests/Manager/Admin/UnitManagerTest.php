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

namespace WellCommerce\CatalogBundle\Tests\Manager\Admin;

use WellCommerce\AppBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class UnitManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UnitManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('unit.manager.admin');
    }

    protected function getServiceClassName()
    {
        return 'WellCommerce\CatalogBundle\Manager\Admin\UnitManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\CatalogBundle\Form\Admin\UnitFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\CatalogBundle\DataGrid\UnitDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\CatalogBundle\Repository\UnitRepositoryInterface';
    }
}
