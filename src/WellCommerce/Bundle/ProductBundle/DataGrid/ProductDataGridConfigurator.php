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

namespace WellCommerce\Bundle\ProductBundle\DataGrid;

use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\ClickRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\EditRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\UpdateRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\OptionInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configurator\AbstractConfigurator;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configurator\ConfiguratorInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class ProductDataGridConfigurator
 *
 * @package WellCommerce\Bundle\ProductBundle\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class ProductDataGridConfigurator extends AbstractConfigurator implements ConfiguratorInterface
{
    public function configure(DataGridInterface $datagrid)
    {
        $datagrid->setIdentifier($this->identifier);

        $eventHandlers = $this->manager->getOptions()->getEventHandlers();

        $eventHandlers->add(new LoadEventHandler([
            'function' => $this->getFunction('load'),
            'route'    => $this->manager->getRouteForAction('grid')
        ]));

        $eventHandlers->add(new EditRowEventHandler([
            'function'   => $this->getFunction('edit'),
            'row_action' => OptionInterface::ACTION_EDIT,
            'route'      => $this->manager->getRouteForAction('edit')
        ]));

        $eventHandlers->add(new ClickRowEventHandler([
            'function' => $this->getFunction('click'),
            'route'    => $this->manager->getRouteForAction('edit')
        ]));

        $eventHandlers->add(new UpdateRowEventHandler([
            'function' => $this->getFunction('update'),
            'route'    => $this->manager->getRouteForAction('update')
        ]));

//        $eventHandlers->add(new ProcessEventHandler([
//            'function' => $this->getFunction('process')
//        ]));
//
//        $eventHandlers->add(new LoadedEventHandler([
//            'function' => $this->getFunction('data_loaded')
//        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $this->getFunction('delete'),
            'row_action' => OptionInterface::ACTION_DELETE,
            'route'      => $this->manager->getRouteForAction('delete')
        ]));

        $datagrid->setRepository($this->repository);

        $datagrid->setManager($this->manager);
    }
}