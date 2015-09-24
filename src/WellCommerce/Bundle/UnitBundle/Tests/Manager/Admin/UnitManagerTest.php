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

namespace WellCommerce\Bundle\UnitBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

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
        return 'WellCommerce\Bundle\UnitBundle\Manager\Admin\UnitManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\Bundle\UnitBundle\Form\UnitFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\Bundle\UnitBundle\DataGrid\UnitDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\Bundle\UnitBundle\Repository\UnitRepositoryInterface';
    }
}
