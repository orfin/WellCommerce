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
namespace WellCommerce\Bundle\IntlBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class CurrencyDataGrid
 *
 * @package WellCommerce\Bundle\IntlBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function addColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'source'     => 'currency.id',
            'caption'    => $this->trans('currency.id'),
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

        $collection->add(new Column([
            'id'         => 'code',
            'source'     => 'currency.code',
            'caption'    => $this->trans('currency.code'),
            'appearance' => [
                'width' => 70,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));
    }
}