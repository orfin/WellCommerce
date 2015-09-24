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

use WellCommerce\Bundle\CoreBundle\DependencyInjection\AbstractContainerAware;
use WellCommerce\Bundle\CoreBundle\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\DataSetBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\Configurator\DataSetConfiguratorInterface;
use WellCommerce\Bundle\DataSetBundle\DataSetInterface;
use WellCommerce\Bundle\DataSetBundle\Loader\DataSetLoaderInterface;
use WellCommerce\Bundle\DataSetBundle\Request\DataSetRequest;
use WellCommerce\Bundle\DataSetBundle\Transformer\TransformerCollection;

/**
 * Class AbstractDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSet extends AbstractContainerAware implements DataSetInterface
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var DataSetLoaderInterface
     */
    protected $loader;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var ColumnCollection
     */
    protected $columns;

    /**
     * @var TransformerCollection
     */
    protected $transformers;

    /**
     * @param string                   $identifier
     * @param DataSetLoaderInterface   $loader
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct($identifier, DataSetLoaderInterface $loader, EventDispatcherInterface $eventDispatcher)
    {
        $this->identifier      = $identifier;
        $this->loader          = $loader;
        $this->eventDispatcher = $eventDispatcher;
        $this->columns         = new ColumnCollection();
        $this->transformers    = new TransformerCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->identifier;
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
    public function getTransformers()
    {
        return $this->transformers;
    }

    /**
     * {@inheritdoc}
     */
    public function setTransformers(TransformerCollection $transformers)
    {
        $this->transformers = $transformers;
    }

    /**
     * {@inheritdoc}
     */
    abstract public function configureOptions(DataSetConfiguratorInterface $configurator);

    /**
     * {@inheritdoc}
     */
    public function getResults(DataSetRequest $request)
    {
        return $this->loader->getResults($this, $request);
    }
}
