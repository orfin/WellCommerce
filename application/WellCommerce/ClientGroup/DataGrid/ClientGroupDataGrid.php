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
namespace WellCommerce\ClientGroup\DataGrid;

use Illuminate\Database\Capsule\Manager;
use WellCommerce\Core\DataGrid\AbstractDataGrid;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class ClientGroupDataGrid
 *
 * @package WellCommerce\ClientGroup\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientGroupDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'client_group';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [
            'edit' => $this->generateUrl('admin.client_group.edit')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(array $options)
    {
        $event_handlers            = [
            'update_row' => $this->getXajaxManager()->registerFunction([
                    'update_' . $this->getId(),
                    $this,
                    'updateRow'
                ])
        ];
        $options['event_handlers'] = $event_handlers;

        return parent::configureOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function initColumns(ColumnCollection $columns)
    {
        $columns->add(new DataGridColumn([
            'id'         => 'id',
            'source'     => 'client_group.id',
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
            'source'     => 'client_group_translation.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 600,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $columns->add(new DataGridColumn([
            'id'         => 'discount',
            'source'     => 'client_group.discount',
            'caption'    => $this->trans('Discount'),
            'editable'   => true,
            'appearance' => [
                'width' => 40,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function setQuery(Manager $manager)
    {
        $this->query = $manager->table('client_group');
        $this->query->join('client_group_translation', 'client_group_translation.client_group_id', '=', 'client_group.id');
        $this->query->groupBy('client_group.id');
    }
}