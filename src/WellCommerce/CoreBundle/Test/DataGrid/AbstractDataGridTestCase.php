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

namespace WellCommerce\CoreBundle\Test\DataGrid;

use WellCommerce\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Component\DataGrid\Column\Column;

/**
 * Class AbstractDataGridTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGridTestCase extends AbstractTestCase
{
    /**
     * @return null|\WellCommerce\Component\DataGrid\DataGridInterface
     */
    protected function getDataGrid()
    {
        return null;
    }

    /**
     * @return array
     */
    protected function getColumns()
    {
        return [];
    }

    public function testDatagridServiceIsCreated()
    {
        $datagrid = $this->getDataGrid();

        if (null !== $datagrid) {
            $this->assertInstanceOf('WellCommerce\Component\DataGrid\DataGridInterface', $datagrid);
        }
    }

    public function testDatagridColumnsCollectionIsConfigurable()
    {
        $datagrid = $this->getDataGrid();

        if (null !== $datagrid) {
            $columns       = $datagrid->getColumns();
            $previousCount = $columns->count();
            $newCount      = rand(1, 10);

            for ($i = 0; $i < $newCount; $i++) {
                $columns->add(new Column([
                    'id'      => 'new_column_' . $i,
                    'caption' => '',
                ]));
            }

            $this->assertInstanceOf('WellCommerce\Component\DataGrid\Column\ColumnCollection', $columns);
            $this->assertCount($previousCount + $newCount, $columns);
        }
    }

    public function testDatagridHasRequiredColumns()
    {
        $datagrid = $this->getDataGrid();

        if (null !== $datagrid) {
            $columns         = $datagrid->getColumns();
            $requiredColumns = $this->getColumns();

            foreach ($requiredColumns as $identifier) {
                /**
                 * @var $column \WellCommerce\Component\DataGrid\Column\ColumnInterface
                 */
                $column = $columns->get($identifier);
                $this->assertInstanceOf('WellCommerce\Component\DataGrid\Column\ColumnInterface', $column);
                $this->assertEquals($identifier, $column->getId());
            }
        }
    }
}
