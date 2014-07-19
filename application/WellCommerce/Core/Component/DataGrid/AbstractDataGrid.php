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

use Composer\Repository\RepositoryInterface;
use phpDocumentor\Descriptor\Filter\Filter;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use WellCommerce\Core\Component\AbstractComponent;
use WellCommerce\Core\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\Component\DataGrid\Configuration\Appearance;
use WellCommerce\Core\Component\DataGrid\Configuration\EventHandlers;
use WellCommerce\Core\Component\DataGrid\Configuration\Filters;
use WellCommerce\Core\Component\DataGrid\Configuration\Mechanics;
use WellCommerce\Core\Component\DataGrid\Configuration\RowActions;
use WellCommerce\Core\Component\Form\Elements\Container;
use xajaxResponse;

/**
 * Class AbstractDataGrid
 *
 * @package WellCommerce\Core\Component\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataGrid extends AbstractComponent implements DataGridInterface
{
    protected $id;
    protected $query;
    protected $columns;
    protected $warnings;
    protected $repository;
    protected $appearance;
    protected $mechanics;
    protected $eventHandlers;
    protected $filters;
    protected $rowActions;

    public function __construct(ContainerInterface $container){

    }

    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setAppearance(new Appearance());
        $this->setMechanics(new Mechanics());
        $this->setEventHandlers(new EventHandlers());
        $this->setFilters(new Filters());
        $this->setRowActions(new RowActions());
    }

    /**
     * {@inheritdoc}
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * {@inheritdoc}
     */
    public function setId($identifier)
    {
        $this->id = $identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setAppearance(Appearance $appearance)
    {
        $this->appearance = $appearance;
    }

    /**
     * {@inheritdoc}
     */
    public function getAppearance()
    {
        return $this->appearance;
    }

    /**
     * {@inheritdoc}
     */
    public function setMechanics(Mechanics $mechanics)
    {
        $this->mechanics = $mechanics;
    }

    /**
     * {@inheritdoc}
     */
    public function getMechanics()
    {
        return new Mechanics();
    }

    /**
     * {@inheritdoc}
     */
    public function setEventHandlers(EventHandlers $eventHandlers)
    {
        $this->eventHandlers = $eventHandlers;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventHandlers()
    {
        return new EventHandlers();
    }

    /**
     * {@inheritdoc}
     */
    public function setRowActions(RowActions $actions)
    {
        $this->rowActions = $actions;
    }

    /**
     * {@inheritdoc}
     */
    public function getRowActions()
    {
        return $this->rowActions;
    }

    /**
     * {@inheritdoc}
     */
    public function setFilters(Filters $filters)
    {
        $this->filters = $filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * {@inheritdoc}
     */
    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }

    /**
     * {@inheritdoc}
     */
    public function setQuery(DataGridQueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteRow($request)
    {
        return $this->repository->delete($request['id']);
    }

    /**
     * {@inheritdoc}
     */
    public function refresh($datagridId)
    {
        $objResponse = new xajaxResponse();
        $objResponse->script('' . 'try {' . 'GF_Datagrid.ReturnInstance(' . (int)$datagridId . ').LoadData();' . '}' . 'catch (xException) {' . 'GF_Debug.HandleException(xException);' . '}' . '');

        return $objResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function updateRow($request)
    {
        try {
            $this->repository->updateDataGridRow($request);

        } catch (ValidatorException $exception) {
            return [
                'error' => $exception->getMessage()
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function loadData(array $request)
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

    /**
     * {@inheritdoc}
     */
    protected function processRows($rows)
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