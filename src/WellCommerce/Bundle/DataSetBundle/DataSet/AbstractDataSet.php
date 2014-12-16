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

namespace WellCommerce\Bundle\DataSetBundle\DataSet;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\DataSetBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\DataSet\Event\DataSetEvent;
use WellCommerce\Bundle\DataSetBundle\DataSet\QueryBuilder\QueryBuilderInterface;
use WellCommerce\Bundle\DataSetBundle\DataSet\Request\DataSetRequest;

/**
 * Class AbstractDataSet
 *
 * @package WellCommerce\Bundle\DataSetBundle\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSet
{
    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var bool
     */
    protected $booted = false;

    /**
     * Constructor
     *
     * @param ColumnCollection         $columns
     * @param EventDispatcherInterface $eventDispatcher
     * @param QueryBuilderInterface    $queryBuilder
     */
    public function __construct(
        $identifier,
        ColumnCollection $columns,
        EventDispatcherInterface $eventDispatcher,
        QueryBuilderInterface $queryBuilder
    ) {
        $this->identifier      = $identifier;
        $this->queryBuilder    = $queryBuilder;
        $this->eventDispatcher = $eventDispatcher;
        $this->columns         = $columns;
    }

    /**
     * Configures dataset columns
     *
     * @param ColumnCollection $collection
     *
     * @return void
     */
    abstract protected function configureColumns(ColumnCollection $collection);

    /**
     * {@inheritdoc}
     */
    public function getColumns()
    {
        if (!$this->booted) {
            $this->configure();
        }

        return $this->columns;
    }

    /**
     * Configures dataset
     */
    protected function configure()
    {
        $this->configureColumns($this->columns);
        $this->queryBuilder->setColumns($this->columns);
        $this->booted = true;
        $this->dispatchEvent(DataSetInterface::EVENT_POST_CONFIGURE);
    }

    protected function dispatchEvent($event)
    {
        $eventName = sprintf('%s.%s', $this->identifier, $event);
        $eventData = new DataSetEvent($this);
        $this->eventDispatcher->dispatch($eventName, $eventData);
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
                if ($this->columns->get($param)->hasTransformer()) {
                    $value = $this->columns->get($param)->getTransformer()->transform($value);
                }
                $columns[$param] = $value;
            }
            $rowData[] = $columns;
        }

        return $rowData;
    }

    /**
     * {@inheritdoc}
     */
    public function getResults(DataSetRequest $request)
    {
        if (!$this->booted) {
            $this->configure();
        }

        $total = $this->queryBuilder->getTotalRows();
        $this->queryBuilder->setOrderBy($request->getOrderBy(), $request->getOrderDir());
        $this->queryBuilder->setPagination($request->getOffset(), $request->getLimit());
        $this->queryBuilder->setConditions($request->getConditions());
        $rows = $this->processResults($this->queryBuilder->getResult());

        return [
            'data_id'       => $request->getId(),
            'rows_num'      => $total,
            'starting_from' => $request->getOffset(),
            'total'         => $total,
            'filtered'      => $total,
            'rows'          => $rows
        ];

    }
} 