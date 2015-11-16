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

namespace WellCommerce\Bundle\CoreBundle\Test\DataSet;

use WellCommerce\Bundle\CoreBundle\Test\AbstractTestCase;

/**
 * Class AbstractDataSetTestCase
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSetTestCase extends AbstractTestCase
{
    /**
     * @return null|\WellCommerce\Bundle\DataSetBundle\DataSetInterface
     */
    protected function get()
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

    public function testDatasetServiceIsCreated()
    {
        $dataset = $this->get();

        if (null !== $dataset) {
            $this->assertInstanceOf('WellCommerce\Bundle\DataSetBundle\DataSetInterface', $dataset);
        }
    }

    public function testDatasetHasRequiredColumns()
    {
        $dataset = $this->get();

        if (null !== $dataset) {
            $columns         = $dataset->getColumns();
            $requiredColumns = $this->getColumns();

            foreach ($requiredColumns as $alias => $source) {
                /**
                 * @var $column \WellCommerce\Bundle\DataSetBundle\Column\ColumnInterface
                 */
                $column = $columns->get($alias);
                $this->assertInstanceOf('WellCommerce\Bundle\DataSetBundle\Column\ColumnInterface', $column);
                $this->assertEquals($source, $column->getSource());
                $this->assertEquals($alias, $column->getAlias());
                $this->assertEquals($this->isAggregateColumn($source), $column->isAggregated());
            }
        }
    }

    /**
     * @dataProvider getDataSetContexts
     */
    public function testDatasetReturnsResults($contexts)
    {
        $dataset = $this->get();

        if (null !== $dataset) {
            foreach ($contexts as $context) {
                $results = $dataset->getResult($context, ['order_by' => 'id', 'order_dir' => 'asc', 'limit' => 10]);
                $this->assertNotNull($results);
            }
        }
    }

    protected function isAggregateColumn($source)
    {
        $aggregates = ['SUM', 'GROUP_CONCAT', 'MIN', 'MAX', 'AVG', 'COUNT'];
        $regex      = '/(' . implode('|', $aggregates) . ')/i';

        return (bool)(preg_match($regex, $source));
    }

    /**
     * @return array
     */
    public function getDataSetContexts()
    {
        return [
            'contexts' => [
                [
                    'select',
                    'array',
                    'datagrid',
                ]
            ],
        ];
    }
}
