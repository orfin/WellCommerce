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
namespace WellCommerce\Plugin\Company\DataGrid;

use WellCommerce\Core\DataGrid;
use WellCommerce\Core\DataGrid\DataGridInterface;
use WellCommerce\Plugin\Company\Event\CompanyDataGridEvent;

/**
 * Class CompanyDataGrid
 *
 * @package WellCommerce\Plugin\Company\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class CompanyDataGrid extends DataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {
        $this->setOptions([
            'id'             => 'company',
            'event_handlers' => [
                'load'       => $this->getXajaxManager()->registerFunction(['LoadCompany', $this, 'loadData']),
                'edit_row'   => 'editCompany',
                'click_row'  => 'editCompany',
                'delete_row' => $this->getXajaxManager()->registerFunction(['DeleteCompany', $this, 'deleteRow'])
            ],
            'routes'         => [
                'edit' => $this->generateUrl('admin.company.edit')
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $this->addColumn('id', [
            'source'     => 'company.id',
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
            'source'     => 'company.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 70,
                'align' => DataGridInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => DataGridInterface::FILTER_INPUT
            ]
        ]);

        $this->query = $this->getDb()
            ->table('company')
            ->groupBy('company.id');

        $event = new CompanyDataGridEvent($this);

        $this->getDispatcher()->dispatch(CompanyDataGridEvent::DATAGRID_INIT_EVENT, $event);
    }
}