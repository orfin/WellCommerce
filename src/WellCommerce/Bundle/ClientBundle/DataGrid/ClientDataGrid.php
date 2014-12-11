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

use WellCommerce\Bundle\DataGridBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\Options\Appearance;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\Options\Filter;
use WellCommerce\Bundle\DataGridBundle\DataGrid\DataGridInterface;

/**
 * Class ClientDataGrid
 *
 * @package WellCommerce\Bundle\ClientBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function addColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'source'     => 'client.id',
            'caption'    => $this->trans('client.id'),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'firstName',
            'source'     => 'client.firstName',
            'caption'    => $this->trans('client.first_name'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'lastName',
            'source'     => 'client.lastName',
            'caption'    => $this->trans('client.last_name'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'email',
            'source'     => 'client.email',
            'caption'    => $this->trans('client.email'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'phone',
            'source'     => 'client.phone',
            'caption'    => $this->trans('client.phone'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ]),
        ]));

        $collection->add(new Column([
            'id'               => 'createdAt',
            'source'           => 'client.createdAt',
            'caption'          => $this->trans('client.created_at'),
            'appearance'       => new Appearance([
                'width' => 70,
            ]),
            'filter'           => new Filter([
                'type' => Filter::FILTER_BETWEEN
            ]),
            'process_function' => function (\DateTime $createdAt) {
                return $createdAt->format('Y-m-d H:i:s');
            }
        ]));
    }
}