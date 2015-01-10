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

namespace WellCommerce\Bundle\CoreBundle\DataSet\CollectionBuilder;

use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;

/**
 * Class CollectionBuilderFactory
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CollectionBuilderFactory implements CollectionBuilderFactoryInterface
{
    /**
     * @var DataSetInterface
     */
    protected $dataset;

    /**
     * @param DataSetInterface $dataset
     */
    public function __construct(DataSetInterface $dataset)
    {
        $this->dataset = $dataset;
    }

    /**
     * {@inheritdoc}
     */
    public function getTree(array $options = [])
    {
        $treeBuilder = new TreeBuilder($this->dataset, $options);

        return $treeBuilder->getItems();
    }

    /**
     * {@inheritdoc}
     */
    public function getFlatTree(array $options = [])
    {
        $flatTreeBuilder = new FlatTreeBuilder($this->dataset, $options);

        return $flatTreeBuilder->getItems();
    }

    /**
     * {@inheritdoc}
     */
    public function getSelect(array $options = [])
    {
        $selectBuilder = new SelectBuilder($this->dataset, $options);

        return $selectBuilder->getItems();
    }
} 