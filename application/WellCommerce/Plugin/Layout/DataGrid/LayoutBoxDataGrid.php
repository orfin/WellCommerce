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
namespace WellCommerce\Plugin\Layout\DataGrid;

use WellCommerce\Core\DataGrid,
    WellCommerce\Core\DataGrid\DataGridInterface;
use WellCommerce\Plugin\Layout\Event\LayoutBoxDataGridEvent;

/**
 * Class LayoutBoxDataGrid
 *
 * @package WellCommerce\Plugin\LayoutBox\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxDataGrid extends DataGrid implements DataGridInterface
{
    public function configure()
    {
        $this->setOptions([
            'id'             => 'layout_box',
            'event_handlers' => [
                'load'       => $this->getXajaxManager()->registerFunction(['LoadLayoutBox', $this, 'loadData']),
                'edit_row'   => 'editLayoutBox',
                'click_row'  => 'editLayoutBox',
                'delete_row' => $this->getXajaxManager()->registerFunction(['DeleteLayoutBox', $this, 'deleteRow']),
            ],
            'routes'         => [
                'edit' => $this->generateUrl('admin.layout_box.edit')
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->addColumn('id', [
            'source'     => 'layout_box.id',
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

        $this->addColumn('identifier', [
            'source'     => 'layout_box.identifier',
            'caption'    => $this->trans('Identifier'),
            'appearance' => [
                'width' => 150,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);

        $this->addColumn('alias', [
            'source'     => 'layout_box.alias',
            'caption'    => $this->trans('Type'),
            'appearance' => [
                'width' => 60,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);

        $this->query = $this->getDb()
            ->table('layout_box')
            ->groupBy('layout_box.id');

        $event = new LayoutBoxDataGridEvent($this);

        $this->getDispatcher()->dispatch(LayoutBoxDataGridEvent::DATAGRID_INIT_EVENT, $event);
    }
}