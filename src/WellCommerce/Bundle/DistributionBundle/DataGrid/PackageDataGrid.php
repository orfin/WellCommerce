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
namespace WellCommerce\Bundle\DistributionBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\ClickRowEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\CustomRowEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Component\DataGrid\Options\OptionsInterface;

/**
 * Class PackageDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
final class PackageDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('package.label.id'),
            'sorting'    => new Sorting([
                'default_order' => Sorting::SORT_DIR_DESC,
            ]),
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
            'caption'    => $this->trans('package.label.name'),
            'appearance' => new Appearance([
                'width' => 190,
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'fullName',
            'caption'    => $this->trans('package.label.full_name'),
            'appearance' => new Appearance([
                'width' => 190,
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'vendor',
            'caption'    => $this->trans('package.label.vendor'),
            'appearance' => new Appearance([
                'width' => 90,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'localVersion',
            'caption'    => $this->trans('package.label.local_version'),
            'appearance' => new Appearance([
                'width' => 90,
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'remoteVersion',
            'caption'    => $this->trans('package.label.remote_version'),
            'appearance' => new Appearance([
                'width' => 90,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'createdAt',
            'caption'    => $this->trans('package.label.created_at'),
            'appearance' => new Appearance([
                'width' => 90,
                'align' => Appearance::ALIGN_CENTER
            ]),
        ]));

        $collection->add(new Column([
            'id'         => 'updatedAt',
            'caption'    => $this->trans('package.label.updated_at'),
            'appearance' => new Appearance([
                'width' => 90,
                'align' => Appearance::ALIGN_CENTER
            ]),
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

        $eventHandlers->add(new ClickRowEventHandler([
            'function' => $this->getJavascriptFunctionName('click'),
            'route'    => $this->getActionUrl('edit'),
        ]));

        $eventHandlers->add(new CustomRowEventHandler([
            'function'      => $this->getJavascriptFunctionName('install'),
            'function_name' => 'installPackage',
            'row_action'    => 'action_installPackage'
        ]));

        $eventHandlers->add(new CustomRowEventHandler([
            'function'      => $this->getJavascriptFunctionName('update'),
            'function_name' => 'updatePackage',
            'row_action'    => 'action_updatePackage'
        ]));

        $eventHandlers->add(new CustomRowEventHandler([
            'function'      => $this->getJavascriptFunctionName('remove'),
            'function_name' => 'removePackage',
            'row_action'    => 'action_removePackage'
        ]));
    }
}
