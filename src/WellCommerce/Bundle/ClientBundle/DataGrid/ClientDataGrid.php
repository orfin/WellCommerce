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
namespace WellCommerce\Bundle\ClientBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\Column\Column;
use WellCommerce\Bundle\DataGridBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Appearance;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Filter;

/**
 * Class ClientDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('admin.client.label.id'),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'firstName',
            'caption'    => $this->trans('admin.client.label.first_name'),
            'appearance' => new Appearance([
                'width' => 140,
                'align' => Appearance::ALIGN_LEFT
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'lastName',
            'caption'    => $this->trans('admin.client.label.last_name'),
            'appearance' => new Appearance([
                'width' => 140,
                'align' => Appearance::ALIGN_LEFT
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'email',
            'caption'    => $this->trans('admin.client.label.email'),
            'appearance' => new Appearance([
                'width' => 60,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'phone',
            'caption'    => $this->trans('admin.client.label.phone'),
            'appearance' => new Appearance([
                'width' => 80,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'groupName',
            'caption'    => $this->trans('admin.client.label.client_group'),
            'filter'     => new Filter([
                'type'    => Filter::FILTER_SELECT,
                'options' => $this->get('client_group.collection')->getSelect()
            ]),
            'appearance' => new Appearance([
                'width' => 140,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'createdAt',
            'caption'    => $this->trans('admin.client.label.created_at'),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
            'appearance' => new Appearance([
                'width' => 40,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
    }
}
