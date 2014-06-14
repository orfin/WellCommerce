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
namespace WellCommerce\Plugin\Product\DataGrid;

use Illuminate\Database\Capsule\Manager;
use WellCommerce\Core\Component\DataGrid\AbstractDataGrid;
use WellCommerce\Core\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Core\Component\DataGrid\Column\ColumnInterface;
use WellCommerce\Core\Component\DataGrid\Column\DataGridColumn;
use WellCommerce\Core\Component\DataGrid\DataGridInterface;

/**
 * Class ProductDataGrid
 *
 * @package WellCommerce\Plugin\Product\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function getRoutes()
    {
        return [
            'index' => $this->generateUrl('admin.product.index'),
            'edit'  => $this->generateUrl('admin.product.edit')
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(array $options)
    {
        $event_handlers            = [
            'update_row' => $this->getXajaxManager()->registerFunction([
                    'update_' . $this->getId(),
                    $this,
                    'updateRow'
                ]),
            'process'    => 'processProduct',
            'loaded'     => 'dataLoaded'
        ];
        $options['event_handlers'] = $event_handlers;

        return parent::configureOptions($options);
    }

    /**
     * {@inheritdoc}
     */
    public function initColumns(ColumnCollection $collection)
    {
        $collection->add(new DataGridColumn([
            'id'         => 'id',
            'source'     => 'product.id',
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
            'source'     => 'product_translation.name',
            'caption'    => $this->trans('Name'),
            'appearance' => [
                'width' => 70,
                'align' => ColumnInterface::ALIGN_LEFT
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'               => 'preview',
            'source'           => 'product.photo_id',
            'caption'          => $this->trans('Thumb'),
            'sorting'          => [
                'default_order' => ColumnInterface::SORT_DIR_DESC
            ],
            'appearance'       => [
                'width'   => 90,
                'visible' => false
            ],
            'process_function' => function ($id) {
                    if ((int)$id == 0) {
                        return '';
                    }

                    return $this->getImageGallery()->getImageUrl($id, 100, 100);
                }
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'sku',
            'source'     => 'product.sku',
            'caption'    => $this->trans('SKU'),
            'editable'   => true,
            'appearance' => [
                'width' => 20,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'            => 'category',
            'source'        => 'GROUP_CONCAT(DISTINCT SUBSTRING(CONCAT(\' \', category_translation.name), 1))',
            'caption'       => $this->trans('Category'),
            'appearance'    => [
                'width' => 120,
            ],
            'filter'        => [
                'type' => ColumnInterface::FILTER_INPUT
            ],
            'aggregated' => true
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'ean',
            'source'     => 'product.ean',
            'caption'    => $this->trans('EAN'),
            'editable'   => true,
            'appearance' => [
                'width' => 60,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_INPUT
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'sell_price',
            'source'     => 'product.sell_price',
            'caption'    => $this->trans('Price net'),
            'editable'   => true,
            'appearance' => [
                'width' => 40,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'sell_price_gross',
            'source'     => 'product.sell_price',
            'caption'    => $this->trans('Price gross'),
            'editable'   => true,
            'appearance' => [
                'width' => 40,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'stock',
            'source'     => 'product.stock',
            'caption'    => $this->trans('Stock'),
            'editable'   => true,
            'appearance' => [
                'width' => 40,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'hierarchy',
            'source'     => 'product.hierarchy',
            'caption'    => $this->trans('Hierarchy'),
            'editable'   => true,
            'appearance' => [
                'width' => 40,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));

        $collection->add(new DataGridColumn([
            'id'         => 'weight',
            'source'     => 'product.weight',
            'caption'    => $this->trans('Weight'),
            'editable'   => true,
            'appearance' => [
                'width' => 40,
            ],
            'filter'     => [
                'type' => ColumnInterface::FILTER_BETWEEN
            ]
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function setQuery(Manager $manager)
    {
        $this->query = $manager->table('product');
        $this->query->join('product_translation', 'product_translation.product_id', '=', 'product.id');
        $this->query->leftJoin('product_category', 'product_category.product_id', '=', 'product.id');
        $this->query->leftJoin('category_translation', 'category_translation.category_id', '=', 'product_category.category_id');
        $this->query->groupBy('product.id');
    }
}