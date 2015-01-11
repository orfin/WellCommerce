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

use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\Transformer\TransformerCollection;

/**
 * Class DataSetOptionsResolver
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class DataSetOptionsResolver
{
    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @var array
     */
    protected $transformers = [];

    /**
     * Sets dataset columns
     *
     * @param array $columns
     */
    public function setColumns(array $columns = [])
    {
        $this->columns = $columns;
    }

    /**
     * Sets dataset transformers
     *
     * @param array $transformers
     */
    public function setTransformers(array $transformers = [])
    {
        $this->transformers = $transformers;
    }

    /**
     * Resolves columns and adds them to collection
     *
     * @param ColumnCollection $collection
     */
    public function resolveColumns(ColumnCollection $collection)
    {
        foreach ($this->columns as $alias => $source) {
            $collection->add(new Column([
                'alias'  => $alias,
                'source' => $source,
            ]));
        }
    }

    /**
     * Resolves transformers and adds them to collection
     *
     * @param TransformerCollection $collection
     */
    public function resolveTransformers(TransformerCollection $collection)
    {
        foreach ($this->transformers as $column => $transformer) {
            $collection->add($column, $transformer);
        }
    }
}
