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

namespace WellCommerce\Bundle\DataGridBundle\DataGrid\Loader;

use Doctrine\ORM\Query\Expr;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpFoundation\Request;
use WellCommerce\Bundle\DataGridBundle\DataGrid\DataGridInterface;

/**
 * Class Loader
 *
 * @package WellCommerce\Bundle\DataGridBundle\DataGrid\Loader
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
     * @var \WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnCollection
     */
    private $columns;

    /**
     * @var Request
     */
    private $request;
    private $where;
    private $orderBy;
    private $orderDir;
    private $limit;
    private $offset;
    private $requestId;

    /**
     * {@inheritdoc}
     */
    public function getSelectClause()
    {
        $columns = [];
        foreach ($this->columns as $column) {
            $columns[] = sprintf('%s AS %s', $column->getSource(), $column->getId());
        }

        return implode(', ', $columns);
    }

    /**
     * Adds where clauses to QB
     *
     * @param QueryBuilder $queryBuilder
     */
    private function prepareWhere(QueryBuilder $queryBuilder)
    {
        if (is_array($this->where)) {
            foreach ($this->where as $where) {
                $column     = $this->columns->get($where['column']);
                $source     = $column->getSource();
                $identifier = $column->getId();
                $operator   = $where['operator'];
                $value      = isset($where['value']) ? $where['value'] : null;
                $expression = null;

                switch ($operator) {
                    case 'IN':
                        $expression = $queryBuilder->expr()->in($source, ':' . $identifier);
                        break;
                    case 'NE':
                        $expression = $queryBuilder->expr()->neq($source, ':' . $identifier);
                        break;
                    case 'LE':
                        $expression = $queryBuilder->expr()->lte($source, ':' . $identifier);
                        break;
                    case 'GE':
                        $expression = $queryBuilder->expr()->gte($source, ':' . $identifier);
                        break;
                    case 'LIKE':
                        $expression = $queryBuilder->expr()->like($source, ':' . $identifier);
                        break;
                    default:
                        $expression = $queryBuilder->expr()->eq($source, ':' . $identifier);
                        break;
                }

                if (null !== $expression) {
                    $queryBuilder->add('where', $expression);
                    $queryBuilder->setParameter($identifier, $value);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function loadResults(Request $request)
    {
        $this->columns = $this->dataGrid->getColumns();
        $queryBuilder  = $this->dataGrid->getDataGridQueryBuilder();

        // parses where clauses and adds them to QB
        $this->prepareWhere($queryBuilder);

        $orderBy        = $this->columns->get($this->orderBy)->getSource();
        $paginatorQuery = clone $queryBuilder;
        $paginator      = new Paginator($paginatorQuery->getQuery(), $fetchJoinCollection = true);
        $total          = $paginator->count();

        $queryBuilder->addOrderBy($orderBy, $this->orderDir);
        $queryBuilder->select($this->getSelectClause());
        $queryBuilder->setFirstResult($this->offset);
        if ($this->limit > 0) {
            $queryBuilder->setMaxResults($this->limit);
        }


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

        return $this->loadResults($request);
    }

    /**
     * Fetches needed parameters from request
     *
     * @param Request $request
     */
    private function parseRequest(Request $request)
    {
        $this->requestId = $request->request->get('id');
        $this->orderBy   = $request->request->get('order_by');
        $this->orderDir  = $request->request->get('order_dir');
        $this->offset    = $request->request->get('starting_from');
        $this->limit     = $request->request->get('limit');
        $this->where     = $request->request->get('where');
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

    /**
     * Transforms output data to avoid json structure errors
     *
     * @param $value
     *
     * @return string
     */
    public function transform($value)
    {
        return strtr(addslashes($value), $this->transformers);
    }
}