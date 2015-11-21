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

namespace WellCommerce\CommonBundle\Tests\Manager\Admin;

use WellCommerce\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class TaxManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('tax.manager.admin');
    }

    protected function getServiceClassName()
    {
        return 'WellCommerce\CommonBundle\Manager\Admin\TaxManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\CommonBundle\Form\Admin\TaxFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\CommonBundle\DataGrid\TaxDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\CommonBundle\Repository\TaxRepositoryInterface';
    }
}
