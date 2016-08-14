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

namespace WellCommerce\Component\DataSet\Paginator;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Component\DataSet\Column\ColumnCollection;

/**
 * Interface DataSetPaginatorInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetPaginatorInterface
{
    CONST RESULT_CACHE_ID = 'dataset_paginator';
    
    /**
     * Returns total count
     *
     * @param QueryBuilder     $queryBuilder
     * @param ColumnCollection $columns
     *
     * @return int
     */
    public function getTotalRows(QueryBuilder $queryBuilder, ColumnCollection $columns) : int;
}
