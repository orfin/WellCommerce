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
namespace WellCommerce\Client\DataGrid;

use Illuminate\Database\Capsule\Manager;
use WellCommerce\Core\DataGrid\AbstractDataGrid;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class ClientDataGrid
 *
 * @package WellCommerce\Client\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [
            'edit' => $this->generateUrl('admin.client.edit')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(array $options)
    {
        $options['event_handlers'] = [
            'update_row' => $this->getXajaxManager()->registerFunction([
                    'update_' . $this->getId(),
                    $this,
                    'updateRow'
                ]),
        ];

        $options['filters'] = [
            'client_group_id' => $this->get('client_group.repository')->getAllClientGroupToFilter()
        ];

        return parent::configureOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function initColumns(ColumnCollection $collection)
    {
        $collection->add(new DataGridColumn([
            'id'         => 'id',
            'source'     => 'client.id',
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

        $collection->add(new DataGridColumn([
            'id'         => 'first_name',
            'source'     => 'client.first_name',
            'caption'    => $this->trans('First name'),
            'appearance' => [
                'width' => 70
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'last_name',
            'source'     => 'client.last_name',
            'caption'    => $this->trans('Last name'),
            'appearance' => [
                'width' => 70
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'email',
            'source'     => 'client.email',
            'caption'    => $this->trans('E-mail'),
            'appearance' => [
                'width' => 70
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'phone',
            'source'     => 'client.phone',
            'caption'    => $this->trans('Phone'),
            'appearance' => [
                'width' => 70
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'client_group_id',
            'source'     => 'client.client_group_id',
            'caption'    => $this->trans('Group'),
            'appearance' => [
                'width' => 50,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_SELECT
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'discount',
            'source'     => 'client.discount',
            'caption'    => $this->trans('Discount'),
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
        $this->query = $manager->table('client');
        $this->query->groupBy('client.id');
    }
}
