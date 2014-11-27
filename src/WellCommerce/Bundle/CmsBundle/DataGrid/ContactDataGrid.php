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
namespace WellCommerce\Bundle\CmsBundle\DataGrid;

use WellCommerce\Bundle\DataGridBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\DataGrid\Column\ColumnInterface;
use WellCommerce\Bundle\DataGridBundle\DataGrid\DataGridInterface;

/**
 * Class ContactDataGrid
 *
 * @package WellCommerce\Bundle\CmsBundle
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ContactDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function addColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'source'     => 'contact.id',
            'caption'    => $this->trans('Contact.id'),
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
            'id'         => 'name',
            'source'     => 'contact_translation.name',
            'caption'    => $this->trans('Contact.name'),
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