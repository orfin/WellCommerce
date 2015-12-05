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

namespace WellCommerce\Bundle\CategoryBundle\Tests\Manager\Admin;

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
        return \WellCommerce\Bundle\CategoryBundle\Manager\Admin\CategoryManager::class;
    }

    protected function getFormBuilderClassName()
    {
        return \WellCommerce\Bundle\CategoryBundle\Form\Admin\CategoryFormBuilder::class;
    }

    protected function getDataGridClassName()
    {
        return \WellCommerce\Component\DataGrid\DataGridInterface::class;
    }

    protected function getRepositoryInterfaceName()
    {
        return \WellCommerce\Bundle\CategoryBundle\Repository\CategoryRepositoryInterface::class;
    }

    public function testManagerReturnsValidDataGrid()
    {
        try {
            $this->get()->getDataGrid();
        } catch (\Exception $e) {
            $this->assertInstanceOf(\WellCommerce\Bundle\CoreBundle\Exception\MissingDataGridException::class, $e);
        }
    }
}
