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
namespace WellCommerce\PaymentMethod\DataGrid;

use Illuminate\Database\Capsule\Manager;
use WellCommerce\Core\DataGrid\AbstractDataGrid;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class PaymentMethodDataGrid
 *
 * @package WellCommerce\PaymentMethod\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'payment_method';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [
            'edit' => $this->generateUrl('admin.payment_method.edit')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function initColumns(ColumnCollection $collection)
    {
        $collection->add(new DataGridColumn([
            'id'         => 'id',
            'source'     => 'payment_method.id',
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
            'id'         => 'name',
            'source'     => 'payment_method_translation.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 70,
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
        $this->query = $manager->table('payment_method');
        $this->query->join('payment_method_translation', 'payment_method_translation.payment_method_id', '=', 'payment_method.id');
        $this->query->groupBy('payment_method.id');
    }
}