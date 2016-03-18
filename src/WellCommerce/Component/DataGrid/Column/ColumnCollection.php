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

namespace WellCommerce\Component\DataGrid\Column;

use WellCommerce\Component\Collections\ArrayCollection;
use WellCommerce\Component\DataGrid\Exception\ColumnNotFoundException;

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
        $this->items[$column->getId()] = $column;
    }

    /**
     * Returns column by its identifier
     *
     * @param string $identifier Column identifier
     *
     * @return ColumnInterface
     */
    public function get($identifier) : ColumnInterface
    {
        if (false === $this->has($identifier)) {
            throw new ColumnNotFoundException($identifier);
        }

        return $this->items[$identifier];
    }
}
