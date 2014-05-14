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
namespace WellCommerce\Core\Component\DataGrid;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\Component\Repository\RepositoryInterface;
use xajaxResponse;

/**
 * Class AbstractDataGrid
 *
 * @package WellCommerce\Core\Component\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid extends AbstractComponent
{
    protected $query;
    protected $columns;
    protected $warnings;
    protected $container;
    protected $repository;
    protected $options = [];

    /**
     * Constructor
     *
     * @param ContainerInterface  $container  Service container
     * @param RepositoryInterface $repository DataGrid related repository
     * @param array               $options    DataGrid options
     */
    public function __construct(ContainerInterface $container, RepositoryInterface $repository, array $options = [])
    {
        parent::setContainer($container);
        $this->repository = $repository;
        $this->columns    = new ColumnCollection();
        $this->setOptions($options);
    }

    /**
     * Configures column options
     *
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(array $options)
    {
        $id = $this->getId();

        return array_replace_recursive([
            'appearance'     => [
                'column_select' => false
            ],
            'mechanics'      => [
                'key'           => 'id',
                'rows_per_page' => 25
            ],
            'event_handlers' => [
                'load'       => $this->getXajaxManager()->registerFunction(['load_' . $id, $this, 'loadData']),
                'edit_row'   => 'edit_' . $id,
                'click_row'  => 'edit_' . $id,
                'delete_row' => $this->getXajaxManager()->registerFunction(['delete_' . $id, $this, 'deleteRow'])
            ],
            'row_actions'    => [
                DataGridInterface::ACTION_EDIT,
                DataGridInterface::ACTION_DELETE
            ]
        ], $options);
    }

    /**
     * Sets DataGrid options
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $this->configureOptions($options);
    }

    /**
     * Returns DataGrid options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Deletes DataGrid row
     *
     * @param $datagrid
     * @param $id
     *
     * @return xajaxResponse
     */
    public function deleteRow($request)
    {
        return $this->repository->delete($request['id']);
    }

    /**
     * Refreshes datagrid instance by id
     *
     * @param $datagridId
     *
     * @return xajaxResponse
     */
    public function refresh($datagridId)
    {
        $objResponse = new xajaxResponse();
        $objResponse->script('' . 'try {' . 'GF_Datagrid.ReturnInstance(' . (int)$datagridId . ').LoadData();' . '}' . 'catch (xException) {' . 'GF_Debug.HandleException(xException);' . '}' . '');

        return $objResponse;
    }

    /**
     * Updates DataGrid row
     *
     * @param $request
     *
     * @return mixed
     */
    public function updateRow($request)
    {
        return $this->repository->updateDataGridRow($request);
    }

    /**
     * Returns datagrid data
     *
     * @param $request
     * @param $processFunction
     *
     * @return xajaxResponse
     */
    public function loadData($request)
    {
        $this->query->skip((int)$request['starting_from']);
        $this->query->take((int)$request['limit']);
        $this->query->orderBy($request['order_by'], $request['order_dir']);

        $connection = $this->getDb()->getConnection();

        foreach ($this->columns as $key => $column) {
            $col = $connection->raw(sprintf('%s AS %s', $column->getSource(), $key));
            $this->query->addSelect($col);
        }

        foreach ($request['where'] as $where) {
            $column   = $this->columns->get($where['column'])->getSource();
            $operator = $this->getOperator($where['operator']);
            $value    = $where['value'];

            if (is_array($value)) {
                if (!empty($value)) {
                    $this->query->whereIn($column, $value);
                } else {
                    $this->query->where($column, '=', 0);
                }
            } else {
                $this->query->where($column, $operator, $value);
            }

        }
        $result = $this->query->get();
        $total  = count($result);

//        $result = $this->processRows($result);

        return [
            'data_id'       => isset($request['id']) ? $request['id'] : '',
            'rows_num'      => $total,
            'starting_from' => $request['starting_from'],
            'total'         => $total,
            'filtered'      => $total,
            'rows'          => $result
        ];
    }

    /**
     * Get real operator
     *
     * @param $operator
     *
     * @return string
     */
    private function getOperator($operator)
    {
        switch ($operator) {
            case 'NE':
                return '!=';
                break;
            case 'LE':
                return '<=';
                break;
            case 'GE':
                return '>=';
                break;
            case 'LIKE':
                return 'LIKE';
                break;
            case 'IN':
                return '=';
                break;
            default:
                return '=';
        }
    }

    protected function processRows($rows)
    {
        static $transform = ["\r" => '\r', "\n" => '\n'];

        $rowData = [];
        foreach ($rows as $row) {
            $columns = [];
            foreach ($row as $param => $value) {
                if (isset($this->columns[$param]) && isset($this->columns[$param]['process_function']) && $this->columns[$param]['process_function']) {
                    $value = call_user_func($this->columns[$param]['process_function'], $value);
                }

                $columns[$param] = strtr(addslashes($value), $transform);
            }
            $rowData[] = $columns;
        }

        return $rowData;
    }

    /**
     * Returns ColumnCollection
     *
     * @return \WellCommerce\Core\Component\DataGrid\Column\ColumnCollection
     */
    public function getColumnCollection()
    {
        return $this->columns;
    }

    /**
     * Returns query
     *
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }
}