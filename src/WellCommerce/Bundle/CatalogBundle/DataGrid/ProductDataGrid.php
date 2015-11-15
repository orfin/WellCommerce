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
namespace WellCommerce\Bundle\CatalogBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\DataGridBundle\Column\Column;
use WellCommerce\Bundle\DataGridBundle\Column\ColumnCollection;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Appearance;
use WellCommerce\Bundle\DataGridBundle\Column\Options\Filter;
use WellCommerce\Bundle\DataGridBundle\Configuration\EventHandler\UpdateRowEventHandler;
use WellCommerce\Bundle\DataGridBundle\Options\OptionsInterface;

/**
 * Class ProductDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('product.label.id'),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'name',
            'caption'    => $this->trans('product.label.name'),
            'appearance' => new Appearance([
                'width' => 200,
            ]),
        ]));

        $collection->add(new Column([
            'id'       => 'sku',
            'editable' => true,
            'caption'  => $this->trans('product.label.sku'),
        ]));

        $collection->add(new Column([
            'id'      => 'category',
            'caption' => $this->trans('product.label.categories'),
        ]));

        $collection->add(new Column([
            'id'       => 'grossAmount',
            'caption'  => $this->trans('product.label.gross_amount'),
            'editable' => true,
            'filter'   => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'       => 'stock',
            'caption'  => $this->trans('product.label.stock'),
            'editable' => true,
            'filter'   => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'       => 'weight',
            'caption'  => $this->trans('product.label.weight'),
            'editable' => true,
            'filter'   => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsInterface $options)
    {
        parent::configureOptions($options);

        $eventHandlers = $options->getEventHandlers();

        $eventHandlers->add(new UpdateRowEventHandler([
            'function' => $this->getJavascriptFunctionName('update'),
            'route'    => $this->getActionUrl('update'),
        ]));
    }
}
