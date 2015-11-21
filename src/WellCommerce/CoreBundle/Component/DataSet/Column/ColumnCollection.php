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

namespace WellCommerce\CoreBundle\Component\DataSet\Column;

use WellCommerce\CoreBundle\Component\DataSet\Exception\DataSetColumnNotFoundException;
use WellCommerce\CoreBundle\Component\Collection\ArrayCollection;

/**
 * Class ColumnCollection
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ColumnCollection extends ArrayCollection
{
    /**
     * Adds new column to collection
     *
     * @param ColumnInterface $column
     */
    public function add(ColumnInterface $column)
    {
        $this->items[$column->getAlias()] = $column;
    }

    /**
     * Returns dataset column by its identifier
     *
     * @param $id
     *
     * @return ColumnInterface
     */
    public function get($id)
    {
        if (!isset($this->items[$id])) {
            print_r($this->items);
            throw new DataSetColumnNotFoundException($id);
        }

        return $this->items[$id];
    }

    /**
     * @return ColumnInterface[]
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Returns SQL select clause as a string
     *
     * @return string
     */
    public function getSelectClause()
    {
        $select = [];
        foreach ($this->all() as $column) {
            $select[] = $column->getRawSelect();
        }

        return implode(', ', $select);
    }
}
