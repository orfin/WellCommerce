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

namespace WellCommerce\Bundle\TaxBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

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
        return 'WellCommerce\Bundle\TaxBundle\Manager\Admin\TaxManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\Bundle\TaxBundle\Form\TaxFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\Bundle\TaxBundle\DataGrid\TaxDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\Bundle\TaxBundle\Repository\TaxRepositoryInterface';
    }
}
