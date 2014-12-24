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

namespace WellCommerce\Bundle\CategoryBundle\DataSet\Front;

use WellCommerce\Bundle\CoreBundle\DataSet\AbstractDataSet;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataSet\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataSet\DataSetInterface;

/**
 * Class CategoryDataSet
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CategoryDataSet extends AbstractDataSet implements DataSetInterface
{
    /**
     * {@inheritdoc}
     */
    protected function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'alias'  => 'id',
            'source' => 'category.id'
        ]));

        $collection->add(new Column([
            'alias'  => 'parent',
            'source' => 'IDENTITY(category.parent)',
        ]));

        $collection->add(new Column([
            'alias'      => 'children',
            'source'     => 'COUNT(category_children.id)',
            'aggregated' => true
        ]));

        $collection->add(new Column([
            'alias'      => 'products',
            'source'     => 'COUNT(category_products.id)',
            'aggregated' => true
        ]));

        $collection->add(new Column([
            'alias'  => 'name',
            'source' => 'category_translation.name'
        ]));

        $collection->add(new Column([
            'alias'  => 'route',
            'source' => 'IDENTITY(category_translation.route)',
        ]));
    }
}