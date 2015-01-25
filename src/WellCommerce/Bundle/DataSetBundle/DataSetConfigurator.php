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

namespace WellCommerce\Bundle\DataSetBundle;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use WellCommerce\Bundle\DataSetBundle\Column\Column;
use WellCommerce\Bundle\DataSetBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataSetBundle\Transformer\TransformerCollection;

/**
 * Class DataSetConfigurator
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetConfigurator implements DataSetConfiguratorInterface
{
    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Constructor
     *
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(DataSetInterface $dataset)
    {
        $this->dataset = $dataset;
        $this->dataset->setColumns(new ColumnCollection());
        $this->dataset->setTransformers(new TransformerCollection());
        $dataset->configureOptions($this);
    }

    /**
     * {@inheritdoc}
     */
    public function setColumns(array $columns = [])
    {
        $collection = $this->dataset->getColumns();

        foreach ($columns as $alias => $source) {
            $collection->add(new Column([
                'alias'  => $alias,
                'source' => $source,
            ]));
        }

        $this->dataset->setColumns($collection);
    }

    /**
     * {@inheritdoc}
     */
    public function setTransformers(array $transformers = [])
    {
        $collection = $this->dataset->getTransformers();

        foreach ($transformers as $column => $transformer) {
            $collection->add($column, $transformer);
        }

        $this->dataset->setTransformers($collection);
    }
}
