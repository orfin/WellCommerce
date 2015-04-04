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
namespace WellCommerce\Bundle\SmugglerBundle\DataGrid;

use WellCommerce\Bundle\DataGridBundle\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\Column\Column;
use WellCommerce\Bundle\DataGridBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Appearance;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Filter;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Sorting;
use WellCommerce\Bundle\DataGridBundle\DataGridInterface;

/**
 * Class PackageDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PackageDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('package.id.label'),
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
            'caption'    => $this->trans('package.name.label'),
        ]));

        $collection->add(new Column([
            'id'         => 'fullName',
            'caption'    => $this->trans('package.full_name.label'),
        ]));

        $collection->add(new Column([
            'id'         => 'vendor',
            'caption'    => $this->trans('package.vendor.label'),
        ]));

        $collection->add(new Column([
            'id'         => 'localVersion',
            'caption'    => $this->trans('package.local_version.label'),
        ]));

        $collection->add(new Column([
            'id'      => 'remoteVersion',
            'caption' => $this->trans('package.remoteVersion.label'),
        ]));

        $collection->add(new Column([
            'id'      => 'createdAt',
            'caption' => $this->trans('package.created_at.label'),
        ]));

        $collection->add(new Column([
            'id'      => 'updatedAt',
            'caption' => $this->trans('package.updated_at.label'),
        ]));
    }
}
