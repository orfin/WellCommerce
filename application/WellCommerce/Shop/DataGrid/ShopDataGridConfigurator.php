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

namespace WellCommerce\Shop\DataGrid;

use WellCommerce\Core\DataGrid\Configuration\Appearance;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\DeleteGroupEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\UpdateRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandlers;
use WellCommerce\Core\DataGrid\Configuration\Filter\Filter;
use WellCommerce\Core\DataGrid\Configuration\OptionInterface;
use WellCommerce\Core\DataGrid\Configurator\AbstractConfigurator;
use WellCommerce\Core\DataGrid\Configurator\ConfiguratorInterface;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class ShopDataGridConfigurator
 *
 * @package WellCommerce\Shop\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ShopDataGridConfigurator extends AbstractConfigurator implements ConfiguratorInterface
{
    /**
     * {@inheritdoc}
     */
    public function configure(DataGridInterface $datagrid)
    {
        $datagrid->setIdentifier($this->identifier);

        $datagrid->setColumns($this->columns);

        $datagrid->setQueryBuilder($this->queryBuilder);

        $eventHandlers = $this->options->getEventHandlers();

        $eventHandlers->add(new LoadEventHandler([
            'function' => $this->getXajaxManager()->register([$this->getFunction('load'), $datagrid, 'load']),
        ]));

        $eventHandlers->add(new EditRowEventHandler([
            'function'   => $function = $this->getFunction('edit'),
            'callback'   => $function,
            'row_action' => OptionInterface::ACTION_EDIT,
            'route'      => $this->generateUrl('admin.shop.edit')
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $function = $this->getFunction('delete'),
            'callback'   => $this->getXajaxManager()->register([$function, $datagrid, 'delete']),
            'row_action' => OptionInterface::ACTION_DELETE,
        ]));

        $eventHandlers->add(new UpdateRowEventHandler([
            'function' => $this->getXajaxManager()->register([$this->getFunction('update'), $datagrid, 'update']),
        ]));

        $filters = $this->options->getFilters();

        $filters->add(new Filter('layout_theme_id', $this->get('layout_theme.repository')->getAllLayoutThemeToFilter()));
        $filters->add(new Filter('offline', $this->getOfflineFilterOptions()));

        $datagrid->setOptions($this->options);
    }

    /**
     * Returns options for offline filter
     *
     * @return array
     */
    private function getOfflineFilterOptions()
    {
        $options   = [];
        $options[] = [
            'id'      => 0,
            'caption' => $this->trans('Offline'),
        ];
        $options[] = [
            'id'      => 1,
            'caption' => $this->trans('Online'),
        ];

        return $options;
    }
}