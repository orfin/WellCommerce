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
namespace WellCommerce\Bundle\AvailabilityBundle\DataGrid;

use WellCommerce\Bundle\DataGridBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\Options\Appearance;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\Options\Filter;
use WellCommerce\Bundle\DataGridBundle\DataGrid\DataGridInterface;

/**
 * Class AvailabilityDataGrid
 *
 * @package WellCommerce\Bundle\AvailabilityBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function addColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'source'     => 'availability.id',
            'caption'    => $this->trans('availability.id'),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'name',
            'source'     => 'availability_translation.name',
            'caption'    => $this->trans('availability.name'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ])
        ]));
    }
}