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

namespace WellCommerce\Bundle\CoreBundle\Test\DataGrid;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnInterface;

/**
 * Class AbstractDataGridTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGridTestCase extends AbstractTestCase
{
    public function testDatagridServiceIsCreated()
    {
        $datagrid = $this->getDataGrid();
        
        if (null !== $datagrid) {
            $this->assertInstanceOf('WellCommerce\Component\DataGrid\DataGridInterface', $datagrid);
        }
    }
    
    /**
     * @return null|\WellCommerce\Component\DataGrid\DataGridInterface
     */
    protected function getDataGrid()
    {
        return null;
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
                $column = $columns->get($identifier);
                $this->assertInstanceOf(ColumnInterface::class, $column);
                $this->assertEquals($identifier, $column->getId());
            }
        }
    }
    
    /**
     * @return array
     */
    protected function getColumns()
    {
        return [];
    }
}
