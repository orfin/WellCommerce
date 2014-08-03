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

namespace WellCommerce\Product\DataSet;

use WellCommerce\Core\DataSet\AbstractDataSet;
use WellCommerce\Core\DataSet\Column\Column;
use WellCommerce\Core\DataSet\DataSetInterface;

/**
 * Class ProductDataSet
 *
 * @package WellCommerce\Product\DataSet
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSet extends AbstractDataSet implements DataSetInterface
{

    public function addColumns()
    {
        $this->columns->add(new Column([
            'id'     => 'id',
            'source' => 'product.id',
        ]));

        $this->columns->add(new Column([
            'id'     => 'name',
            'source' => 'product_translation.name',
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $options)
    {
        $this->setCurrentRequest(new ProductDataSetRequest([
            'starting_from' => (int)$options['starting_from'],
            'limit'         => (int)$options['limit'],
            'order_by'      => $options['order_by'],
            'order_dir'     => $options['order_dir']
        ]));

        return $this->loader->getResults($this);
    }
} 