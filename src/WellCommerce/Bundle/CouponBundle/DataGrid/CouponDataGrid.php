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
namespace WellCommerce\Bundle\CouponBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;

/**
 * Class CouponDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CouponDataGrid extends AbstractDataGrid
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
            'id'      => 'name',
            'caption' => $this->trans('common.label.name'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'code',
            'caption' => $this->trans('common.label.code'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'discount',
            'caption' => $this->trans('common.label.discount'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'minimumOrderValue',
            'caption' => $this->trans('common.label.minimum_order_value'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'createdAt',
            'caption' => $this->trans('common.label.created_at'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'validFrom',
            'caption' => $this->trans('common.label.valid_from'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'validTo',
            'caption' => $this->trans('common.label.valid_to'),
        ]));
    }
}
