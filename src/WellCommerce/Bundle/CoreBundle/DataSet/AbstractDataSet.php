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

namespace WellCommerce\Bundle\CoreBundle\DataSet;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\Event\DataSetEvent;
use WellCommerce\Bundle\CoreBundle\DataSet\QueryBuilder\QueryBuilderInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequest;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerCollection;

/**
 * Class AbstractDataSet
 *
 * @package WellCommerce\Bundle\CoreBundle\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSet extends ContainerAware
{
    /**
     * @var QueryBuilderInterface
     */
    protected $queryBuilder;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var TransformerCollection
     */
    protected $transformers;

    /**
     * @var bool
     */
    protected $booted = false;

    /**
     * Constructor
     *
     * @param                       $identifier
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(
        $identifier,
        QueryBuilderInterface $queryBuilder
    ) {
        $this->identifier   = $identifier;
        $this->queryBuilder = $queryBuilder;
        $this->columns      = new ColumnCollection();
        $this->transformers = new TransformerCollection();
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
     * Configures column transformers
     *
     * @param TransformerCollection $transformers
     *
     * @return bool
     */
    protected function configureTransformers(TransformerCollection $transformers)
    {
        return false;
    }

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
        $this->configureTransformers($this->transformers);
        $this->queryBuilder->setColumns($this->columns);
        $this->booted = true;
        $this->dispatchEvent(DataSetInterface::EVENT_POST_CONFIGURE);
    }

    /**
     * Dispatches the event using event dispatcher service
     *
     * @param $event
     */
    protected function dispatchEvent($event)
    {
        $eventName = sprintf('%s.%s', $this->identifier, $event);
        $eventData = new DataSetEvent($this);
        $this->getEventDispatcher()->dispatch($eventName, $eventData);
    }

    private function getEventDispatcher()
    {
        return $this->container->get('event_dispatcher');
    }

    /**
     * {@inheritdoc}
     */
    public function processResults($rows)
    {
        $results = [];

        foreach ($rows as $row) {
            $results[] = $this->processRow($row);
        }

        return $results;
    }

    protected function processRow($row)
    {
        foreach ($row as $field => $value) {
            if ($this->transformers->has($field)) {
                $row[$field] = $this->transformers->get($field)->transform($value);
            }
        }

        return $row;
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