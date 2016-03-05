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

use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Component\DataSet\Column\ColumnCollection;
use WellCommerce\Component\DataSet\Column\ColumnInterface;
use WellCommerce\Component\DataSet\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Component\DataSet\Context\DataSetContextInterface;
use WellCommerce\Component\DataSet\DataSetInterface;
use WellCommerce\Component\DataSet\Manager\DataSetManagerInterface;
use WellCommerce\Component\DataSet\QueryBuilder\DataSetQueryBuilderInterface;
use WellCommerce\Component\DataSet\Request\DataSetRequestInterface;
use WellCommerce\Component\DataSet\Transformer\ColumnTransformerCollection;

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
     * @var DataSetQueryBuilderInterface
     */
    protected $dataSetQueryBuilder;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ColumnTransformerCollection
     */
    protected $columnTransformers;

    /**
     * @var DataSetManagerInterface
     */
    protected $manager;

    /**
     * @var array
     */
    protected $defaultContextOptions = [];

    /**
     * @var array
     */
    protected $defaultRequestOptions = [];

    /**
     * Constructor
     *
     * @param DataSetQueryBuilderInterface $dataSetQueryBuilder
     * @param DataSetManagerInterface      $manager
     * @param EventDispatcherInterface     $eventDispatcher
     */
    public function __construct(
        DataSetQueryBuilderInterface $dataSetQueryBuilder,
        DataSetManagerInterface $manager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->dataSetQueryBuilder = $dataSetQueryBuilder;
        $this->manager             = $manager;
        $this->eventDispatcher     = $eventDispatcher;
        $this->columns             = new ColumnCollection();
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
    public function addColumn(ColumnInterface $column)
    {
        $this->columns->add($column);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function configureOptions(DataSetConfiguratorInterface $configurator);

    /**
     * {@inheritdoc}
     */
    public function setDefaultRequestOption($name, $value)
    {
        $this->defaultRequestOptions[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchOnDataSetInitEvent()
    {
        $this->eventDispatcher->dispatchOnDataSetInitEvent($this);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultContextOption($name, $value)
    {
        $this->defaultContextOptions[$name] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult($contextType, array $requestOptions = [], array $contextOptions = [])
    {
        $contextOptions = $this->getContextOptions($contextOptions);
        $requestOptions = $this->getRequestOptions($requestOptions);
        $context        = $this->manager->createContext($contextType, $contextOptions);
        $request        = $this->manager->createRequest($requestOptions);
        $queryBuilder   = $this->getQueryBuilder($request);

        return $context->getResult($queryBuilder, $request, $this->columns);
    }

    public function setContext(DataSetContextInterface $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Returns the default context's options
     *
     * @param array $contextOptions
     *
     * @return array
     */
    protected function getContextOptions(array $contextOptions = [])
    {
        $contextOptions = array_merge($this->defaultContextOptions, $contextOptions);

        return $contextOptions;
    }

    /**
     * Returns the default request's options
     *
     * @param array $requestOptions
     *
     * @return array
     */
    protected function getRequestOptions(array $requestOptions = [])
    {
        $requestOptions = array_merge($this->defaultRequestOptions, $requestOptions);

        return $requestOptions;
    }

    /**
     * Creates a dataset's transformer using factory
     *
     * @param       $type
     * @param array $options
     *
     * @return \WellCommerce\Component\DataSet\Transformer\DataSetTransformerInterface
     */
    protected function getDataSetTransformer($type, array $options = [])
    {
        return $this->manager->createTransformer($type, $options);
    }

    /**
     * Prepares and returns the Doctrine's QueryBuilder
     *
     * @param DataSetRequestInterface $request
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function getQueryBuilder(DataSetRequestInterface $request)
    {
        $columns      = $this->getColumns();
        $queryBuilder = $this->dataSetQueryBuilder->getQueryBuilder($columns, $request);

        return $queryBuilder;
    }
}
