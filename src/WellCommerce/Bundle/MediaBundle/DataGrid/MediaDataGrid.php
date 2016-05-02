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
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\LoadedEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\ProcessEventHandler;
use WellCommerce\Component\DataGrid\DataGridInterface;
use WellCommerce\Component\DataGrid\Options\OptionsInterface;

/**
 * Class MediaDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('common.label.id'),
            'sorting'    => new Sorting([
                'default_order' => Sorting::SORT_DIR_DESC,
            ]),
            'appearance' => new Appearance([
                'visible' => false,
            ]),
            'filter'     => new Filter([
                'type' => Filter ::FILTER_BETWEEN,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'preview',
            'caption'    => $this->trans('common.label.preview'),
            'appearance' => new Appearance([
                'width' => 30,
                'align' => Appearance::ALIGN_CENTER,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'      => 'name',
            'caption' => $this->trans('common.label.name'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'mime',
            'caption' => $this->trans('common.label.mime'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'extension',
            'caption' => $this->trans('common.label.extension'),
        ]));
        
        $collection->add(new Column([
            'id'      => 'size',
            'caption' => $this->trans('common.label.size'),
        ]));
    }
    
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsInterface $options)
    {
        $eventHandlers = $options->getEventHandlers();
        
        $eventHandlers->add(new LoadEventHandler([
            'function' => $this->getJavascriptFunctionName('load'),
            'route'    => $this->getActionUrl('grid'),
        ]));
        
        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $this->getJavascriptFunctionName('delete'),
            'row_action' => DataGridInterface::ACTION_DELETE,
            'route'      => $this->getActionUrl('delete'),
        ]));
        
        $eventHandlers = $options->getEventHandlers();
        
        $eventHandlers->add(new ProcessEventHandler([
            'function' => $this->getJavascriptFunctionName('process'),
        ]));
        
        $eventHandlers->add(new LoadedEventHandler([
            'function' => $this->getJavascriptFunctionName('data_loaded'),
        ]));
    }
}
