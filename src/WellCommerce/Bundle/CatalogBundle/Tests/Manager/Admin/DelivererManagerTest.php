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

namespace WellCommerce\Bundle\CatalogBundle\Tests\Manager\Admin;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class DelivererManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('deliverer.manager.admin');
    }

    protected function getServiceClassName()
    {
        return 'WellCommerce\Bundle\CatalogBundle\Manager\Admin\DelivererManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\Bundle\CatalogBundle\Form\Admin\DelivererFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\Bundle\CatalogBundle\DataGrid\DelivererDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\Bundle\CatalogBundle\Repository\DelivererRepositoryInterface';
    }
}
