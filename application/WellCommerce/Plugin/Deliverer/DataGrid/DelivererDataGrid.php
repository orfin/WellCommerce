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
namespace WellCommerce\Plugin\Deliverer\DataGrid;

use WellCommerce\Core\DataGrid,
    WellCommerce\Core\DataGrid\DataGridInterface;
use WellCommerce\Plugin\Deliverer\Event\DelivererDataGridEvent;

/**
 * Class DelivererDataGrid
 *
 * @package WellCommerce\Plugin\Deliverer\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class DelivererDataGrid extends DataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setOptions([
            'id'             => 'product',
            'event_handlers' => [
                'load'       => $this->getXajaxManager()->registerFunction(['LoadDeliverer', $this, 'loadData']),
                'edit_row'   => 'editDeliverer',
                'click_row'  => 'editDeliverer',
                'delete_row' => $this->getXajaxManager()->registerFunction(['DeleteDeliverer', $this, 'deleteRow'])
            ],
            'routes'         => [
                'edit' => $this->generateUrl('admin.deliverer.edit')
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->addColumn('id', [
            'source'     => 'deliverer.id',
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
            'source'     => 'deliverer_translation.name',
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
            ->table('deliverer')
            ->join('deliverer_translation', 'deliverer_translation.deliverer_id', '=', 'deliverer.id')
            ->groupBy('deliverer.id');

        $event = new DelivererDataGridEvent($this);

        $this->getDispatcher()->dispatch(DelivererDataGridEvent::DATAGRID_INIT_EVENT, $event);
    }
}