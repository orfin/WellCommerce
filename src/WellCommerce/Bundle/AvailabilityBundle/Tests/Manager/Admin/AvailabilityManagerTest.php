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

namespace WellCommerce\Bundle\AvailabilityBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class AvailabilityManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityManagerTest extends AbstractAdminManagerTestCase
{
    protected function getService()
    {
        return $this->container->get('availability.manager.admin');
    }

    protected function getServiceClassName()
    {
        return 'WellCommerce\Bundle\AvailabilityBundle\Manager\Admin\AvailabilityManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\Bundle\AvailabilityBundle\Form\AvailabilityFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\Bundle\AvailabilityBundle\DataGrid\AvailabilityDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\Bundle\AvailabilityBundle\Repository\AvailabilityRepositoryInterface';
    }
}
