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

namespace WellCommerce\Bundle\ProductBundle\Collection\Column;

use WellCommerce\Bundle\CoreBundle\Collection\AbstractCollection;

/**
 * Class ColumnCollection
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Column
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ColumnCollection extends AbstractCollection
{
    /**
     * Adds new product column to collection
     *
     * @param ColumnInterface $column
     */
    public function add(ColumnInterface $column)
    {
        $this->items[] = $column;
    }
}