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

namespace WellCommerce\Core\DataGrid\Loader;

use WellCommerce\Core\DataGrid\Query\QueryInterface;
use WellCommerce\Core\DataGrid\Request\RequestInterface;

/**
 * Class Loader
 *
 * @package WellCommerce\Core\DataGrid\Loader
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class Loader implements LoaderInterface
{
    /**
     * @var object Query object
     */
    protected $query;

    /**
     * @var array Request options
     */
    protected $request = [];

    /**
     * {@inheritdoc}
     */
    public function get(array $options)
    {
        $this->request = new Request([
            'starting_from' => $options['starting_from'],
            'limit'         => $options['limit'],
            'order_by'      => $options['order_by'],
            'order_dir'     => $options['order_dir'],
        ]);


    }

    public function setQuery(QueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function load(RequestInterface $request)
    {
        $offset = (int)$request['starting_from'];
        $limit  = (int)$request['limit'];

        // set offset
        $this->query->skip($offset);

        // set limit
        $this->query->take($limit);

        // add order by clause
        $this->query->orderBy($request['order_by'], $request['order_dir']);

        $connection = $this->getDb()->getConnection();

        foreach ($this->columns as $key => $column) {
            $col = $connection->raw(sprintf('%s AS %s', $column->getSource(), $key));
            $this->query->addSelect($col);
        }

        foreach ($request['where'] as $where) {
            $column     = $this->columns->get($where['column']);
            $id         = $column->getId();
            $source     = $column->getSource();
            $aggregated = $column->isAggregated();
            $operator   = $this->getOperator($where['operator']);
            $value      = $where['value'];

            if ($aggregated) {
                $this->query->having($id, $operator, $value);
            } else {
                if (is_array($value)) {
                    if (!empty($value)) {
                        $this->query->whereIn($source, $value);
                    } else {
                        $this->query->where($source, '=', 0);
                    }
                } else {
                    $this->query->where($source, $operator, $value);
                }
            }

        }
        $result = $this->query->get();
        $total  = count($result);

        $result = $this->processRows($result);

        return [
            'data_id'       => isset($request['id']) ? $request['id'] : '',
            'rows_num'      => $total,
            'starting_from' => $offset,
            'total'         => $total,
            'filtered'      => $total,
            'rows'          => $result
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function process($result)
    {
        static $transform = ["\r" => '\r', "\n" => '\n'];

        $rowData = [];
        foreach ($rows as $row) {
            $columns = [];
            foreach ($row as $param => $value) {
                $processFunction = $this->columns->get($param)->getProcessFunction();
                if (null != $processFunction) {
                    $value = call_user_func($processFunction, $value);
                }

                $columns[$param] = strtr(addslashes($value), $transform);
            }
            $rowData[] = $columns;
        }

        return $rowData;
    }
} 