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

use Doctrine\ORM\QueryBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Component\DataSet\Cache\CacheOptions;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Column\ColumnInterface;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\Component\DataSet\Event\DataSetInitEvent;
use WellCommerce\Component\DataSet\Event\DataSetRequestEvent;
use WellCommerce\Component\DataSet\Manager\DataSetManagerInterface;
use WellCommerce\Component\DataSet\Repository\DataSetAwareRepositoryInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;
use WellCommerce\Component\DataSet\Transformer\ColumnTransformerCollection;
use WellCommerce\Component\DataSet\Transformer\DataSetTransformerInterface;

/**
 * Class AbstractDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSet implements DataSetInterface
{
    /**
     * @var ColumnCollection
     */
    protected $columns;
    
    /**
     * @var DataSetAwareRepositoryInterface
     */
    private $repository;
    
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;
    
    /**
     * @var ColumnTransformerCollection
     */
    protected $columnTransformers;
    
    /**
     * @var DataSetManagerInterface
     */
    private $manager;
    
    /**
     * @var array
     */
    protected $defaultContextOptions = [];
    
    /**
     * @var array
     */
    protected $defaultRequestOptions = [];
    
    /**
     * @var CacheOptions
     */
    protected $cacheOptions;

    /**
     * AbstractDataSet constructor.
     *
     * @param DataSetAwareRepositoryInterface $repository
     * @param DataSetManagerInterface         $manager
     * @param EventDispatcherInterface        $eventDispatcher
     */
    public function __construct(
        DataSetAwareRepositoryInterface $repository,
        DataSetManagerInterface $manager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->repository      = $repository;
        $this->manager         = $manager;
        $this->eventDispatcher = $eventDispatcher;
        $this->columns         = new ColumnCollection();
        $this->cacheOptions    = new CacheOptions();
    }
    
    public function setCacheOptions(CacheOptions $options)
    {
        $this->cacheOptions = $options;
    }

    public function getColumns() : ColumnCollection
    {
        return $this->columns;
    }
    
    public function setColumns(ColumnCollection $columns)
    {
        $this->columns = $columns;
    }
    
    public function addColumn(ColumnInterface $column)
    {
        $this->columns->add($column);
    }
    
    abstract public function configureOptions(DataSetConfiguratorInterface $configurator);
    
    public function setDefaultRequestOption(string $name, $value)
    {
        $this->defaultRequestOptions[$name] = $value;
    }

    public function setDefaultContextOption(string $name, $value)
    {
        $this->defaultContextOptions[$name] = $value;
    }

    public function dispatchOnDataSetInitEvent()
    {
        $this->eventDispatcher->dispatch($this->getEventName(DataSetInitEvent::EVENT_SUFFIX), new DataSetInitEvent($this));
    }

    public function getResult(string $contextType, array $requestOptions = [], array $contextOptions = []) : array
    {
        $contextOptions = $this->getContextOptions($contextOptions);
        $requestOptions = $this->getRequestOptions($requestOptions);
        $context        = $this->manager->createContext($contextType, $contextOptions);
        $request        = $this->getDataSetRequest($requestOptions);
        $queryBuilder   = $this->getQueryBuilder($request);

        try {
            return $context->getResult($queryBuilder, $request, $this->columns, $this->cacheOptions);
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    protected function getDataSetRequest(array $requestOptions = []) : DataSetRequestInterface
    {
        $request = $this->manager->createRequest($requestOptions);
        $this->dispatchDataSetRequestEvent($request);

        return $request;
    }

    protected function getDataSetTransformer(string $type, array $options = []) : DataSetTransformerInterface
    {
        return $this->manager->createTransformer($type, $options);
    }

    protected function getQueryBuilder(DataSetRequestInterface $request) : QueryBuilder
    {
        $dataSetQueryBuilder = $this->manager->createQueryBuilder($this->repository);

        return $dataSetQueryBuilder->getQueryBuilder($this->columns, $request);
    }

    private function getContextOptions(array $contextOptions = []) : array
    {
        $contextOptions = array_merge($this->defaultContextOptions, $contextOptions);

        return $contextOptions;
    }

    private function getRequestOptions(array $requestOptions = []) : array
    {
        $requestOptions = array_merge($this->defaultRequestOptions, $requestOptions);

        return $requestOptions;
    }

    private function dispatchDataSetRequestEvent(DataSetRequestInterface $request)
    {
        $this->eventDispatcher->dispatch($this->getEventName(DataSetRequestEvent::EVENT_SUFFIX), new DataSetRequestEvent($this, $request));
    }
    
    private function getEventName(string $eventSuffix): string
    {
        return sprintf('%s.%s', $this->repository->getAlias(), $eventSuffix);
    }
}
