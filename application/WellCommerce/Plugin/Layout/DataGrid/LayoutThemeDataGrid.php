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

use WellCommerce\Core\Component\DataGrid\AbstractDataGrid;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;
use WellCommerce\Plugin\Layout\Event\LayoutThemeDataGridEvent;

/**
 * Class LayoutThemeDataGrid
 *
 * @package WellCommerce\Plugin\LayoutTheme\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutThemeDataGrid extends AbstractDataGrid implements DataGridInterface
{
    public function configure()
    {
        $this->setOptions([
            'id'             => 'layout_theme',
            'event_handlers' => [
                'load'       => $this->getXajaxManager()->registerFunction(['LoadLayoutTheme', $this, 'loadData']),
                'edit_row'   => 'editLayoutTheme',
                'click_row'  => 'editLayoutTheme',
                'delete_row' => $this->getXajaxManager()->registerFunction(['DeleteLayoutTheme', $this, 'deleteRow']),
            ],
            'routes'         => [
                'edit' => $this->generateUrl('admin.layout_theme.edit')
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->addColumn('id', [
            'source'     => 'layout_theme.id',
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
            'source'     => 'layout_theme.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 150,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);

        $this->addColumn('folder', [
            'source'     => 'layout_theme.folder',
            'caption'    => $this->trans('Folder'),
            'appearance' => [
                'width' => 60,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);

        $this->query = $this->getDb()
            ->table('layout_theme')
            ->groupBy('layout_theme.id');

        $event = new LayoutThemeDataGridEvent($this);

        $this->getDispatcher()->dispatch(LayoutThemeDataGridEvent::DATAGRID_INIT_EVENT, $event);
    }
}