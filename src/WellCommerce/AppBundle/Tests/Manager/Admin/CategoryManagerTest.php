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

namespace WellCommerce\AppBundle\Tests\Manager\Admin;

use WellCommerce\CoreBundle\Test\Manager\Admin\AbstractAdminManagerTestCase;

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
        return 'WellCommerce\AppBundle\Manager\Admin\CategoryManager';
    }

    protected function getFormBuilderClassName()
    {
        return 'WellCommerce\AppBundle\Form\Admin\CategoryFormBuilder';
    }

    protected function getDataGridClassName()
    {
        return 'WellCommerce\AppBundle\DataGrid\CategoryDataGrid';
    }

    protected function getRepositoryInterfaceName()
    {
        return 'WellCommerce\AppBundle\Repository\CategoryRepositoryInterface';
    }

    public function testManagerReturnsValidDataGrid()
    {
        try {
            $datagrid = $this->get()->getDataGrid();
        } catch (\Exception $e) {
            $this->assertInstanceOf('WellCommerce\AppBundle\Exception\MissingDataGridException', $e);
        }
    }
}
