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
namespace WellCommerce\Bundle\ShopBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;

/**
 * Class ShopDataGrid
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopDataGrid extends AbstractDataGrid
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
                'default_order' => Sorting::SORT_DIR_ASC,
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
            'id'         => 'name',
            'caption'    => $this->trans('common.label.name'),
            'appearance' => new Appearance([
                'width' => 100,
                'align' => Appearance::ALIGN_LEFT
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'url',
            'caption'    => $this->trans('common.label.url'),
            'appearance' => new Appearance([
                'width' => 180,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'company',
            'caption'    => $this->trans('shop.label.company'),
            'appearance' => new Appearance([
                'width' => 140,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'theme',
            'caption'    => $this->trans('shop.label.theme'),
            'appearance' => new Appearance([
                'width' => 140,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'country',
            'caption'    => $this->trans('shop.label.default_country'),
            'appearance' => new Appearance([
                'width' => 60,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'currency',
            'caption'    => $this->trans('shop.label.default_currency'),
            'appearance' => new Appearance([
                'width' => 60,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
    }
}
