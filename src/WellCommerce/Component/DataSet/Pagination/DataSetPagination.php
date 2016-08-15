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

namespace WellCommerce\Component\DataSet\Pagination;

use Doctrine\ORM\QueryBuilder;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Paginator\DataSetPaginatorInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;

/**
 * Class DataSetPagination
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetPagination implements DataSetPaginationInterface
{
    /**
     * @var DataSetPaginatorInterface
     */
    protected $dataSetPaginator;

    /**
     * Constructor
     *
     * @param DataSetPaginatorInterface $dataSetPaginator
     */
    public function __construct(DataSetPaginatorInterface $dataSetPaginator)
    {
        $this->dataSetPaginator = $dataSetPaginator;
    }

    public function getPagination(QueryBuilder $queryBuilder, DataSetRequestInterface $request, ColumnCollection $columns)
    {
        $total       = $this->dataSetPaginator->getTotalRows($queryBuilder, $columns);
        $offset      = $request->getOffset();
        $limit       = $request->getLimit();
        $currentPage = ($offset / $limit) + 1;
        $totalPages  = ceil($total / $limit);

        return [
            'totalRows'     => $total,
            'currentPage'   => $currentPage,
            'totalPages'    => ceil($total / $limit),
            'currentResult' => [
                'rangeFrom' => $offset,
                'rangeTo'   => $this->calculateCurrentResultEnd($offset, $limit, $total),
            ],
            'nextPage'      => $this->getNextPage($totalPages, $offset, $limit),
            'previousPage'  => $this->getPreviousPage($currentPage),
            'pages'         => $this->getPages($totalPages, $currentPage)
        ];
    }

    protected function calculateCurrentResultEnd($offset, $limit, $total)
    {
        if (($offset + $limit) > $total) {
            return $total;
        }

        return $offset + $limit;
    }

    /**
     * Returns an array containing all page numbers
     *
     * @param int $totalPages
     * @param int $currentPage
     *
     * @return array
     */
    protected function getPages($totalPages, $currentPage)
    {
        $range = range(1, $totalPages);
        $pages = [];
        foreach ($range as $page) {
            $pages[] = [
                'number' => $page,
                'active' => (int)$page === (int)$currentPage
            ];
        }

        return $pages;
    }

    /**
     * Returns the next page or false if last page
     *
     * @param int $totalPages
     * @param int $offset
     * @param int $limit
     *
     * @return null|int
     */
    protected function getNextPage($totalPages, $offset, $limit)
    {
        $nextPage = ($offset / $limit) + 2;
        if ($nextPage > $totalPages) {
            return null;
        }

        return $nextPage;
    }

    /**
     * Returns the previous page or false if first page
     *
     * @param $currentPage
     *
     * @return null|int
     */
    protected function getPreviousPage($currentPage)
    {
        $previousPage = $currentPage - 1;
        if ($previousPage < 1) {
            return null;
        }

        return $previousPage;
    }
}
