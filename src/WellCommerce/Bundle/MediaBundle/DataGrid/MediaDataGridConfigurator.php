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

use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\DeleteRowEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\LoadedEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\LoadEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\EventHandler\ProcessEventHandler;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configuration\OptionInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configurator\AbstractConfigurator;
use WellCommerce\Bundle\CoreBundle\DataGrid\Configurator\ConfiguratorInterface;
use WellCommerce\Bundle\CoreBundle\DataGrid\DataGridInterface;

/**
 * Class MediaDataGridConfigurator
 *
 * @package WellCommerce\Bundle\MediaBundle\DataGrid
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class MediaDataGridConfigurator extends AbstractConfigurator implements ConfiguratorInterface
{
    public function configure(DataGridInterface $datagrid)
    {
        $datagrid->setIdentifier($this->identifier);

        $eventHandlers = $this->manager->getOptions()->getEventHandlers();

        $eventHandlers->add(new LoadEventHandler([
            'function' => $this->getFunction('load'),
            'route'    => $this->manager->getRouteForAction('grid')
        ]));

        $eventHandlers->add(new ProcessEventHandler([
            'function' => $this->getFunction('process')
        ]));

        $eventHandlers->add(new LoadedEventHandler([
            'function' => $this->getFunction('data_loaded')
        ]));

        $eventHandlers->add(new DeleteRowEventHandler([
            'function'   => $this->getFunction('delete'),
            'row_action' => OptionInterface::ACTION_DELETE,
            'route'      => $this->manager->getRouteForAction('delete')
        ]));

        $datagrid->setRepository($this->repository);

        $datagrid->setManager($this->manager);
    }
}