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

namespace WellCommerce\Core\DataGrid\QueryBuilder;

/**
 * Interface QueryBuilderInterface
 *
 * @package WellCommerce\Core\DataGrid\Query
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface QueryBuilderInterface
{
    /**
     * Returns current DataGrid query builder
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQuery();

    /**
     * Returns database manager
     *
     * @return \Illuminate\Database\Capsule\Manager
     */
    public function getManager();

    /**
     * Transforms and returns operator used in where clauses
     *
     * @param $operator
     *
     * @return string
     */
    public function getOperator($operator);
} 