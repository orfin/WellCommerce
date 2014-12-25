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
namespace WellCommerce\Bundle\MediaBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Column;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\ColumnCollection;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Appearance;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Filter;
use WellCommerce\Bundle\CoreBundle\DataGrid\Column\Options\Sorting;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\LoadedEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\ProcessEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Options\OptionsInterface;

/**
 * Class MediaDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaDataGrid extends AbstractDataGrid implements DataGridInterface
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('media.id'),
            'sorting'    => new Sorting([
                'default_order' => Sorting::SORT_DIR_DESC
            ]),
            'appearance' => new Appearance([
                'width'   => 90,
                'visible' => false
            ]),
            'filter'     => new Filter([
                'type' => Filter ::FILTER_BETWEEN
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'preview',
            'caption'    => $this->trans('media.preview'),
            'appearance' => new Appearance([
                'width' => 30,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'name',
            'caption'    => $this->trans('media.name'),
            'appearance' => new Appearance([
                'width' => 70
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'mime',
            'caption'    => $this->trans('media.mime'),
            'appearance' => new Appearance([
                'width' => 70
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'extension',
            'caption'    => $this->trans('media.extension'),
            'appearance' => new Appearance([
                'width' => 70
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ])
        ]));

        $collection->add(new Column([
            'id'         => 'size',
            'caption'    => $this->trans('media.size'),
            'appearance' => new Appearance([
                'width' => 70
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT
            ])
        ]));

    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsInterface $options)
    {
        parent::configureOptions($options);

        $eventHandlers = $options->getEventHandlers();

        $eventHandlers->add(new ProcessEventHandler([
            'function' => $this->getJavascriptFunctionName('process')
        ]));

        $eventHandlers->add(new LoadedEventHandler([
            'function' => $this->getJavascriptFunctionName('data_loaded')
        ]));
    }
}