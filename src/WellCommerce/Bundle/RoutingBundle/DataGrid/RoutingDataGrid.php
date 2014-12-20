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
namespace WellCommerce\Bundle\RoutingBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class RoutingDataGrid
 *
 * @package WellCommerce\Bundle\RoutingBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class RoutingDataGrid extends AbstractDataGrid implements DataGridInterface
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
            'sorting'    => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance' => [
                'width'   => 90,
                'visible' => false
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $collection->add(new Column([
            'id'         => 'name',
            'source'     => 'product_translation.name',
            'caption'    => $this->trans('product.name'),
            'appearance' => [
                'width' => 70,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $collection->add(new Column([
            'id'         => 'sellPrice',
            'source'     => 'product.sellPrice',
            'caption'    => $this->trans('Price net'),
            'editable'   => true,
            'appearance' => [
                'width' => 70,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $collection->add(new Column([
            'id'         => 'stock',
            'source'     => 'product.stock',
            'caption'    => $this->trans('Stock'),
            'editable'   => true,
            'appearance' => [
                'width' => 70,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));
    }
}