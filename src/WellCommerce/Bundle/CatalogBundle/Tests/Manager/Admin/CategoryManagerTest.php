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

use WellCommerce\Bundle\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

/**
 * Class CategoryManagerTest
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryManagerTest extends AbstractAdminManagerTestCase
{
    protected function get()
    {
        return $this->container->get('category.manager.admin');
    }

    protected function getServiceClassName()
    {
        return 'WellCommerce\Bundle\CatalogBundle\Manager\Admin\CategoryManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\Bundle\CatalogBundle\Form\Admin\CategoryFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\Bundle\CatalogBundle\DataGrid\CategoryDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\Bundle\CatalogBundle\Repository\CategoryRepositoryInterface';
    }

    public function testManagerReturnsValidDataGrid()
    {
        try {
            $datagrid = $this->get()->getDataGrid();
        } catch (\Exception $e) {
            $this->assertInstanceOf('WellCommerce\Bundle\CoreBundle\Exception\MissingDataGridException', $e);
        }
    }
}
