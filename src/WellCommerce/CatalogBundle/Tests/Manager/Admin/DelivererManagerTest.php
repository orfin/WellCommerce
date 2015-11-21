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

use WellCommerce\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

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
        return 'WellCommerce\CatalogBundle\Manager\Admin\DelivererManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\CatalogBundle\Form\Admin\DelivererFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\CatalogBundle\DataGrid\DelivererDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\CatalogBundle\Repository\DelivererRepositoryInterface';
    }
}
