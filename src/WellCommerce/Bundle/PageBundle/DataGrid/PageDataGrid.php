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
namespace WellCommerce\Bundle\PageBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;

/**
 * Class PageDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PageDataGrid extends AbstractDataGrid
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
            'id'      => 'section',
            'caption' => $this->trans('page.label.section'),
        ]));
        
        $collection->add(new Column([
            'id'         => 'hierarchy',
            'caption'    => $this->trans('common.label.hierarchy'),
            'appearance' => new Appearance([
                'width' => 90,
            ]),
            'editable'   => true,
        ]));
        
        $collection->add(new Column([
            'id'         => 'publish',
            'caption'    => $this->trans('common.label.publish'),
            'appearance' => new Appearance([
                'width' => 90,
            ]),
            'selectable' => true,
            'filter'     => new Filter([
                'type'    => Filter::FILTER_SELECT,
                'options' => [
                    0 => 'No',
                    1 => 'Yes',
                ],
            ]),
        ]));
    }
}
