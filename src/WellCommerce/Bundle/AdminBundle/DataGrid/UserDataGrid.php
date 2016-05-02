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
namespace WellCommerce\Bundle\AdminBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\ColumnInterface;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;

/**
 * Class UserDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class UserDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('user.label.id'),
            'sorting'    => new Sorting([
                'default_order' => ColumnInterface::SORT_DIR_DESC,
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
            'id'      => 'username',
            'caption' => $this->trans('user.label.username'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'email',
            'caption' => $this->trans('user.label.email'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'first_name',
            'caption' => $this->trans('user.label.first_name'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'last_name',
            'caption' => $this->trans('user.label.last_name'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'enabled',
            'caption' => $this->trans('user.label.enabled'),
        ]));
    }
}
