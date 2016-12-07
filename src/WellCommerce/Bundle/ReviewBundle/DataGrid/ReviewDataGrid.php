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
namespace WellCommerce\Bundle\ReviewBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\AbstractDataGrid;
use WellCommerce\Component\DataGrid\Column\Column;
use WellCommerce\Component\DataGrid\Column\ColumnCollection;
use WellCommerce\Component\DataGrid\Column\Options\Appearance;
use WellCommerce\Component\DataGrid\Column\Options\Filter;
use WellCommerce\Component\DataGrid\Column\Options\Sorting;
use WellCommerce\Component\DataGrid\Configuration\EventHandler\CustomRowEventHandler;
use WellCommerce\Component\DataGrid\Options\OptionsInterface;

/**
 * Class ReviewDataGrid
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ReviewDataGrid extends AbstractDataGrid
{
    /**
     * {@inheritdoc}
     */
    public function configureColumns(ColumnCollection $collection)
    {
        $collection->add(new Column([
            'id'         => 'id',
            'caption'    => $this->trans('review.label.id'),
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
            'id'         => 'nick',
            'caption'    => $this->trans('review.label.nick'),
            'appearance' => new Appearance([
                'width' => 70,
                'align' => Appearance::ALIGN_CENTER,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'createdAt',
            'caption'    => $this->trans('review.label.created_at'),
            'appearance' => new Appearance([
                'width' => 70,
                'align' => Appearance::ALIGN_CENTER,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'product',
            'caption'    => $this->trans('review.label.product'),
            'appearance' => new Appearance([
                'width' => 70,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_INPUT,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'review',
            'caption'    => $this->trans('review.label.review'),
            'appearance' => new Appearance([
                'width' => 200,
            ]),
        ]));
        
        $collection->add(new Column([
            'id'         => 'rating',
            'caption'    => $this->trans('review.label.rating'),
            'appearance' => new Appearance([
                'width' => 70,
                'align' => Appearance::ALIGN_CENTER,
            ]),
            'filter'     => new Filter([
                'type' => Filter::FILTER_BETWEEN,
            ]),
        ]));
    }
    
    protected function configureOptions(OptionsInterface $options)
    {
        parent::configureOptions($options);
        
        $eventHandlers = $options->getEventHandlers();
        
        $eventHandlers->add(new CustomRowEventHandler([
            'function'      => $this->getJavascriptFunctionName('enableOpinion'),
            'function_name' => 'enableOpinion',
            'row_action'    => 'action_enableOpinion'
        ]));
        
        $eventHandlers->add(new CustomRowEventHandler([
            'function'      => $this->getJavascriptFunctionName('disableOpinion'),
            'function_name' => 'disableOpinion',
            'row_action'    => 'action_disableOpinion'
        ]));
    }
}
