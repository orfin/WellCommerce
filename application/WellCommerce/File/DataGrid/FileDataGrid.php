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
namespace WellCommerce\File\DataGrid;

use Illuminate\Database\Capsule\Manager;
use WellCommerce\Core\DataGrid\AbstractDataGrid;
use WellCommerce\Core\DataGrid\Column\Column;
use WellCommerce\Core\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class FileDataGrid
 *
 * @package WellCommerce\File\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class FileDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function addColumns()
    {
        $this->columns->add(new Column([
            'id'         => 'id',
            'source'     => 'file.id',
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

        $this->columns->add(new Column([
            'id'         => 'name',
            'source'     => 'file.name',
            'caption'    => $this->trans('Name'),
            'sorting'    => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance' => [
                'width' => 190,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $this->columns->add(new Column([
            'id'         => 'extension',
            'source'     => 'file.extension',
            'caption'    => $this->trans('Extension'),
            'sorting'    => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance' => [
                'width' => 90,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $this->columns->add(new Column([
            'id'               => 'preview',
            'source'           => 'file.id',
            'caption'          => $this->trans('Thumb'),
            'sorting'          => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance'       => [
                'width' => 90,
            ],
            'process_function' => function ($id) {
                    return $this->getImageGallery()->getImageUrl($id, 100, 100);
                }
        ]));
    }
}