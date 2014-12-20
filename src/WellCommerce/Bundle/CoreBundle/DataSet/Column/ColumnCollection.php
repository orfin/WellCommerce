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

namespace WellCommerce\Bundle\CoreBundle\DataSet\Column;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class ColumnCollection
 *
 * @package WellCommerce\Bundle\CoreBundle\DataSet\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ColumnCollection extends AbstractCollection
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
     * @return Column
     */
    public function get($id)
    {
        if (!isset($this->items[$id])) {
            throw new \InvalidArgumentException(sprintf('DataSet column "%s" not found', $id));
        }

        return $this->items[$id];
    }

    public function getColumnsSelectClause()
    {
        $columns = [];

        /**
         * @var $item ColumnInterface
         */
        foreach ($this->items as $item) {
            $columns[] = $item->getRawSelect();
        }

        return implode(', ', $columns);
    }
}