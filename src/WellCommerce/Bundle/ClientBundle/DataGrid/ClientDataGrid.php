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

use WellCommerce\Bundle\DataGridBundle\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\Column\Column;
use WellCommerce\Bundle\DataGridBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Appearance;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Filter;
use WellCommerce\Bundle\DataGridBundle\DataGridInterface;
use WellCommerce\Bundle\DataSetBundle\CollectionBuilder\SelectBuilder;

/**
 * Class ClientDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('client.id.label'),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'firstName',
            'caption' => $this->trans('client.first_name.label'),
            'appearance' => new Appearance([
                'width'   => 140,
                'align' => Appearance::ALIGN_LEFT
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'lastName',
            'caption' => $this->trans('client.last_name.label'),
            'appearance' => new Appearance([
                'width'   => 140,
                'align' => Appearance::ALIGN_LEFT
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'email',
            'caption' => $this->trans('client.email.label'),
            'appearance' => new Appearance([
                'width'   => 60,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'phone',
            'caption' => $this->trans('client.phone.label'),
            'appearance' => new Appearance([
                'width'   => 80,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'groupName',
            'caption' => $this->trans('client.group.label'),
            'filter'  => new Filter([
                'type'    => Filter::FILTER_SELECT,
                'options' => $this->getClientGroups()
            ]),
            'appearance' => new Appearance([
                'width'   => 140,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'createdAt',
            'caption' => $this->trans('client.created_at.label'),
            'filter'  => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
            'appearance' => new Appearance([
                'width'   => 40,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));
    }

    /**
     * Returns client groups to for filter
     *
     * @return array
     */
    protected function getClientGroups()
    {
        $selectBuilder = new SelectBuilder($this->get('client_group.dataset'), [
            'value_key' => 'name',
            'label_key' => 'name',
        ]);

        return $selectBuilder->getItems();
    }
}
