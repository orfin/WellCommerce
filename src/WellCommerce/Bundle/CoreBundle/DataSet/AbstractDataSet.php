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
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\Loader\DataSetLoaderInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequest;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerCollection;

/**
 * Class AbstractDataSet
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
abstract class AbstractDataSet extends ContainerAware
{
    /**
     * @var string
     */
    protected $identifier;

    /**
     * @var DataSetLoaderInterface
     */
    private $loader;

    /**
     * @var ColumnCollection
     */
    private $columns;

    /**
     * @var TransformerCollection
     */
    private $transformers;

    /**
     * Constructor
     *
     * @param string                 $identifier
     * @param DataSetLoaderInterface $loader
     */
    public function __construct($identifier, DataSetLoaderInterface $loader)
    {
        $this->identifier = $identifier;
        $this->loader     = $loader;
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
