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

use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\Request\DataSetRequest;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerCollection;

/**
 * Interface DataSetInterface
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
interface DataSetInterface
{
    /**
     * Returns dataset identifier
     *
     * @return string
     */
    public function getIdentifier();

    /**
     * Returns dataset columns
     *
     * @return ColumnCollection
     */
    public function getColumns();

    /**
     * Sets dataset columns
     *
     * @param ColumnCollection $columns
     */
    public function setColumns(ColumnCollection $columns);

    /**
     * Returns transformers collection
     *
     * @return TransformerCollection
     */
    public function getTransformers();

    /**
     * Sets transformers collection
     *
     * @param TransformerCollection $transformers
     */
    public function setTransformers(TransformerCollection $transformers);

    /**
     * Initializes dataset and returns results
     *
     * @param DataSetRequest $request
     *
     * @return mixed
     */
    public function getResults(DataSetRequest $request);

    /**
     * Configures dataset options
     *
     * @param DataSetConfiguratorInterface $resolver
     */
    public function configureOptions(DataSetConfiguratorInterface $configurator);
}
