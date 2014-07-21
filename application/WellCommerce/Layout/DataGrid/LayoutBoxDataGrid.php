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
namespace WellCommerce\Layout\DataGrid;

use Illuminate\Database\Capsule\Manager;
use WellCommerce\Core\DataGrid\AbstractDataGrid;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class LayoutBoxDataGrid
 *
 * @package WellCommerce\LayoutBox\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutBoxDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'layout_box';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [
            'edit' => $this->generateUrl('admin.layout_box.edit')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function initColumns(ColumnCollection $columns)
    {
        $columns->add(new DataGridColumn([
            'id'         => 'id',
            'source'     => 'layout_box.id',
            'caption'    => $this->trans('Id'),
            'sorting'    => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance' => [
                'width'   => 90,
                'visible' => false
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $columns->add(new DataGridColumn([
            'id'         => 'name',
            'source'     => 'layout_box_translation.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 60,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $columns->add(new DataGridColumn([
            'id'         => 'type',
            'source'     => 'layout_box.type',
            'caption'    => $this->trans('Type'),
            'appearance' => [
                'width' => 60,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function setQuery(Manager $manager)
    {
        $this->query = $manager->table('layout_box');
        $this->query->leftJoin('layout_box_translation', 'layout_box_translation.layout_box_id', '=', 'layout_box.id');
        $this->query->groupBy('layout_box.id');
    }
}