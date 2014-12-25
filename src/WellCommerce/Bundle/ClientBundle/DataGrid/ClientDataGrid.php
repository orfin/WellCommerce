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
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Appearance;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Filter;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

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
                'visible' => false
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ])
        ]));

        $collection->add(new Column([
            'id'      => 'firstName',
            'caption' => $this->trans('client.first_name.label'),
        ]));

        $collection->add(new Column([
            'id'      => 'lastName',
            'caption' => $this->trans('client.last_name.label'),
        ]));

        $collection->add(new Column([
            'id'      => 'email',
            'caption' => $this->trans('client.email.label'),
        ]));

        $collection->add(new Column([
            'id'      => 'phone',
            'caption' => $this->trans('client.phone.label'),
        ]));

        $collection->add(new Column([
            'id'      => 'createdAt',
            'caption' => $this->trans('client.created_at.label'),
            'filter'  => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ])
        ]));
    }
}