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

namespace WellCommerce\Component\DataSet\QueryBuilder;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Interface DataSetQueryBuilderInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetQueryBuilderInterface
{
    const SORT_DIR_ASC  = 'ASC';
    const SORT_DIR_DESC = 'DESC';

    /**
     * Prepares and returns Doctrine's QueryBuilder
     *
     * @param ColumnCollection        $columns
     * @param DataSetRequestInterface $request
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder(ColumnCollection $columns, DataSetRequestInterface $request) : QueryBuilder;
}
