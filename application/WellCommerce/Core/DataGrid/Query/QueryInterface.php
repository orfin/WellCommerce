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

namespace WellCommerce\Core\DataGrid\Query;

/**
 * Interface QueryInterface
 *
 * @package WellCommerce\Core\DataGrid\Query
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface QueryInterface
{
    /**
     * Returns current DataGrid query builder
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQuery();
} 