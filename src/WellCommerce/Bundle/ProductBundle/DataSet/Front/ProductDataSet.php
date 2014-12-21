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

namespace WellCommerce\Bundle\ProductBundle\DataSet\Front;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;

/**
 * Class ProductDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'product.id'
        ]));

        $collection->add(new Column([
            'alias'  => 'name',
            'source' => 'product_translation.name'
        ]));

        $collection->add(new Column([
            'alias'  => 'shortDescription',
            'source' => 'product_translation.shortDescription'
        ]));

        $collection->add(new Column([
            'alias'  => 'description',
            'source' => 'product_translation.description'
        ]));

        $collection->add(new Column([
            'alias'  => 'route',
            'source' => 'IDENTITY(product_translation.route)'
        ]));

        $collection->add(new Column([
            'alias'  => 'price',
            'source' => 'product.sellPrice'
        ]));

        $collection->add(new Column([
            'alias'  => 'currency',
            'source' => 'sell_currency.code'
        ]));

        $collection->add(new Column([
            'alias'  => 'stock',
            'source' => 'product.stock',
        ]));

        $collection->add(new Column([
            'alias'  => 'category',
            'source' => 'categories.id',
        ]));

        $collection->add(new Column([
            'alias'  => 'photo',
            'source' => 'photos.path',
        ]));
    }
}