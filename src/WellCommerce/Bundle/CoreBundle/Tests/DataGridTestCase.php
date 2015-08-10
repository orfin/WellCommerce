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

namespace WellCommerce\Bundle\CoreBundle\Tests;

use WellCommerce\Bundle\DataGridBundle\Column\Column;

/**
 * Class DataGridTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class DataGridTestCase extends AbstractTestCase
{
    protected function getDataGridInstance()
    {
        return null;
    }

    protected function getRequiredColumns()
    {
        return [];
    }

    public function testDataGridInstanceIsCreated()
    {
        $datagrid = $this->getDataGridInstance();

        if (null !== $datagrid) {
            $this->assertInstanceOf('WellCommerce\Bundle\DataGridBundle\DataGridInterface', $datagrid);
        }
    }

    public function testDataGridColumnsCollectionIsConfigurable()
    {
        $datagrid = $this->getDataGridInstance();

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

            $this->assertInstanceOf('WellCommerce\Bundle\DataGridBundle\Column\ColumnCollection', $columns);
            $this->assertCount($previousCount + $newCount, $columns);
        }
    }

    public function testDataGridHasRequiredColumns()
    {
        $datagrid = $this->getDataGridInstance();

        if (null !== $datagrid) {
            $columns         = $datagrid->getColumns();
            $requiredColumns = $this->getRequiredColumns();

            foreach ($requiredColumns as $identifier) {
                $column = $columns->get($identifier);
                $this->assertInstanceOf('WellCommerce\Bundle\DataGridBundle\Column\ColumnInterface', $column);
                $this->assertEquals($identifier, $column->getId());
            }
        }


    }
}
