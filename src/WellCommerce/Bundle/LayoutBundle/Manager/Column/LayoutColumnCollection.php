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

namespace WellCommerce\Bundle\LayoutBundle\Manager\Column;

/**
 * Class LayoutColumnCollection
 *
 * @package WellCommerce\Bundle\LayoutBundle\Manager\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutColumnCollection implements \IteratorAggregate, \Countable
{
    /**
     * @var array Column collection
     */
    public $columns = [];

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->columns);
    }

    /**
     * {@inheritdoc}
     */
    public function add(LayoutColumn $column)
    {
        $this->columns[] = $column;
    }

    /**
     * {@inheritdoc}
     */
    public function all()
    {
        return $this->columns;
    }
}