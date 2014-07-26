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

namespace WellCommerce\Client\DataGrid;

use WellCommerce\Core\DataGrid\Configuration\EventHandler\DeleteGroupEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Core\DataGrid\Configuration\EventHandlers;
use WellCommerce\Core\DataGrid\Configuration\OptionInterface;
use WellCommerce\Core\DataGrid\Configurator\AbstractConfigurator;
use WellCommerce\Core\DataGrid\Configurator\ConfiguratorInterface;
use WellCommerce\Core\DataGrid\DataGridInterface;

/**
 * Class ClientDataGridConfigurator
 *
 * @package WellCommerce\Client\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ClientDataGridConfigurator extends AbstractConfigurator implements ConfiguratorInterface
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
            'route'      => $this->generateUrl('admin.client.edit')
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $function = $this->getFunction('delete'),
            'callback'   => $this->getXajaxManager()->register([$function, $datagrid, 'delete']),
            'row_action' => OptionInterface::ACTION_DELETE,
        ]));

        $eventHandlers->add(new DeleteGroupEventHandler([
            'function'     => $function = $this->getFunction('deleteGroup'),
            'callback'     => $this->getXajaxManager()->register([$function, $datagrid, 'deleteGroup']),
            'group_action' => OptionInterface::ACTION_DELETE_GROUP
        ]));

        $datagrid->setOptions($this->options);
    }
}