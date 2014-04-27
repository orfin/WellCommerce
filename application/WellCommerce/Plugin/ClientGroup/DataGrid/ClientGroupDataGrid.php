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
namespace WellCommerce\Plugin\ClientGroup\DataGrid;

use WellCommerce\Core\Component\DataGrid\AbstractDataGrid;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;
use WellCommerce\Plugin\ClientGroup\Event\ClientGroupDataGridEvent;

/**
 * Class ClientGroupDataGrid
 *
 * @package WellCommerce\Plugin\ClientGroup\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildDataGrid()
    {
        $this->addColumn('id', [
            'source'     => 'client_group.id',
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
            'source'     => 'client_group_translation.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 600,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);

        $this->addColumn('discount', [
            'source'     => 'client_group.discount',
            'caption'    => $this->trans('Discount'),
            'appearance' => [
                'width' => 40,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_BETWEEN
            ]
        ]);

        $this->query = $this->getDb()
            ->table('client_group')
            ->join('client_group_translation', 'client_group_translation.client_group_id', '=', 'client_group.id')
            ->groupBy('client_group.id');

        return $this;
    }
}