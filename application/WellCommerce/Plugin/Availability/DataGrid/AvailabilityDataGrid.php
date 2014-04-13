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
namespace WellCommerce\Plugin\Availability\DataGrid;

use WellCommerce\Core\Component\DataGrid\AbstractDataGrid;
use WellCommerce\Core\Component\DataGrid\DataGridBuilder;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;
use WellCommerce\Plugin\Availability\Event\AvailabilityDataGridEvent;

/**
 * Class AvailabilityDataGrid
 *
 * @package WellCommerce\Plugin\Availability\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class AvailabilityDataGrid extends AbstractDataGrid implements DataGridInterface
{
    public function buildDataGrid()
    {
        $this->addColumn('id', [
            'source'     => 'availability.id',
            'caption'    => $this->trans('Id'),
            'sorting'    => [
                'default_order' => DataGridInterface::SORT_DIR_DESC
            ],
            'appearance' => [
                'width'   => 90,
                'visible' => false
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_BETWEEN
            ]
        ]);

        $this->addColumn('name', [
            'source'     => 'availability_translation.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 70,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);

        $this->query = $this->getDb()
            ->table('availability')
            ->join('availability_translation', 'availability_translation.availability_id', '=', 'availability.id')
            ->groupBy('availability.id');

        return $this;
    }
}
