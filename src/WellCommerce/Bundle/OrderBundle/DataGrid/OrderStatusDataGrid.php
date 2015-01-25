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
namespace WellCommerce\Bundle\OrderBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Appearance;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Filter;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DataSet\CollectionBuilder\SelectBuilder;

/**
 * Class OrderStatusDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class OrderStatusDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('order_status.id.label'),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'name',
            'caption' => $this->trans('order_status.name.label'),
            'appearance' => new Appearance([
                'width'   => 340,
            ]),
        ]));


        $collection->add(new Column([
            'id'      => 'groupName',
            'caption' => $this->trans('order_status.group.label'),
            'filter'  => new Filter([
                'type'    => Filter::FILTER_SELECT,
                'options' => $this->getOrderStatusGroups()
            ]),
            'appearance' => new Appearance([
                'width'   => 140,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'      => 'createdAt',
            'caption' => $this->trans('order_status.created_at.label'),
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
     * Returns order status groups to for filter
     *
     * @return array
     */
    protected function getOrderStatusGroups()
    {
        $selectBuilder = new SelectBuilder($this->get('order_status_group.dataset'), [
            'value_key' => 'name',
            'label_key' => 'name',
        ]);

        return $selectBuilder->getItems();
    }
}
