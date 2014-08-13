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

namespace WellCommerce\Bundle\CoreBundle\DataGrid\Loader;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use Pagerfanta\Adapter\DoctrineORMAdapter;

/**
 * Class Loader
 *
 * @package WellCommerce\Bundle\CoreBundle\DataGrid\Loader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Loader implements LoaderInterface
{
    /**
     * String transformers
     *
     * @var array
     */
    private $transformers = ["\r" => '\r', "\n" => '\n'];

    /**
     * @var DataGridInterface
     */
    private $dataGrid;

    /**
     * @var \WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection
     */
    private $columns;

    /**
     * @var Request
     */
    private $request;

    private $orderBy;
    private $orderDir;
    private $limit;
    private $offset;
    private $requestId;

    public function getSelectClause()
    {
        $columns = [];
        foreach ($this->columns as $column) {
            $columns[] = $column->getSource();
        }

        return implode(', ', $columns);
    }

    public function loadResults()
    {
        $this->columns  = $this->dataGrid->getColumns();
        $queryBuilder   = $this->dataGrid->getDataGridQueryBuilder();
        $orderBy        = $this->columns->get($this->orderBy)->getSource();
        $paginatorQuery = clone $queryBuilder;
        $paginator      = new Paginator($paginatorQuery->getQuery(), $fetchJoinCollection = true);
        $total          = $paginator->count();

        $queryBuilder->addOrderBy($orderBy, $this->orderDir);
        $queryBuilder->select($this->getSelectClause());
        $queryBuilder->setFirstResult($this->offset);
        $queryBuilder->setMaxResults($this->limit);

        $query = $queryBuilder->getQuery();

        $query->useResultCache(true, 3600, $this->dataGrid->getIdentifier());
        $result = $query->getArrayResult();

        return [
            'data_id'       => $this->requestId,
            'rows_num'      => $total,
            'starting_from' => $this->offset,
            'total'         => $total,
            'filtered'      => $total,
            'rows'          => $this->processResults($result)
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getResults(DataGridInterface $dataGrid, Request $request)
    {
        $this->dataGrid = $dataGrid;
        $this->parseRequest($request);

        return $this->loadResults();
    }

    private function parseRequest(Request $request)
    {
        $this->requestId = $request->request->get('id');
        $this->orderBy   = $request->request->get('order_by');
        $this->orderDir  = $request->request->get('order_dir');
        $this->offset    = $request->request->get('starting_from');
        $this->limit     = $request->request->get('limit');
    }

    /**
     * {@inheritdoc}
     */
    public function processResults($rows)
    {
        $rowData = [];
        foreach ($rows as $row) {
            $columns = [];
            foreach ($row as $param => $value) {
                $processFunction = $this->columns->get($param)->getProcessFunction();
                if (null != $processFunction) {
                    $value = call_user_func($processFunction, $value);
                }

                $columns[$param] = $this->transform($value);
            }
            $rowData[] = $columns;
        }

        return $rowData;
    }

    public function transform($value)
    {
        return strtr(addslashes($value), $this->transformers);
    }
}