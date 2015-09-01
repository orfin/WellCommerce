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
 * Class CompanyDataGrid
 *
 * @author Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('company.id'),
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
            'caption' => $this->trans('company.name'),
        ]));

        $collection->add(new Column([
            'id'      => 'shortName',
            'caption' => $this->trans('company.short_name'),
        ]));

        $collection->add(new Column([
            'id'      => 'createdAt',
            'caption' => $this->trans('company.created_at'),
            'filter'  => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));
    }
}
