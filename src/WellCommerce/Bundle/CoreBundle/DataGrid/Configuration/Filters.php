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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Configuration;

use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\Filter\FilterInterface;

/**
 * Class Filters
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Configuration
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Filters implements \IteratorAggregate, \Countable
{
    private $filters;

    /**
     * Returns iterator
     *
     * @return \ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->filters);
    }

    /**
     * Returns filters count
     *
     * @return int
     */
    public function count()
    {
        return count($this->filters);
    }

    /**
     * Returns all filters
     *
     * @return mixed
     */
    public function all()
    {
        return $this->filters;
    }

    /**
     * Adds new event handler to collection
     *
     * @param FilterInterface $filter
     */
    public function add(FilterInterface $filter)
    {
        $this->filters[$filter->getColumn()] = $filter->getValues();
    }

    /**
     * Returns filter values for column
     *
     * @param $column
     *
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function get($column)
    {
        if (!isset($this->filters[$column])) {
            throw new \InvalidArgumentException(sprintf('DataGrid filters for column "%s" not found', $column));
        }

        return $this->filters[$column];
    }

    /**
     * Checks whether column has related filter data
     *
     * @param $column
     *
     * @return bool
     */
    public function has($column)
    {
        return isset($this->filters[$column]);
    }
}
