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
namespace WellCommerce\Bundle\ClientBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\LoadedEventHandler;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\ProcessEventHandler;
use WellCommerce\Component\DataGrid\Options\OptionsInterface;

/**
 * Class ClientDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataGrid extends AbstractDataGrid
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
                'width'   => 60,
                'visible' => false,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'firstName',
            'caption'    => $this->trans('common.label.first_name'),
            'appearance' => new Appearance([
                'width' => 60,
                'align' => Appearance::ALIGN_LEFT,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'lastName',
            'caption'    => $this->trans('common.label.last_name'),
            'appearance' => new Appearance([
                'width' => 80,
                'align' => Appearance::ALIGN_LEFT,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'companyName',
            'caption'    => $this->trans('client.label.address.company'),
            'appearance' => new Appearance([
                'width' => 100,
                'align' => Appearance::ALIGN_CENTER,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'vatId',
            'caption'    => $this->trans('client.label.address.vat_id'),
            'appearance' => new Appearance([
                'width' => 60,
                'align' => Appearance::ALIGN_CENTER,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'email',
            'caption'    => $this->trans('common.label.email'),
            'appearance' => new Appearance([
                'width' => 60,
                'align' => Appearance::ALIGN_CENTER,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'phone',
            'caption'    => $this->trans('common.label.phone'),
            'appearance' => new Appearance([
                'width' => 80,
                'align' => Appearance::ALIGN_CENTER,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'groupName',
            'caption'    => $this->trans('common.label.client_group'),
            'filter'     => new Filter([
                'type'    => Filter::FILTER_SELECT,
                'options' => $this->get('client_group.dataset.admin')->getResult('select', ['order_by' => 'id'], [
                    'label_column' => 'name',
                    'value_column' => 'name',
                ]),
            ]),
            'appearance' => new Appearance([
                'width' => 100,
                'align' => Appearance::ALIGN_CENTER,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'createdAt',
            'caption'    => $this->trans('common.label.created_at'),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
            'appearance' => new Appearance([
                'width' => 40,
                'align' => Appearance::ALIGN_CENTER,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'lastActive',
            'caption'    => $this->trans('client.label.last_active'),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
            'appearance' => new Appearance([
                'width' => 60,
                'align' => Appearance::ALIGN_CENTER,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'cart',
            'caption'    => $this->trans('client.label.cart'),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
            'appearance' => new Appearance([
                'width' => 60,
                'align' => Appearance::ALIGN_CENTER,
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
        
        $eventHandlers->add(new ProcessEventHandler([
            'function' => $this->getJavascriptFunctionName('process'),
        ]));
        
        $eventHandlers->add(new LoadedEventHandler([
            'function' => $this->getJavascriptFunctionName('loaded'),
        ]));
    }
}
