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

namespace WellCommerce\CoreBundle\Component\DataSet\Pagination;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use WellCommerce\CoreBundle\Component\DataSet\Column\ColumnCollection;
use WellCommerce\CoreBundle\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Interface DataSetPaginationInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetPaginationInterface
{
    /**
     * @param QueryBuilder            $queryBuilder
     * @param DataSetRequestInterface $request
     * @param ColumnCollection        $columns
     *
     * @return mixed
     */
    public function getPagination(QueryBuilder $queryBuilder, DataSetRequestInterface $request, ColumnCollection $columns);
}
