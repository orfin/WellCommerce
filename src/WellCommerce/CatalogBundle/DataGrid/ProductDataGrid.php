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
namespace WellCommerce\CatalogBundle\DataGrid;

use WellCommerce\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\UpdateRowEventHandler;
use WellCommerce\Component\DataGrid\Options\OptionsInterface;

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
            'caption'    => $this->trans('common.label.id'),
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
            'caption'    => $this->trans('common.label.name'),
            'appearance' => new Appearance([
                'width' => 200,
            ]),
        ]));

        $collection->add(new Column([
            'id'       => 'sku',
            'editable' => true,
            'caption'  => $this->trans('common.label.sku'),
        ]));

        $collection->add(new Column([
            'id'      => 'category',
            'caption' => $this->trans('common.label.categories'),
        ]));

        $collection->add(new Column([
            'id'       => 'grossAmount',
            'caption'  => $this->trans('common.label.gross_price'),
            'editable' => true,
            'filter'   => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'       => 'stock',
            'caption'  => $this->trans('common.label.stock'),
            'editable' => true,
            'filter'   => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));

        $collection->add(new Column([
            'id'       => 'weight',
            'caption'  => $this->trans('common.label.dimension.weight'),
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
