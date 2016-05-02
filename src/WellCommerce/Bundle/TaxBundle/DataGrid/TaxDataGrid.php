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
namespace WellCommerce\Bundle\TaxBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;

/**
 * Class TaxDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class TaxDataGrid extends AbstractDataGrid
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
            'id'         => 'name',
            'caption'    => $this->trans('common.label.name'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'value',
            'caption'    => $this->trans('tax.label.value'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT,
            ]),
        ]));
    }
}
