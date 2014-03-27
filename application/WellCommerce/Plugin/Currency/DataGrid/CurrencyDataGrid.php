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
namespace WellCommerce\Plugin\Currency\DataGrid;

use WellCommerce\Core\DataGrid,
    WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class CurrencyDataGrid
 *
 * @package WellCommerce\Plugin\Currency\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CurrencyDataGrid extends DataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setOptions([
            'id'             => 'currency',
            'event_handlers' => [
                'load'       => $this->getXajaxManager()->registerFunction(['LoadCurrency', $this, 'loadData']),
                'edit_row'   => 'editCurrency',
                'click_row'  => 'editCurrency',
                'delete_row' => $this->getXajaxManager()->registerFunction(['DeleteCurrency', $this, 'deleteRow'])
            ],
            'routes'         => [
                'edit' => $this->generateUrl('admin.currency.edit')
            ]
        ]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->addColumn('id', [
            'source'     => 'currency.id',
            'caption'    => $this->trans('Id'),
            'sorting'    => [
                'default_order' => DataGridInterface::SORT_DIR_DESC
            ],
            'appearance' => [
                'width'   => 90,
                'visible' => false
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_BETWEEN
            ]
        ]);

        $this->addColumn('name', [
            'source'     => 'currency.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 70,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);

        $this->addColumn('symbol', [
            'source'     => 'currency.symbol',
            'caption'    => $this->trans('Symbol'),
            'appearance' => [
                'width' => 70,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);
        
        $this->query = $this->getDb()
            ->table('currency')
            ->groupBy('currency.id');
    }
}