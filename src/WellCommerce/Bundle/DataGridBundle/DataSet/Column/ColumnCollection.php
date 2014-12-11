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

namespace WellCommerce\Bundle\DataGridBundle\DataGrid\Column;

/**
 * Class ColumnCollection
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ColumnCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array
     */
    private $columns = [];

    /**
     * Returns iterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->columns);
    }

    /**
     * Returns columns count
     *
     * @return int
     */
    public function count()
    {
        return count($this->columns);
    }

    /**
     * Returns all columns
     *
     * @return mixed
     */
    public function all()
    {
        return $this->columns;
    }

    /**
     * Adds new DataGrid column to collection
     *
     * @param ColumnInterface $column
     */
    public function add(ColumnInterface $column)
    {
        $this->columns[$column->getId()] = $column;
    }

    /**
     * Returns DataGrid column by identifier
     *
     * @param $id
     *
     * @return ColumnInterface Column
     *
     * @throws \InvalidArgumentException
     */
    public function get($id)
    {
        if (!isset($this->columns[$id])) {
            throw new \InvalidArgumentException(sprintf('DataGrid column %s not found', $id));
        }

        return $this->columns[$id];
    }
}