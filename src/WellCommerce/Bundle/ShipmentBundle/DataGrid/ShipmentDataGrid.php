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
namespace WellCommerce\Bundle\ShipmentBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;

/**
 * Class ShipmentDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShipmentDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('common.label.id'),
            'sorting'    => new Sorting([
                'default_order' => Sorting::SORT_DIR_DESC,
            ]),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'guid',
            'caption'    => $this->trans('shipment.label.guid'),
            'appearance' => new Appearance([
                'width' => 90,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
    
        $collection->add(new Column([
            'id'         => 'packageNumber',
            'caption'    => $this->trans('shipment.label.package_number'),
            'appearance' => new Appearance([
                'width' => 90,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'orderNumber',
            'caption'    => $this->trans('shipment.label.order_number'),
            'appearance' => new Appearance([
                'width' => 120,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
    
        $collection->add(new Column([
            'id'         => 'courier',
            'caption'    => $this->trans('shipment.label.courier'),
            'appearance' => new Appearance([
                'width' => 120,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
    
        $collection->add(new Column([
            'id'         => 'createdAt',
            'caption'    => $this->trans('common.label.created_at'),
            'appearance' => new Appearance([
                'width' => 80,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
    }
}
