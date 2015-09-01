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
namespace WellCommerce\Bundle\MultiStoreBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\Column\Column;
use WellCommerce\Bundle\DataGridBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Appearance;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Filter;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Sorting;

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
            'caption'    => $this->trans('shop.id.label'),
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
            'id'      => 'name',
            'caption' => $this->trans('shop.name.label'),
        ]));

        $collection->add(new Column([
            'id'         => 'url',
            'caption'    => $this->trans('shop.url.label'),
            'appearance' => new Appearance([
                'width' => 180,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'company',
            'caption'    => $this->trans('shop.company.label'),
            'appearance' => new Appearance([
                'width' => 140,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'theme',
            'caption'    => $this->trans('shop.theme.label'),
            'appearance' => new Appearance([
                'width' => 140,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
    }
}
