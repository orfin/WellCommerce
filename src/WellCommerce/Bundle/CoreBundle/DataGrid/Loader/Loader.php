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

use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

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

    public function loadResults()
    {
        $request       = $this->dataGrid->getCurrentRequest();
        $queryBuilder  = $this->dataGrid->getQueryBuilder();
        $query         = $queryBuilder->getQuery();
        $manager       = $queryBuilder->getManager();
        $connection    = $manager->getConnection();
        $this->columns = $this->dataGrid->getColumns();

        foreach ($this->columns as $column) {
            $col = $connection->raw($column->getRawSelect());
            $query->addSelect($col);
        }

        foreach ($request->getWhere() as $where) {
            $column     = $this->columns->get($where['column']);
            $id         = $column->getId();
            $source     = $column->getSource();
            $aggregated = $column->isAggregated();
            $operator   = $queryBuilder->getOperator($where['operator']);
            $value      = $where['value'];

            if ($aggregated) {
                $query->having($id, $operator, $value);
            } else {
                if (is_array($value)) {
                    if (!empty($value)) {
                        $query->whereIn($source, $value);
                    } else {
                        $query->where($source, '=', 0);
                    }
                } else {
                    $query->where($source, $operator, $value);
                }
            }

        }

        $query->skip($request->getStartingFrom());
        $query->take($request->getLimit());
        $query->orderBy($request->getOrderBy(), $request->getOrderDir());

        $result = $query->get();
        $total  = count($result);

        return [
            'data_id'       => $request->getId(),
            'rows_num'      => $total,
            'starting_from' => $request->getStartingFrom(),
            'total'         => $total,
            'filtered'      => $total,
            'rows'          => $this->processResults($result)
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getResults(DataGridInterface $dataGrid)
    {
        $this->dataGrid = $dataGrid;

        return $this->loadResults();
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