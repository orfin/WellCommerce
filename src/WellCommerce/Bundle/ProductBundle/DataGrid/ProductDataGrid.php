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
namespace WellCommerce\Bundle\ProductBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Appearance;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Filter;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class ProductDataGrid
 *
 * @package WellCommerce\Bundle\ProductBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function addColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'source'     => 'product.id',
            'caption'    => $this->trans('product.id'),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'name',
            'source'     => 'product_translation.name',
            'caption'    => $this->trans('product.name.label'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'sellPrice',
            'source'     => 'product.sellPrice',
            'caption'    => $this->trans('product.sell_price.label'),
            'editable'   => true,
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'stock',
            'source'     => 'product.stock',
            'caption'    => $this->trans('product.stock.label'),
            'editable'   => true,
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ])
        ]));
    }
}